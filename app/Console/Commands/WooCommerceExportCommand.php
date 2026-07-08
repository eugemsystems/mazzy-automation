<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Scrapes all products from a WooCommerce store and exports them as a
 * Bagisto-compatible JSON file that can be fed into WooCommerceProductSeeder.
 *
 * Supports:
 *   - Simple products
 *   - Variable products (configurable) with 1..N variation axes (color, gang, size, …)
 *   - Category slugs per product (assigned at export time)
 *
 * Usage:
 *   php artisan woocommerce:export
 *   php artisan woocommerce:export --url=https://example.com/store --output=products.json
 *   php artisan woocommerce:export --test=https://example.com/store/product/foo/,https://example.com/store/product/bar/
 */
class WooCommerceExportCommand extends Command
{
    protected $signature = 'woocommerce:export
                            {--url=https://new.mazzyautomations.co.za/store : WooCommerce store base URL}
                            {--output=woocommerce-products.json : Output filename inside storage/app/}
                            {--delay=500 : Milliseconds to wait between product page requests}
                            {--test= : Comma-separated product URLs to scrape instead of the full sitemap}';

    protected $description = 'Scrape a WooCommerce store and export products to a Bagisto-import JSON file';

    protected string $storeUrl;

    public function handle(): int
    {
        $this->storeUrl = rtrim((string) $this->option('url'), '/');
        $delay          = (int) $this->option('delay');
        $testUrls       = $this->option('test');

        $isTest = $testUrls !== null;

        // Test mode uses a separate filename so it never clobbers the full export.
        $output = $isTest ? 'woocommerce-products-test.json' : (string) $this->option('output');

        $this->info("Store URL : {$this->storeUrl}");
        $this->info("Output    : storage/app/{$output}");
        if ($isTest) {
            $this->warn('TEST MODE — only scraping the specified URLs (sitemap skipped).');
        }
        $this->newLine();

        // ── 1. Product URLs ───────────────────────────────────────────────────
        if ($isTest) {
            $productUrls  = collect(array_filter(array_map('trim', explode(',', $testUrls))));
            $sitemapImages = [];
            $this->info("Test URLs : {$productUrls->count()} provided.");
        } else {
            $this->info('Fetching product sitemap…');
            [$productUrls, $sitemapImages] = $this->fetchProductSitemap();
            $this->info("Found {$productUrls->count()} product URLs.");
        }

        // ── 2. Category sitemap (skipped in test mode) ─────────────────────────
        $this->info('Fetching category sitemap…');
        $categories = $this->fetchCategories();
        $this->info("Found {$categories->count()} categories.");

        // ── 3. Scrape each product page ───────────────────────────────────────
        $this->newLine();
        $this->info('Scraping product pages…');
        $products = $this->scrapeProducts($productUrls, $sitemapImages, $delay);

        // ── 4. Write JSON ─────────────────────────────────────────────────────
        $payload = [
            'source'      => 'woocommerce',
            'store_url'   => $this->storeUrl,
            'exported_at' => now()->toIso8601String(),
            'categories'  => $categories->values()->all(),
            'products'    => $products,
        ];

        Storage::put($output, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        $this->newLine();
        $this->info('✓ Exported '.count($products)." products to storage/app/{$output}");
        $this->info('Run the seeder:  php artisan db:seed --class=WooCommerceProductSeeder');

        return self::SUCCESS;
    }

    // =========================================================================
    // Sitemap parsing
    // =========================================================================

    /**
     * Fetch product sitemap and return:
     *  [0] Collection of product URLs
     *  [1] Map of product URL => image URL[]
     */
    protected function fetchProductSitemap(): array
    {
        try {
            $raw = Http::timeout(30)->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (compatible; BagistoExporter/1.0)',
            ])->get("{$this->storeUrl}/product-sitemap.xml")->body();
        } catch (\Throwable $e) {
            $this->warn("Could not fetch product sitemap: {$e->getMessage()}");
            return [collect(), []];
        }

        $xml = $this->stripCdata($raw);

        preg_match_all('/<url>(.*?)<\/url>/si', $xml, $blocks);

        $urls   = collect();
        $images = [];

        foreach ($blocks[1] ?? [] as $block) {
            $loc = $this->firstMatch($block, '/<loc>(https?:\/\/[^<]+)<\/loc>/i');

            if (! $loc || ! str_contains($loc, '/product/')) {
                continue;
            }

            $urls->push($loc);

            preg_match_all('/<image:loc>(https?:\/\/[^<]+)<\/image:loc>/i', $block, $imgM);
            $blockImages = array_values(array_filter(array_map(
                fn ($u) => $this->fixImageUrl($u),
                $imgM[1] ?? []
            )));

            if ($blockImages) {
                $images[$loc] = $blockImages;
            }
        }

        return [$urls->unique(), $images];
    }

    protected function fetchCategories(): \Illuminate\Support\Collection
    {
        try {
            $raw = Http::timeout(30)->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (compatible; BagistoExporter/1.0)',
            ])->get("{$this->storeUrl}/product_cat-sitemap.xml")->body();
        } catch (\Throwable $e) {
            $this->warn("Could not fetch category sitemap: {$e->getMessage()}");
            return collect();
        }

        $xml = $this->stripCdata($raw);

        preg_match_all('/<loc>(https?:\/\/[^<]+\/product-category\/([^<]+?))\/?<\/loc>/i', $xml, $m, PREG_SET_ORDER);

        return collect($m)->map(function ($match) {
            $path       = trim($match[2], '/');
            $parts      = explode('/', $path);
            $slug       = end($parts);
            $parentSlug = count($parts) > 1 ? $parts[count($parts) - 2] : null;

            return [
                'slug'        => $slug,
                'name'        => $this->slugToName($slug),
                'parent_slug' => $parentSlug,
                'description' => '',
            ];
        })->filter(fn ($c) => $c['slug'] !== 'uncategorized')
          ->values();
    }

    protected function fixImageUrl(string $url): string
    {
        return preg_replace('|(/[^/]+)\1/|', '$1/', $url) ?? $url;
    }

    protected function extractImages(string $html, array $sitemapImages): array
    {
        $socialHosts = ['pinterest.com', 'facebook.com', 'twitter.com', 'x.com', 'instagram.com'];

        $isSocialShare = function (string $url) use ($socialHosts): bool {
            $host = strtolower((string) parse_url($url, PHP_URL_HOST));
            foreach ($socialHosts as $sh) {
                if ($host === $sh || str_ends_with($host, '.'.$sh)) {
                    return true;
                }
            }
            return false;
        };

        // Strategy 1: <a href> links to wp-content/uploads (full-size gallery links).
        preg_match_all(
            '~<a\s[^>]*\bhref="(https?://[^"]+/wp-content/uploads/[^"]+\.(?:jpe?g|png|webp|gif))"[^>]*>~i',
            $html,
            $aHrefM
        );
        $images = array_values(array_unique(array_filter(
            $aHrefM[1] ?? [],
            fn ($u) => ! $isSocialShare($u)
        )));

        // Strategy 2: <img src> pointing to wp-content/uploads.
        if (empty($images)) {
            preg_match_all(
                '~<img\s[^>]*\bsrc="(https?://[^"]+/wp-content/uploads/[^"]+\.(?:jpe?g|png|webp|gif))"[^>]*>~i',
                $html,
                $imgSrcM
            );
            $layoutKeywords = ['logo', 'banner', 'icon', 'payment', 'wallet', 'package', 'delivery', 'phone', 'mail', 'mazzy', 'fav', 'cropped-'];
            $images = array_values(array_filter($imgSrcM[1] ?? [], function ($u) use ($layoutKeywords, $isSocialShare) {
                if ($isSocialShare($u)) {
                    return false;
                }
                if (preg_match('~-\d+x\d+\.(?:jpe?g|png|webp|gif)$~i', $u)) {
                    return false;
                }
                $filename = strtolower(basename($u));
                foreach ($layoutKeywords as $kw) {
                    if (str_contains($filename, $kw)) {
                        return false;
                    }
                }
                return true;
            }));
        }

        // Strategy 3: sitemap images as last resort.
        if (empty($images)) {
            $images = array_map(fn ($u) => $this->fixImageUrl($u), $sitemapImages);
        }

        return array_values(array_filter(
            array_unique($images),
            fn ($u) => (bool) filter_var($u, FILTER_VALIDATE_URL)
        ));
    }

    // =========================================================================
    // Product scraping
    // =========================================================================

    protected function scrapeProducts(\Illuminate\Support\Collection $urls, array $sitemapImages, int $delay): array
    {
        $bar      = $this->output->createProgressBar($urls->count());
        $products = [];

        foreach ($urls as $url) {
            try {
                $html = Http::timeout(30)->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (compatible; BagistoExporter/1.0)',
                ])->get($url)->body();

                $product = $this->parseProductPage($html, $url, $sitemapImages[$url] ?? []);

                if ($product) {
                    $products[] = $product;
                }
            } catch (\Throwable $e) {
                $this->newLine();
                $this->warn("  ✗ {$url}: {$e->getMessage()}");
            }

            $bar->advance();

            if ($delay > 0) {
                usleep($delay * 1000);
            }
        }

        $bar->finish();

        return $products;
    }

    protected function parseProductPage(string $html, string $url, array $sitemapImages): ?array
    {
        // ── Strip noisy sections before any extraction ─────────────────────────
        // Related products, upsells, reviews, and Bestsellers widgets appear
        // after the main product content and must be removed first.

        // Truncate everything from the Bestsellers shortcode heading onwards.
        $html = preg_replace(
            '/<header[^>]*class="[^"]*shortcode-heading-wrapper[^"]*"[^>]*>\s*<h2[^>]*class="[^"]*shortcode-title[^"]*"[^>]*>\s*Bestsellers.*$/si',
            '',
            $html
        ) ?? $html;

        $html = preg_replace(
            '/<section[^>]*class="[^"]*\b(?:related|upsells?)\b[^"]*"[^>]*>.*?<\/section>/si',
            '',
            $html
        ) ?? $html;
        $html = preg_replace(
            '/<(?:div|section)[^>]*(?:id="reviews"|class="[^"]*\bwoocommerce-Reviews\b[^"]*")[^>]*>.*?<\/(?:div|section)>/si',
            '',
            $html
        ) ?? $html;
        $html = preg_replace(
            '/<div[^>]*class="[^"]*woocommerce-Tabs-panel--reviews[^"]*"[^>]*>.*?<\/div>/si',
            '',
            $html
        ) ?? $html;

        // ── Title ─────────────────────────────────────────────────────────────
        $name = $this->firstMatch($html, '/<h1[^>]*class="[^"]*product[_-]title[^"]*"[^>]*>(.*?)<\/h1>/si')
              ?? $this->firstMatch($html, '/<h1[^>]*>(.*?)<\/h1>/si');

        if (! $name) {
            return null;
        }

        $name = $this->cleanText($name);

        // ── Slug / url_key ────────────────────────────────────────────────────
        $slug = basename(rtrim($url, '/'));
        if (is_numeric($slug)) {
            $slug = Str::slug($name);
        }

        // ── Prices ────────────────────────────────────────────────────────────
        $priceBlock   = $this->firstMatch($html, '/<p[^>]*class="[^"]*price[^"]*"[^>]*>(.*?)<\/p>/si');
        $regularPrice = null;
        $salePrice    = null;

        if ($priceBlock) {
            $delBdi = $this->firstMatch($priceBlock, '/<del[^>]*>.*?<bdi[^>]*>(.*?)<\/bdi>/si');
            $insBdi = $this->firstMatch($priceBlock, '/<ins[^>]*>.*?<bdi[^>]*>(.*?)<\/bdi>/si');

            if ($delBdi && $insBdi) {
                $regularPrice = $this->parsePrice($delBdi);
                $salePrice    = $this->parsePrice($insBdi);
            } else {
                $bdi          = $this->firstMatch($priceBlock, '/<bdi[^>]*>(.*?)<\/bdi>/si');
                $regularPrice = $bdi ? $this->parsePrice($bdi) : null;
            }
        }

        $price = $salePrice ?? $regularPrice ?? 0.0;

        // ── Descriptions ──────────────────────────────────────────────────────
        $shortDesc = $this->extractShortDescription($html);
        $fullDesc  = $this->extractFullDescription($html);

        // ── Categories ────────────────────────────────────────────────────────
        $catSlugs = $this->extractCategorySlugs($html);

        // ── Tags ──────────────────────────────────────────────────────────────
        $tagBlock = $this->firstMatch($html, '/<span[^>]*class="[^"]*tagged_as[^"]*"[^>]*>(.*?)<\/span>/si');
        $tags     = $this->extractAnchorTexts($tagBlock ?? '');

        // ── Images ────────────────────────────────────────────────────────────
        $images = $this->extractImages($html, $sitemapImages);

        // ── SKU ───────────────────────────────────────────────────────────────
        $sku = $this->cleanText(
            $this->firstMatch($html, '/<span[^>]*class="[^"]*sku[^"]*"[^>]*>(.*?)<\/span>/si') ?? ''
        );
        $sku = ($sku && $sku !== 'N/A' && $sku !== '') ? $sku : 'mazzy-'.$slug;

        // ── Variations (WooCommerce variable products) ─────────────────────────
        $variations = $this->extractVariations($html);

        // ── Determine type ────────────────────────────────────────────────────
        $type = count($variations) > 0 ? 'configurable' : 'simple';

        $product = [
            'type'              => $type,
            'sku'               => $sku,
            'name'              => $name,
            'url_key'           => $slug,
            'price'             => round($price, 2),
            'special_price'     => ($salePrice && $regularPrice && $salePrice < $regularPrice)
                                   ? round($salePrice, 2)
                                   : null,
            'weight'            => 1,
            'status'            => true,
            'new'               => false,
            'featured'          => false,
            'short_description' => $shortDesc,
            'description'       => $fullDesc ?: $shortDesc,
            'meta_title'        => $name,
            'meta_keywords'     => implode(', ', $tags),
            'meta_description'  => $shortDesc ? strip_tags(substr($shortDesc, 0, 160)) : '',
            'category_slugs'    => $catSlugs,
            'images'            => $images,
            'qty'               => 100,
        ];

        if ($type === 'configurable') {
            $product['variations'] = $variations;
        }

        return $product;
    }

    /**
     * Parse the WooCommerce data-product_variations JSON attribute from the page.
     *
     * Returns array of variations, each:
     *   [
     *     'sku'        => string,
     *     'price'      => float,
     *     'sale_price' => float|null,
     *     'in_stock'   => bool,
     *     'attributes' => ['color' => 'White', 'gang' => '1 Gang', …],  // Bagisto-normalised keys
     *     'image'      => string|null,   // full-size image URL for this variation
     *   ]
     */
    protected function extractVariations(string $html): array
    {
        // Grab the data-product_variations attribute value (HTML-encoded JSON).
        if (! preg_match('/data-product_variations="([^"]+)"/s', $html, $m)) {
            return [];
        }

        $json = html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5);
        $raw  = json_decode($json, true);

        if (! is_array($raw) || empty($raw)) {
            return [];
        }

        $variations = [];

        foreach ($raw as $v) {
            // Skip placeholder "false" value (WooCommerce uses this for AJAX-loaded variations).
            if (! is_array($v)) {
                continue;
            }

            $attrs = $this->normaliseVariationAttributes($v['attributes'] ?? []);

            if (empty($attrs)) {
                continue;
            }

            $varPrice    = (float) ($v['display_price'] ?? 0);
            $varRegular  = (float) ($v['display_regular_price'] ?? $varPrice);
            $varSalePrice = ($varPrice < $varRegular && $varPrice > 0) ? $varPrice : null;
            $effectivePrice = $varRegular ?: $varPrice;

            // Full-size image for this specific variation (from the image array WooCommerce provides).
            $varImage = null;
            if (! empty($v['image']['url'])) {
                $varImage = $this->fixImageUrl((string) $v['image']['url']);
            } elseif (! empty($v['image']['full_src'])) {
                $varImage = $this->fixImageUrl((string) $v['image']['full_src']);
            }

            $varSku = ! empty($v['sku']) ? (string) $v['sku'] : '';

            $variations[] = [
                'sku'        => $varSku,
                'price'      => round($effectivePrice, 2),
                'sale_price' => $varSalePrice !== null ? round($varSalePrice, 2) : null,
                'in_stock'   => (bool) ($v['is_in_stock'] ?? true),
                'attributes' => $attrs,
                'image'      => $varImage,
            ];
        }

        return $variations;
    }

    /**
     * Convert WooCommerce attribute keys to clean Bagisto-compatible codes.
     *
     * WooCommerce uses:
     *   "attribute_pa_color"  → global (taxonomy) attribute
     *   "attribute_color"     → local attribute
     *   "attribute_gang"      → local attribute
     *   "attribute_network-type" → local attribute with hyphen
     *
     * Output: ["color" => "White", "gang" => "1 Gang", "network_type" => "WIFI"]
     */
    protected function normaliseVariationAttributes(array $attrs): array
    {
        $result = [];

        foreach ($attrs as $key => $value) {
            if ($value === '' || $value === null) {
                continue;
            }

            // Strip "attribute_pa_" (global taxonomy) or "attribute_" (local) prefix.
            $code = preg_replace('/^attribute_(?:pa_)?/', '', strtolower($key));

            // Replace hyphens with underscores so the code is a valid identifier.
            $code = str_replace('-', '_', $code);

            if ($code === '') {
                continue;
            }

            $result[$code] = (string) $value;
        }

        return $result;
    }

    // =========================================================================
    // HTML extraction helpers
    // =========================================================================

    protected function extractCategorySlugs(string $html): array
    {
        // Strategy 1: standard WooCommerce posted_in span
        $catBlock = $this->firstMatch($html, '/<span[^>]*class="[^"]*posted_in[^"]*"[^>]*>(.*?)<\/span>/si');
        $slugs    = $this->extractHrefSlugs($catBlock ?? '', 'product-category');

        if (! empty($slugs)) {
            return $slugs;
        }

        // Strategy 2: breadcrumb nav — WooCommerce themes put product-category hrefs here
        $navPatterns = [
            '/<nav[^>]*class="[^"]*(?:woocommerce-breadcrumb|breadcrumb)[^"]*"[^>]*>(.*?)<\/nav>/si',
            '/<ol[^>]*class="[^"]*(?:woocommerce-breadcrumb|breadcrumb)[^"]*"[^>]*>(.*?)<\/ol>/si',
            '/<div[^>]*class="[^"]*(?:woocommerce-breadcrumb|breadcrumb)[^"]*"[^>]*>(.*?)<\/div>/si',
        ];

        foreach ($navPatterns as $p) {
            $block = $this->firstMatch($html, $p);
            if ($block) {
                $slugs = $this->extractHrefSlugs($block, 'product-category');
                if (! empty($slugs)) {
                    return $slugs;
                }
            }
        }

        // Strategy 3: product_cat-{slug} CSS classes on the main product element
        // Limit to ~8 000 chars from the start of <main> to avoid related-product sections
        $mainPos  = strpos($html, '<main');
        $searchIn = $mainPos !== false ? substr($html, $mainPos, 8000) : substr($html, 0, 8000);

        if (preg_match_all('/\bproduct_cat-([a-z0-9][a-z0-9-]*[a-z0-9])\b/i', $searchIn, $m)) {
            return array_values(array_unique($m[1]));
        }

        return [];
    }

    protected function extractShortDescription(string $html): string
    {
        $patterns = [
            '/<div[^>]*class="[^"]*woocommerce-product-details__short-description[^"]*"[^>]*>(.*?)<\/div>\s*<\/div>/si',
            '/<div[^>]*class="[^"]*woocommerce-product-details__short-description[^"]*"[^>]*>(.*?)<\/div>/si',
        ];

        foreach ($patterns as $p) {
            $m = $this->firstMatch($html, $p);

            if ($m) {
                // Truncate at price / form elements that bleed in when the theme
                // wraps more content inside the short-description div.
                foreach (['<p class="price"', '<form ', 'data-product_variations'] as $marker) {
                    $pos = strpos($m, $marker);
                    if ($pos !== false) {
                        $m = substr($m, 0, $pos);
                    }
                }

                $cleaned = $this->cleanHtml($m);
                if ($cleaned !== '') {
                    return $cleaned;
                }
            }
        }

        return '';
    }

    protected function extractFullDescription(string $html): string
    {
        $patterns = [
            '/<div[^>]*class="[^"]*woocommerce-Tabs-panel--description[^"]*"[^>]*>(.*?)<\/section>/si',
            '/<div[^>]*id="tab-description"[^>]*>(.*?)<\/div>\s*<\/div>/si',
            '/<div[^>]*class="[^"]*woocommerce-Tabs-panel--description[^"]*"[^>]*>(.*?)<\/div>\s*<\/div>/si',
        ];

        foreach ($patterns as $p) {
            $m = $this->firstMatch($html, $p);
            if ($m) {
                return $this->cleanHtml($m);
            }
        }

        return '';
    }

    protected function firstMatch(string $html, string $pattern): ?string
    {
        if (preg_match($pattern, $html, $m)) {
            return $m[1];
        }

        return null;
    }

    protected function cleanText(?string $html): string
    {
        if ($html === null) {
            return '';
        }

        return trim(html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }

    protected function cleanHtml(?string $html): string
    {
        if (! $html) {
            return '';
        }

        // Drop script/style blocks.
        $html = preg_replace('/<(script|style)[^>]*>.*?<\/\1>/si', '', $html) ?? $html;

        // Normalize problematic whitespace bytes at the source (UTF-8 non-breaking
        // space = \xC2\xA0 and its double-encoded variants) to a plain space.
        // These appear as "Â " in browsers when the original WooCommerce content
        // was copy-pasted from Word/Docs.
        // Fix &nbsp; and UTF-8 non-breaking space bytes (\xC2\xA0).
        $html = str_replace('&nbsp;', ' ', $html);
        $html = str_replace("\xC2\xC2\xA0", ' ', $html);
        $html = str_replace("\xC2\xA0", ' ', $html);

        // Fix Windows-1252 mojibake: UTF-8 multibyte sequences that were
        // misread as Windows-1252 and stored as literal Latin characters.
        // E.g. em dash (U+2014 → \xE2\x80\x94) becomes "â€"" in Windows-1252.
        // Keys use the exact Unicode characters produced when UTF-8 bytes are
        // misread as Windows-1252 (e.g. em dash \xE2\x80\x94 → â + € + \x94
        // where \x94 maps to U+201D in Windows-1252, NOT ASCII '"').
        $mojibake = [
            "â\u{20AC}\u{201D}" => '—',  // em dash U+2014  (E2 80 94)
            "â\u{20AC}\u{2122}" => "\u{2019}", // right single quote '  (E2 80 99)
            "â\u{20AC}\u{02DC}" => "\u{2018}", // left single quote '   (E2 80 98)
            "â\u{20AC}\u{0153}" => "\u{201C}", // left double quote "   (E2 80 9C)
            "â\u{20AC}\u{009D}" => "\u{201D}", // right double quote "  (E2 80 9D)
            "â\u{20AC}\u{00A2}" => '•',        // bullet U+2022        (E2 80 A2)
            "â\u{20AC}\u{00A6}" => '…',        // ellipsis U+2026      (E2 80 A6)
            "â\u{201E}\u{00A2}" => '™',        // trade mark U+2122    (E2 84 A2)
            "\u{00C2}\u{00AE}"  => '®',        // registered U+00AE    (C2 AE)
            "\u{00C2}\u{00A9}"  => '©',        // copyright U+00A9     (C2 A9)
            "\u{00C2}\u{00B0}"  => '°',        // degree U+00B0        (C2 B0)
            "\u{00C3}\u{00A9}"  => 'é',        // é U+00E9             (C3 A9)
            "\u{00C3}\u{00A8}"  => 'è',
            "\u{00C3}\u{00A0}"  => 'à',
            "\u{00C3}\u{00A2}"  => 'â',
            "\u{00C3}\u{00AE}"  => 'î',
            "\u{00C3}\u{00B4}"  => 'ô',
            "\u{00C3}\u{00BB}"  => 'û',
        ];
        $html = str_replace(array_keys($mojibake), array_values($mojibake), $html);

        // Collapse whitespace that crept in between inline elements.
        $html = preg_replace('/[ \t]{2,}/', ' ', $html) ?? $html;

        return trim($html);
    }

    protected function parsePrice(string $html): float
    {
        $text = $this->cleanText($html);
        $text = preg_replace('/[^\d.]/', '', str_replace(',', '', $text)) ?? '';

        return (float) $text;
    }

    protected function extractHrefSlugs(string $html, string $pathSegment): array
    {
        preg_match_all('/<a\s[^>]*href="([^"]+)"[^>]*>/i', $html, $m);
        $slugs = [];

        foreach ($m[1] ?? [] as $href) {
            if (str_contains($href, $pathSegment)) {
                $slug = basename(rtrim($href, '/'));

                if ($slug && $slug !== 'uncategorized') {
                    $slugs[] = $slug;
                }
            }
        }

        return array_values(array_unique($slugs));
    }

    protected function extractAnchorTexts(string $html): array
    {
        preg_match_all('/<a[^>]*>(.*?)<\/a>/si', $html, $m);

        return array_values(array_filter(
            array_map(fn ($t) => $this->cleanText($t), $m[1] ?? [])
        ));
    }

    // =========================================================================
    // Utilities
    // =========================================================================

    protected function stripCdata(string $xml): string
    {
        return str_replace(['<![CDATA[', ']]>'], '', $xml);
    }

    protected function slugToName(string $slug): string
    {
        return Str::title(str_replace(['-', '_'], ' ', $slug));
    }
}
