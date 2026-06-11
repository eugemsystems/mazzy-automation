<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WooCommerceImporter
{
    protected string $locale = 'en';

    protected string $channel = 'default';

    protected array $attributes = [];

    protected int $rootRgt = 2;

    protected const ATTRIBUTE_TYPE_FIELDS = [
        'text'        => 'text_value',
        'textarea'    => 'text_value',
        'price'       => 'float_value',
        'boolean'     => 'boolean_value',
        'select'      => 'integer_value',
        'multiselect' => 'text_value',
        'datetime'    => 'datetime_value',
        'date'        => 'date_value',
        'file'        => 'text_value',
        'image'       => 'text_value',
        'checkbox'    => 'text_value',
    ];

    /**
     * Run the full import: wipe products + non-root categories, then seed fresh data.
     *
     * @param  array  $data  Parsed JSON (categories + products keys)
     * @param  callable|null  $progress  fn(int $done, int $total)
     */
    public function import(array $data, ?callable $progress = null): array
    {
        $this->attributes = DB::table('attributes')->get()->all();

        $this->deleteExistingProducts();
        $this->deleteExistingCategories();

        $categoryMap = $this->importCategories($data['categories'] ?? []);

        $products = $data['products'] ?? [];
        $total    = count($products);
        $imported = 0;
        $failed   = 0;
        $errors   = [];

        foreach ($products as $productData) {
            try {
                $this->importSingleProduct($productData, $categoryMap);
                $imported++;
            } catch (\Throwable $e) {
                $failed++;
                $errors[] = ($productData['sku'] ?? 'unknown').': '.$e->getMessage();
            }

            if ($progress) {
                $progress($imported + $failed, $total);
            }

            unset($productData);
            gc_collect_cycles();
        }

        return compact('imported', 'failed', 'errors');
    }

    // -------------------------------------------------------------------------
    // Cleanup
    // -------------------------------------------------------------------------

    protected function deleteExistingProducts(): void
    {
        DB::table('product_flat')->delete();
        DB::table('products')->delete();
    }

    protected function deleteExistingCategories(): void
    {
        DB::table('category_filterable_attributes')->where('category_id', '!=', 1)->delete();
        DB::table('categories')->where('id', '!=', 1)->delete();
    }

    // -------------------------------------------------------------------------
    // Categories
    // -------------------------------------------------------------------------

    protected function importCategories(array $categories): array
    {
        // Sort so parents always appear before their children.
        usort($categories, fn ($a, $b) => (int) ($a['parent_slug'] !== null) - (int) ($b['parent_slug'] !== null));

        $slugToId = ['root' => 1];
        $nextId   = 2;
        $rows     = [];

        foreach ($categories as $cat) {
            $id       = $nextId++;
            $parentId = isset($cat['parent_slug']) && $cat['parent_slug']
                ? ($slugToId[$cat['parent_slug']] ?? 1)
                : 1;

            $slugToId[$cat['slug']] = $id;

            $rows[] = [
                'id'          => $id,
                'name'        => $cat['name'],
                'slug'        => $cat['slug'],
                'description' => $cat['description'] ?? '',
                'parent_id'   => $parentId,
                'parent_slug' => $cat['parent_slug'] ?? null,
            ];
        }

        // Compute Kalnoy nested-set _lft/_rgt values.
        $this->computeNestedSet($rows);

        $now = now();

        foreach ($rows as $row) {
            DB::table('categories')->insert([
                'id'           => $row['id'],
                'position'     => 1,
                'status'       => 1,
                'display_mode' => 'products_and_description',
                '_lft'         => $row['_lft'],
                '_rgt'         => $row['_rgt'],
                'parent_id'    => $row['parent_id'],
                'logo_path'    => null,
                'banner_path'  => null,
                'additional'   => null,
                'created_at'   => $now,
                'updated_at'   => $now,
            ]);

            $urlPath = $this->buildUrlPath($row, $rows);

            DB::table('category_translations')->insert([
                'category_id'      => $row['id'],
                'name'             => $row['name'],
                'slug'             => $row['slug'],
                'url_path'         => $urlPath,
                'description'      => $row['description'],
                'meta_title'       => $row['name'],
                'meta_description' => '',
                'meta_keywords'    => '',
                'locale_id'        => null,
                'locale'           => $this->locale,
            ]);
        }

        // Update root's right boundary to encompass all new categories.
        DB::table('categories')->where('id', 1)->update(['_rgt' => $this->rootRgt]);

        return $slugToId;
    }

    protected function computeNestedSet(array &$rows): void
    {
        // Index rows by id and build parent->children lists.
        $byId    = [];
        $children = [1 => []];

        foreach ($rows as &$row) {
            $byId[$row['id']]              = &$row;
            $children[$row['parent_id']][] = &$row;
            $children[$row['id']]          = [];
        }
        unset($row);

        $counter = 2; // root _lft=1; first child starts at 2

        foreach ($children[1] as &$node) {
            $this->walkNode($node, $children, $counter);
        }

        $this->rootRgt = $counter; // root _rgt gets this value after all children
    }

    protected function walkNode(array &$node, array &$children, int &$counter): void
    {
        $node['_lft'] = $counter++;

        foreach ($children[$node['id']] as &$child) {
            $this->walkNode($child, $children, $counter);
        }
        unset($child);

        $node['_rgt'] = $counter++;
    }

    protected function buildUrlPath(array $row, array $rows): string
    {
        if ($row['parent_id'] === 1) {
            return $row['slug'];
        }

        // Find parent row.
        foreach ($rows as $r) {
            if ($r['id'] === $row['parent_id']) {
                return $r['slug'].'/'.$row['slug'];
            }
        }

        return $row['slug'];
    }

    // -------------------------------------------------------------------------
    // Products
    // -------------------------------------------------------------------------

    protected function importSingleProduct(array $productData, array $categoryMap): void
    {
        $now = now();

        $productId = DB::table('products')->insertGetId([
            'sku'                => $productData['sku'],
            'type'               => 'simple',
            'attribute_family_id'=> 1,
            'parent_id'          => null,
            'created_at'         => $now,
            'updated_at'         => $now,
        ]);

        $this->insertAttributeValues($productId, $productData);

        DB::table('product_channels')->insert([
            'product_id' => $productId,
            'channel_id' => 1,
        ]);

        foreach ($productData['category_slugs'] ?? [] as $slug) {
            $catId = $categoryMap[$slug] ?? null;
            if ($catId) {
                DB::table('product_categories')->insertOrIgnore([
                    'product_id'  => $productId,
                    'category_id' => $catId,
                ]);
            }
        }

        DB::table('product_inventories')->insert([
            'product_id'          => $productId,
            'inventory_source_id' => 1,
            'qty'                 => (int) ($productData['qty'] ?? 100),
        ]);

        $position = 1;

        foreach ($productData['images'] ?? [] as $imageUrl) {
            $path = $this->downloadImage((string) $imageUrl, $productId);

            if ($path) {
                DB::table('product_images')->insert([
                    'type'       => null,
                    'path'       => $path,
                    'product_id' => $productId,
                    'position'   => $position++,
                ]);
            }
        }
    }

    protected function insertAttributeValues(int $productId, array $productData): void
    {
        $attrValues = [
            'name'                => $productData['name'] ?? '',
            'url_key'             => $productData['url_key'] ?? Str::slug($productData['name'] ?? ''),
            'short_description'   => $productData['short_description'] ?? '',
            'description'         => $productData['description'] ?? '',
            'meta_title'          => $productData['meta_title'] ?? ($productData['name'] ?? ''),
            'meta_keywords'       => $productData['meta_keywords'] ?? '',
            'meta_description'    => $productData['meta_description'] ?? '',
            'price'               => (float) ($productData['price'] ?? 0),
            'special_price'       => $productData['special_price'] ? (float) $productData['special_price'] : null,
            'weight'              => (string) ($productData['weight'] ?? '1'),
            'status'              => 1,
            'new'                 => (int) (bool) ($productData['new'] ?? false),
            'featured'            => (int) (bool) ($productData['featured'] ?? false),
            'visible_individually'=> 1,
        ];

        $nullColumns = array_fill_keys(['text_value', 'float_value', 'boolean_value', 'integer_value', 'datetime_value', 'date_value'], null);
        $attributes  = collect($this->attributes);
        $seen        = [];
        $rows        = [];

        foreach ($attrValues as $code => $value) {
            if ($value === null) {
                continue;
            }

            $attr = $attributes->firstWhere('code', $code);

            if (! $attr) {
                continue;
            }

            $channel    = $attr->value_per_channel ? $this->channel : null;
            $locale     = $attr->value_per_locale  ? $this->locale  : null;
            $uniqueId   = collect([$channel, $locale, $productId, $attr->id])->filter()->implode('|');

            if (isset($seen[$uniqueId])) {
                continue;
            }

            $seen[$uniqueId] = true;
            $valueCol        = self::ATTRIBUTE_TYPE_FIELDS[$attr->type] ?? 'text_value';

            $rows[] = array_merge($nullColumns, [
                'attribute_id' => $attr->id,
                'product_id'   => $productId,
                'channel'      => $channel,
                'locale'       => $locale,
                'unique_id'    => $uniqueId,
                'json_value'   => null,
                $valueCol      => $value,
            ]);
        }

        if ($rows) {
            collect($rows)->chunk(200)->each(fn ($chunk) => DB::table('product_attribute_values')->insert($chunk->all()));
        }
    }

    // -------------------------------------------------------------------------
    // Image download
    // -------------------------------------------------------------------------

    protected function downloadImage(string $url, int $productId): ?string
    {
        // Normalise common WooCommerce sitemap bug: /store/store/ → /store/
        $url = preg_replace('|(https?://[^/]+(?:/[^/]+)*)/([^/]+)/\2/|', '$1/$2/', $url) ?? $url;

        $attempts = [$url];

        // If the URL contains a doubled segment after the host, also try without the first occurrence.
        if (preg_match('|(https?://[^/]+)/([^/]+)/\2/|', $url, $m)) {
            $attempts[] = $m[1].'/'.$m[2].'/'.substr($url, strlen($m[0]));
        }

        foreach ($attempts as $attempt) {
            $path = $this->tryDownload($attempt, $productId);

            if ($path) {
                return $path;
            }
        }

        return null;
    }

    protected function tryDownload(string $url, int $productId): ?string
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'mazzy_img_');

        try {
            // Stream directly to a temp file — avoids loading the whole image body into PHP memory.
            $response = Http::timeout(20)->withHeaders([
                'User-Agent'      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'Accept'          => 'image/webp,image/apng,image/*,*/*;q=0.8',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Referer'         => config('app.url'),
            ])->sink($tempFile)->get($url);

            if (! $response->ok()) {
                return null;
            }

            // Detect extension from Content-Type header if URL path has none.
            $ext = pathinfo((string) parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);

            if (! $ext || ! in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $contentType = $response->header('Content-Type');
                $ext = match (true) {
                    str_contains($contentType, 'webp') => 'webp',
                    str_contains($contentType, 'png')  => 'png',
                    str_contains($contentType, 'gif')  => 'gif',
                    default                            => 'jpg',
                };
            }

            $filename = Str::uuid().'.'.strtolower($ext);
            $path     = "product/{$productId}/{$filename}";

            Storage::put($path, fopen($tempFile, 'r'));

            return $path;
        } catch (\Throwable) {
            return null;
        } finally {
            if (file_exists($tempFile)) {
                @unlink($tempFile);
            }
        }
    }
}
