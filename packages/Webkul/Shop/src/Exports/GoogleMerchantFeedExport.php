<?php

namespace Webkul\Shop\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GoogleMerchantFeedExport
{
    /**
     * Generate the Google Merchant Center product feed CSV and return it as a streamed response.
     */
    public function download(): StreamedResponse
    {
        $products = $this->fetchProducts();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'inline; filename="google-merchant-feed.csv"',
            'Cache-Control' => 'no-store, no-cache',
        ];

        return response()->stream(function () use ($products) {
            $handle = fopen('php://output', 'w');

            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'id',
                'title',
                'description',
                'link',
                'image_link',
                'availability',
                'price',
                'sale_price',
                'brand',
                'condition',
                'identifier_exists',
            ], ',', '"', '\\');

            foreach ($products as $product) {
                fputcsv($handle, $this->map($product), ',', '"', '\\');
            }

            fclose($handle);
        }, 200, $headers);
    }

    protected function fetchProducts(): Collection
    {
        $locale = app()->getLocale();
        $channel = core()->getRequestedChannelCode();

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
            ->leftJoin('product_attribute_values as pav', function ($join) use ($pfx) {
                $join->on('pf.product_id', '=', 'pav.product_id')
                    ->whereRaw(
                        "`{$pfx}pav`.attribute_id = (SELECT id FROM `{$pfx}attributes` WHERE code = 'brand' LIMIT 1)"
                    );
            })
            ->leftJoin('attribute_options as ao', 'ao.id', '=', 'pav.integer_value')
            ->leftJoin('attribute_option_translations as aot', function ($join) use ($locale) {
                $join->on('aot.attribute_option_id', '=', 'ao.id')
                    ->where('aot.locale', $locale);
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
                'aot.label as brand',
                DB::raw("(SELECT COALESCE(SUM(qty),0) FROM `{$pfx}product_inventories` WHERE product_id = `{$pfx}pf`.product_id) as qty"),
            )
            ->where('pf.locale', $locale)
            ->where('pf.channel', $channel)
            ->where('pf.status', 1)
            ->where('pf.visible_individually', 1)
            ->where('p.hide_price', 0)
            ->where('pf.price', '>', 0)
            ->whereNotNull('pf.url_key')
            ->whereNotIn('pf.type', ['configurable', 'grouped', 'bundle'])
            ->get();
    }

    protected function map(object $product): array
    {
        $currency = core()->getBaseCurrencyCode();

        $price = number_format((float) ($product->price ?? 0), 2, '.', '').' '.$currency;
        $salePrice = '';

        if (! empty($product->special_price) && (float) $product->special_price < (float) $product->price) {
            $salePrice = number_format((float) $product->special_price, 2, '.', '').' '.$currency;
        }

        $availability = ((int) $product->qty > 0) ? 'in stock' : 'out of stock';

        $link = rtrim(config('app.url'), '/').'/'.$product->url_key;

        $imageLink = '';
        if (! empty($product->image_path)) {
            $imageLink = Storage::url($product->image_path);

            if (! str_starts_with($imageLink, 'http')) {
                $imageLink = rtrim(config('app.url'), '/').$imageLink;
            }
        }

        $description = strip_tags($product->short_description ?: $product->description ?: '');
        $description = preg_replace('/\s+/', ' ', trim($description));

        $brand = $product->brand ?? '';

        return [
            $product->sku ?: $product->id,
            $product->name ?? '',
            $description,
            $link,
            $imageLink,
            $availability,
            $price,
            $salePrice,
            $brand,
            'new',
            $brand ? '' : 'no',
        ];
    }
}
