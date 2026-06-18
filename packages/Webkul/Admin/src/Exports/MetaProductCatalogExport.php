<?php

namespace Webkul\Admin\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MetaProductCatalogExport
{
    /**
     * Generate the Meta product catalog CSV and return it as a streamed download.
     */
    public function download(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $products = $this->fetchProducts();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="meta-product-catalog.csv"',
            'Cache-Control'       => 'no-store, no-cache',
        ];

        return response()->stream(function () use ($products) {
            $handle = fopen('php://output', 'w');

            // BOM for Excel UTF-8 compatibility
            fputs($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'id',
                'title',
                'description',
                'availability',
                'condition',
                'price',
                'link',
                'image_link',
                'brand',
                'sale_price',
            ]);

            foreach ($products as $product) {
                fputcsv($handle, $this->map($product));
            }

            fclose($handle);
        }, 200, $headers);
    }

    protected function fetchProducts(): \Illuminate\Support\Collection
    {
        $locale  = app()->getLocale();
        $channel = core()->getRequestedChannelCode();
        $baseUrl = rtrim(config('app.url'), '/');

        // Laravel prefixes both the table name AND the alias (e.g. "pf" → "mazzpf"),
        // so raw SQL fragments must use the prefixed alias names too.
        $pfx = DB::getTablePrefix();

        return DB::table('product_flat as pf')
            ->leftJoin('products as p', 'pf.product_id', '=', 'p.id')
            ->leftJoin('product_images as pi', function ($join) use ($pfx) {
                $join->on('pf.product_id', '=', 'pi.product_id')
                    ->whereRaw(
                        "`{$pfx}pi`.id = (SELECT MIN(id) FROM `{$pfx}product_images` pi2 WHERE pi2.product_id = `{$pfx}pf`.product_id)"
                    );
            })
            ->select(
                'p.id',
                'pf.sku',
                'pf.name',
                'pf.description',
                'pf.short_description',
                'pf.price',
                'pf.special_price',
                'pf.url_key',
                'pf.type',
                'pi.path as image_path',
                DB::raw("(SELECT COALESCE(SUM(qty),0) FROM `{$pfx}product_inventories` WHERE product_id = `{$pfx}pf`.product_id) as qty"),
            )
            ->where('pf.locale', $locale)
            ->where('pf.channel', $channel)
            ->where('pf.status', 1)
            ->where('pf.visible_individually', 1)
            ->whereNotNull('pf.url_key')
            ->whereNotIn('pf.type', ['configurable', 'grouped', 'bundle'])
            ->get();
    }

    protected function map(object $product): array
    {
        $currency = core()->getBaseCurrencyCode();

        $price     = number_format((float) ($product->price ?? 0), 2, '.', '') . ' ' . $currency;
        $salePrice = '';

        if (! empty($product->special_price) && (float) $product->special_price < (float) $product->price) {
            $salePrice = number_format((float) $product->special_price, 2, '.', '') . ' ' . $currency;
        }

        $availability = ((int) $product->qty > 0) ? 'in stock' : 'out of stock';

        $link = rtrim(config('app.url'), '/') . '/' . $product->url_key;

        $imageLink = '';
        if (! empty($product->image_path)) {
            $imageLink = Storage::url($product->image_path);
            // Ensure absolute URL
            if (! str_starts_with($imageLink, 'http')) {
                $imageLink = rtrim(config('app.url'), '/') . $imageLink;
            }
        }

        $description = strip_tags($product->short_description ?: $product->description ?: '');
        $description = preg_replace('/\s+/', ' ', trim($description));

        return [
            $product->sku ?: $product->id,
            $product->name ?? '',
            $description,
            $availability,
            'new',
            $price,
            $link,
            $imageLink,
            '',       // brand — left blank; add your own logic if you have a brand attribute
            $salePrice,
        ];
    }
}
