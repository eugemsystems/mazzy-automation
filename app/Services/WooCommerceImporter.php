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

    /** @var array All rows from mazzattributes, keyed by code */
    protected array $attributesByCode = [];

    /** @var array attribute_id => [ option_value_lower => option_id ] */
    protected array $optionCache = [];

    protected int $rootRgt = 2;

    protected array $imageCache = [];

    protected const IMAGE_CACHE_FILE = 'woocommerce-image-cache.json';

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
     * Run the full import.
     */
    public function import(array $data, ?callable $progress = null): array
    {
        $this->loadAttributes();
        $this->loadImageCache();

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
    // Boot
    // -------------------------------------------------------------------------

    protected function loadAttributes(): void
    {
        $rows = DB::table('attributes')->get()->all();

        foreach ($rows as $row) {
            $this->attributesByCode[$row->code] = $row;
        }
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

        DB::table('categories')->where('id', 1)->update(['_rgt' => $this->rootRgt]);

        return $slugToId;
    }

    protected function computeNestedSet(array &$rows): void
    {
        $children = [1 => []];

        foreach ($rows as &$row) {
            $children[$row['parent_id']][] = &$row;
            $children[$row['id']]          = [];
        }
        unset($row);

        $counter = 2;

        foreach ($children[1] as &$node) {
            $this->walkNode($node, $children, $counter);
        }

        $this->rootRgt = $counter;
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

        foreach ($rows as $r) {
            if ($r['id'] === $row['parent_id']) {
                return $r['slug'].'/'.$row['slug'];
            }
        }

        return $row['slug'];
    }

    // -------------------------------------------------------------------------
    // Products — dispatch by type
    // -------------------------------------------------------------------------

    protected function importSingleProduct(array $productData, array $categoryMap): void
    {
        DB::beginTransaction();

        try {
            $type = $productData['type'] ?? 'simple';

            if ($type === 'configurable' && ! empty($productData['variations'])) {
                $this->importConfigurableProduct($productData, $categoryMap);
            } else {
                $this->importSimpleProduct($productData, $categoryMap, null);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // -------------------------------------------------------------------------
    // Simple product
    // -------------------------------------------------------------------------

    protected function importSimpleProduct(array $productData, array $categoryMap, ?int $parentId): int
    {
        $now = now();

        $productId = DB::table('products')->insertGetId([
            'sku'                 => $productData['sku'],
            'type'                => 'simple',
            'attribute_family_id' => 1,
            'parent_id'           => $parentId,
            'created_at'          => $now,
            'updated_at'          => $now,
        ]);

        $this->insertAttributeValues($productId, $productData, []);

        // Only top-level simple products get channel + category + inventory assignments.
        if ($parentId === null) {
            $this->attachToChannel($productId);
            $this->attachToCategories($productId, $productData['category_slugs'] ?? [], $categoryMap);
            $this->attachInventory($productId, (int) ($productData['qty'] ?? 100));
            $this->downloadAndAttachImages($productId, $productData['images'] ?? []);
        }

        return $productId;
    }

    // -------------------------------------------------------------------------
    // Configurable product
    // -------------------------------------------------------------------------

    protected function importConfigurableProduct(array $productData, array $categoryMap): void
    {
        $variations = $productData['variations'];
        $now        = now();

        // ── Determine which attribute codes vary across the variations ────────
        $variantAttributeCodes = $this->collectVariantAttributeCodes($variations);

        // ── Ensure each variant attribute exists in Bagisto ───────────────────
        $variantAttributeIds = [];
        foreach ($variantAttributeCodes as $code) {
            $variantAttributeIds[$code] = $this->getOrCreateSelectAttribute($code);
        }

        // ── Compute min price across all variations for the parent ────────────
        $allPrices = array_column($variations, 'price');
        $minPrice  = $allPrices ? min(array_filter($allPrices, fn ($p) => $p > 0)) : ($productData['price'] ?? 0);

        // ── Insert parent configurable product ────────────────────────────────
        $parentId = DB::table('products')->insertGetId([
            'sku'                 => $productData['sku'],
            'type'                => 'configurable',
            'attribute_family_id' => 1,
            'parent_id'           => null,
            'created_at'          => $now,
            'updated_at'          => $now,
        ]);

        // Override price with the minimum variant price on the parent.
        $parentData          = $productData;
        $parentData['price'] = round((float) $minPrice, 2);

        $this->insertAttributeValues($parentId, $parentData, []);

        $this->attachToChannel($parentId);
        $this->attachToCategories($parentId, $productData['category_slugs'] ?? [], $categoryMap);
        $this->attachInventory($parentId, 0); // Bagisto derives stock from children.
        $this->downloadAndAttachImages($parentId, $productData['images'] ?? []);

        // ── Link super attributes (the axes of variation) ─────────────────────
        foreach ($variantAttributeIds as $code => $attrId) {
            DB::table('product_super_attributes')->insertOrIgnore([
                'product_id'   => $parentId,
                'attribute_id' => $attrId,
            ]);
        }

        // ── Insert child simple products ──────────────────────────────────────
        foreach ($variations as $index => $variation) {
            $this->importVariationChild($variation, $productData, $parentId, $variantAttributeIds, $index);
        }
    }

    /**
     * Collect the set of attribute codes that actually vary across all variations
     * (i.e. codes whose value differs between at least some variations).
     */
    protected function collectVariantAttributeCodes(array $variations): array
    {
        $allCodes = [];
        foreach ($variations as $v) {
            foreach (array_keys($v['attributes'] ?? []) as $code) {
                $allCodes[$code] = true;
            }
        }
        return array_keys($allCodes);
    }

    /**
     * Get or create a select+configurable attribute for a variant axis (e.g. "gang", "color").
     * Returns the attribute id.
     */
    protected function getOrCreateSelectAttribute(string $code): int
    {
        // Check in-memory cache first.
        if (isset($this->attributesByCode[$code])) {
            return (int) $this->attributesByCode[$code]->id;
        }

        $now = now();

        $attrId = DB::table('attributes')->insertGetId([
            'code'                 => $code,
            'admin_name'           => Str::title(str_replace('_', ' ', $code)),
            'type'                 => 'select',
            'swatch_type'          => null,
            'validation'           => null,
            'regex'                => null,
            'position'             => 100,
            'is_required'          => 0,
            'is_unique'            => 0,
            'is_filterable'        => 1,
            'is_comparable'        => 0,
            'is_configurable'      => 1,
            'is_user_defined'      => 1,
            'is_visible_on_front'  => 1,
            'value_per_locale'     => 0,
            'value_per_channel'    => 0,
            'default_value'        => null,
            'enable_wysiwyg'       => 0,
            'created_at'           => $now,
            'updated_at'           => $now,
        ]);

        // Add to the default attribute group so it appears in admin.
        DB::table('attribute_group_mappings')->insertOrIgnore([
            'attribute_id'       => $attrId,
            'attribute_group_id' => 1,
            'position'           => 100,
        ]);

        // Cache it.
        $this->attributesByCode[$code] = (object) [
            'id'                => $attrId,
            'code'              => $code,
            'type'              => 'select',
            'value_per_channel' => 0,
            'value_per_locale'  => 0,
        ];

        return $attrId;
    }

    /**
     * Get or create an attribute option (e.g. "White" for "color").
     * Returns the option id.
     */
    protected function getOrCreateAttributeOption(int $attributeId, string $value): int
    {
        $key = strtolower(trim($value));

        if (isset($this->optionCache[$attributeId][$key])) {
            return $this->optionCache[$attributeId][$key];
        }

        // Load all existing options for this attribute on first access.
        if (! isset($this->optionCache[$attributeId])) {
            $this->optionCache[$attributeId] = [];
            $rows = DB::table('attribute_options')
                ->where('attribute_id', $attributeId)
                ->get(['id', 'admin_name']);

            foreach ($rows as $row) {
                $this->optionCache[$attributeId][strtolower(trim($row->admin_name))] = (int) $row->id;
            }
        }

        if (isset($this->optionCache[$attributeId][$key])) {
            return $this->optionCache[$attributeId][$key];
        }

        // Create the option.
        $optionId = DB::table('attribute_options')->insertGetId([
            'attribute_id' => $attributeId,
            'admin_name'   => $value,
            'sort_order'   => count($this->optionCache[$attributeId]),
            'swatch_value' => null,
        ]);

        // Also insert an attribute_option_translation for the locale.
        DB::table('attribute_option_translations')->insertOrIgnore([
            'attribute_option_id' => $optionId,
            'locale'              => $this->locale,
            'label'               => $value,
        ]);

        $this->optionCache[$attributeId][$key] = $optionId;

        return $optionId;
    }

    /**
     * Import one variation as a child simple product of the configurable parent.
     */
    protected function importVariationChild(
        array $variation,
        array $parentData,
        int $parentId,
        array $variantAttributeIds,   // ['color' => attrId, 'gang' => attrId, …]
        int $index
    ): void {
        $now = now();

        // Build child SKU: fall back to parent-sku + index if blank.
        $childSku = trim($variation['sku'] ?? '');
        if ($childSku === '') {
            $childSku = $parentData['sku'].'-var-'.($index + 1);
        }

        // Child url_key: parent slug + variant suffix.
        $attrSuffix = implode('-', array_map(
            fn ($v) => Str::slug($v),
            array_values($variation['attributes'])
        ));
        $childUrlKey = $parentData['url_key'].'-'.($attrSuffix ?: ($index + 1));

        $childProductId = DB::table('products')->insertGetId([
            'sku'                 => $childSku,
            'type'                => 'simple',
            'attribute_family_id' => 1,
            'parent_id'           => $parentId,
            'created_at'          => $now,
            'updated_at'          => $now,
        ]);

        // Build attribute values for the child: inherit parent descriptive fields,
        // override price + sku-level fields, add variant attribute option ids.
        $childData = [
            'name'              => $parentData['name'],
            'url_key'           => $childUrlKey,
            'short_description' => $parentData['short_description'] ?? '',
            'description'       => $parentData['description'] ?? '',
            'meta_title'        => $parentData['meta_title'] ?? $parentData['name'],
            'meta_keywords'     => $parentData['meta_keywords'] ?? '',
            'meta_description'  => $parentData['meta_description'] ?? '',
            'price'             => round((float) $variation['price'], 2),
            'special_price'     => $variation['sale_price'] !== null ? round((float) $variation['sale_price'], 2) : null,
            'weight'            => $parentData['weight'] ?? 1,
            'status'            => 1,
            'visible_individually' => 0,
        ];

        // Resolve each variant attribute value to an option id.
        $variantOptionIds = [];
        foreach ($variation['attributes'] as $code => $value) {
            if (! isset($variantAttributeIds[$code])) {
                continue;
            }
            $attrId   = $variantAttributeIds[$code];
            $optionId = $this->getOrCreateAttributeOption($attrId, $value);
            $variantOptionIds[$code] = ['attr_id' => $attrId, 'option_id' => $optionId];
        }

        $this->insertAttributeValues($childProductId, $childData, $variantOptionIds);

        // Inventory per child.
        DB::table('product_inventories')->insert([
            'product_id'          => $childProductId,
            'inventory_source_id' => 1,
            'qty'                 => (int) ($variation['in_stock'] ? 100 : 0),
        ]);

        // Per-variation image (if different from parent gallery).
        if (! empty($variation['image'])) {
            $path = $this->downloadImage($variation['image'], $childProductId);
            if ($path) {
                DB::table('product_images')->insert([
                    'type'       => null,
                    'path'       => $path,
                    'product_id' => $childProductId,
                    'position'   => 1,
                ]);
            }
        }
    }

    // -------------------------------------------------------------------------
    // Attribute values
    // -------------------------------------------------------------------------

    /**
     * @param  array  $variantOptionIds  ['color' => ['attr_id' => x, 'option_id' => y], …]
     */
    protected function insertAttributeValues(int $productId, array $productData, array $variantOptionIds): void
    {
        $baseUrlKey = $productData['url_key'] ?? Str::slug($productData['name'] ?? '');
        $urlKey     = $baseUrlKey;
        $suffix     = 2;

        while (DB::table('product_flat')->where('url_key', $urlKey)->exists()) {
            $urlKey = $baseUrlKey.'-'.$suffix++;
        }

        $isVisibleIndividually = isset($productData['visible_individually'])
            ? (int) $productData['visible_individually']
            : 1;

        $attrValues = [
            'name'                 => $productData['name'] ?? '',
            'url_key'              => $urlKey,
            'short_description'    => $this->sanitizeHtml($productData['short_description'] ?? ''),
            'description'          => $this->sanitizeHtml($productData['description'] ?? ''),
            'meta_title'           => $productData['meta_title'] ?? ($productData['name'] ?? ''),
            'meta_keywords'        => $productData['meta_keywords'] ?? '',
            'meta_description'     => $productData['meta_description'] ?? '',
            'price'                => (float) ($productData['price'] ?? 0),
            'special_price'        => isset($productData['special_price']) ? (float) $productData['special_price'] : null,
            'weight'               => (string) ($productData['weight'] ?? '1'),
            'status'               => 1,
            'manage_stock'         => 0,
            'new'                  => (int) (bool) ($productData['new'] ?? false),
            'featured'             => (int) (bool) ($productData['featured'] ?? false),
            'visible_individually' => $isVisibleIndividually,
        ];

        $nullColumns = array_fill_keys(['text_value', 'float_value', 'boolean_value', 'integer_value', 'datetime_value', 'date_value'], null);
        $seen        = [];
        $rows        = [];

        foreach ($attrValues as $code => $value) {
            if ($value === null) {
                continue;
            }

            $attr = $this->attributesByCode[$code] ?? null;

            if (! $attr) {
                continue;
            }

            $channelVal = $attr->value_per_channel ? $this->channel : null;
            $localeVal  = $attr->value_per_locale  ? $this->locale  : null;
            $uniqueId   = collect([$channelVal, $localeVal, $productId, $attr->id])->filter()->implode('|');

            if (isset($seen[$uniqueId])) {
                continue;
            }

            $seen[$uniqueId] = true;
            $valueCol        = self::ATTRIBUTE_TYPE_FIELDS[$attr->type] ?? 'text_value';

            $rows[] = array_merge($nullColumns, [
                'attribute_id' => $attr->id,
                'product_id'   => $productId,
                'channel'      => $channelVal,
                'locale'       => $localeVal,
                'unique_id'    => $uniqueId,
                'json_value'   => null,
                $valueCol      => $value,
            ]);
        }

        // Insert variant attribute values (select option ids).
        foreach ($variantOptionIds as $code => ['attr_id' => $attrId, 'option_id' => $optionId]) {
            $uniqueId = collect([null, null, $productId, $attrId])->filter()->implode('|');

            if (isset($seen[$uniqueId])) {
                continue;
            }

            $seen[$uniqueId] = true;

            $rows[] = array_merge($nullColumns, [
                'attribute_id'  => $attrId,
                'product_id'    => $productId,
                'channel'       => null,
                'locale'        => null,
                'unique_id'     => $uniqueId,
                'json_value'    => null,
                'integer_value' => $optionId,
            ]);
        }

        if ($rows) {
            collect($rows)->chunk(200)->each(fn ($chunk) => DB::table('product_attribute_values')->insert($chunk->all()));
        }
    }

    // -------------------------------------------------------------------------
    // Helpers: channel / categories / inventory / images
    // -------------------------------------------------------------------------

    protected function attachToChannel(int $productId): void
    {
        DB::table('product_channels')->insert([
            'product_id' => $productId,
            'channel_id' => 1,
        ]);
    }

    protected function attachToCategories(int $productId, array $catSlugs, array $categoryMap): void
    {
        foreach ($catSlugs as $slug) {
            $catId = $categoryMap[$slug] ?? null;

            if ($catId) {
                DB::table('product_categories')->insertOrIgnore([
                    'product_id'  => $productId,
                    'category_id' => $catId,
                ]);
            }
        }
    }

    protected function attachInventory(int $productId, int $qty): void
    {
        DB::table('product_inventories')->insert([
            'product_id'          => $productId,
            'inventory_source_id' => 1,
            'qty'                 => $qty,
        ]);
    }

    protected function downloadAndAttachImages(int $productId, array $imageUrls): void
    {
        $position = 1;

        foreach ($imageUrls as $imageUrl) {
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

    // -------------------------------------------------------------------------
    // HTML sanitisation
    // -------------------------------------------------------------------------

    protected function sanitizeHtml(string $html): string
    {
        if (! $html) {
            return '';
        }

        // Strip Bestsellers section and everything after it.
        $html = preg_replace('/<header[^>]*class=["\'][^"\']*shortcode-heading-wrapper[^"\']*["\'][^>]*>\s*<h2[^>]*class=["\'][^"\']*shortcode-title[^"\']*["\'][^>]*>\s*Bestsellers.*$/si', '', $html) ?? $html;

        // Normalize &nbsp; and its raw UTF-8 bytes (\xC2\xA0) to plain spaces.
        $html = str_replace('&nbsp;', ' ', $html);
        $html = str_replace("\xC2\xC2\xA0", ' ', $html);
        $html = str_replace("\xC2\xA0", ' ', $html);

        // Fix Windows-1252 mojibake (curly quotes, em dash etc. stored as garbled bytes).
        $mojibake = [
            "â\u{20AC}\u{201D}" => '—', "â\u{20AC}\u{2122}" => "\u{2019}",
            "â\u{20AC}\u{02DC}" => "\u{2018}", "â\u{20AC}\u{0153}" => "\u{201C}",
            "â\u{20AC}\u{009D}" => "\u{201D}", "â\u{20AC}\u{00A2}" => '•',
            "â\u{20AC}\u{00A6}" => '…', "â\u{201E}\u{00A2}" => '™',
            "\u{00C2}\u{00AE}"  => '®', "\u{00C2}\u{00A9}" => '©', "\u{00C2}\u{00B0}" => '°',
        ];
        $html = str_replace(array_keys($mojibake), array_values($mojibake), $html);

        $html = preg_replace(
            '/<(script|style|form|input|button|select|textarea|label|noscript|iframe|object|embed)[^>]*>.*?<\/\1>/si',
            '',
            $html
        ) ?? $html;

        $html = preg_replace(
            '/<(script|style|form|input|button|select|textarea|label|link|meta|noscript|iframe)[^>]*\/?>/si',
            '',
            $html
        ) ?? $html;

        $doc = new \DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        // Prepend XML encoding declaration so DOMDocument parses as UTF-8, not ISO-8859-1.
        $doc->loadHTML('<?xml encoding="UTF-8"><html><head><meta charset="UTF-8"></head><body>'.$html.'</body></html>', LIBXML_NOERROR);
        libxml_clear_errors();

        $body   = $doc->getElementsByTagName('body')->item(0);
        $result = '';

        if ($body) {
            foreach ($body->childNodes as $node) {
                $result .= $doc->saveHTML($node);
            }
        }

        $safe   = '<p><br><strong><b><em><i><u><ul><ol><li><h2><h3><h4><h5><h6><span><div><table><thead><tbody><tr><th><td><img><a>';
        $result = strip_tags($result, $safe);

        return trim($result);
    }

    // -------------------------------------------------------------------------
    // Image download
    // -------------------------------------------------------------------------

    protected function loadImageCache(): void
    {
        if (Storage::exists(self::IMAGE_CACHE_FILE)) {
            $this->imageCache = json_decode(Storage::get(self::IMAGE_CACHE_FILE), true) ?? [];
        }
    }

    protected function saveImageCache(): void
    {
        Storage::put(self::IMAGE_CACHE_FILE, json_encode($this->imageCache));
    }

    protected function downloadImage(string $url, int $productId): ?string
    {
        $url = preg_replace('|(https?://[^/]+(?:/[^/]+)*)/([^/]+)/\2/|', '$1/$2/', $url) ?? $url;

        $cacheKey = md5($url);

        if (isset($this->imageCache[$cacheKey])) {
            $cachedPath = $this->imageCache[$cacheKey];

            if (Storage::disk('public')->exists($cachedPath)) {
                return $cachedPath;
            }

            unset($this->imageCache[$cacheKey]);
        }

        $attempts = [$url];

        if (preg_match('|(https?://[^/]+)/([^/]+)/\2/|', $url, $m)) {
            $attempts[] = $m[1].'/'.$m[2].'/'.substr($url, strlen($m[0]));
        }

        foreach ($attempts as $attempt) {
            $path = $this->tryDownload($attempt, $productId);

            if ($path) {
                $this->imageCache[$cacheKey] = $path;
                $this->saveImageCache();

                return $path;
            }
        }

        return null;
    }

    protected function tryDownload(string $url, int $productId): ?string
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'mazzy_img_');

        try {
            // Use the image's own origin as Referer to pass hotlink protection.
            $origin   = preg_replace('|(https?://[^/]+).*|', '$1', $url);
            $response = Http::timeout(20)->withHeaders([
                'User-Agent'      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept'          => 'image/webp,image/apng,image/*,*/*;q=0.8',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Referer'         => $origin . '/',
            ])->sink($tempFile)->get($url);

            if (! $response->ok()) {
                return null;
            }

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

            Storage::disk('public')->put($path, fopen($tempFile, 'r'));

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
