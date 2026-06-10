<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Scrapes all products from a WooCommerce store and exports them as a
 * Bagisto-compatible JSON file that can be fed into WooCommerceProductSeeder
 * or uploaded via the admin import page.
 *
 * Usage:
 *   php artisan woocommerce:export
 *   php artisan woocommerce:export --url=https://example.com/store --output=products.json
 */
class WooCommerceExportCommand extends Command
{
    protected $signature = 'woocommerce:export
                            {--url=https://mazzyautomations.co.za/store : WooCommerce store base URL}
                            {--output=woocommerce-products.json : Output filename inside storage/app/}
                            {--delay=500 : Milliseconds to wait between product page requests}';

    protected $description = 'Scrape a WooCommerce store and export products to a Bagisto-import JSON file';

    protected string $storeUrl;

    public function handle(): int
    {
        $this->storeUrl = rtrim((string) $this->option('url'), '/');
        $output         = (string) $this->option('output');
        $delay          = (int) $this->option('delay');

        $this->info("Store URL : {$this->storeUrl}");
        $this->info("Output    : storage/app/{$output}");
        $this->newLine();

        // ── 1. Parse product sitemap (URLs + images) ─────────────────────────
        $this->info('Fetching product sitemap…');
        [$productUrls, $sitemapImages] = $this->fetchProductSitemap();
        $this->info("Found {$productUrls->count()} product URLs.");

        // ── 2. Parse category sitemap ─────────────────────────────────────────
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
        $this->info('Or upload the JSON via Admin → Catalog → Import Products.');

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

        // Strip CDATA wrappers so normal regex can match.
        $xml = $this->stripCdata($raw);

        // Split into individual <url>…</url> blocks.
        preg_match_all('/<url>(.*?)<\/url>/si', $xml, $blocks);

        $urls   = collect();
        $images = [];

        foreach ($blocks[1] ?? [] as $block) {
            $loc = $this->firstMatch($block, '/<loc>(https?:\/\/[^<]+)<\/loc>/i');

            if (! $loc || ! str_contains($loc, '/product/')) {
                continue;
            }

            $urls->push($loc);

            // Collect all image:loc entries in this block.
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

    /**
     * Fix sitemap image URLs that accidentally duplicate a path segment.
     * e.g. https://example.com/store/store/wp-content/... → https://example.com/store/wp-content/...
     */
    protected function fixImageUrl(string $url): string
    {
        // Remove any repeated adjacent path segment: /store/store/ → /store/
        return preg_replace('|(/[^/]+)\1/|', '$1/', $url) ?? $url;
    }

    protected function extractImages(string $html, array $sitemapImages): array
    {
        // Strategy 1: <a href> links to wp-content/uploads images (full-size WooCommerce gallery links).
        preg_match_all(
            '~href="(https?://[^"]+/wp-content/uploads/[^"]+\.(?:jpe?g|png|webp|gif))"~i',
            $html,
            $aHrefM
        );
        $images = array_values(array_unique($aHrefM[1] ?? []));

        // Strategy 2: <img src> pointing to wp-content/uploads, excluding thumbnails and layout images.
        if (empty($images)) {
            preg_match_all(
                '~src="(https?://[^"]+/wp-content/uploads/[^"]+\.(?:jpe?g|png|webp|gif))"~i',
                $html,
                $imgSrcM
            );
            $layoutKeywords = ['logo', 'banner', 'icon', 'payment', 'wallet', 'package', 'delivery', 'phone', 'mail', 'mazzy'];
            $images = array_values(array_filter($imgSrcM[1] ?? [], function ($u) use ($layoutKeywords) {
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

        // Strategy 3: sitemap images with duplicate-segment fix as last resort.
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
                $html    = Http::timeout(30)->withHeaders([
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
            // On-sale: <del>regular</del><ins>sale</ins>
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
        $catBlock  = $this->firstMatch($html, '/<span[^>]*class="[^"]*posted_in[^"]*"[^>]*>(.*?)<\/span>/si');
        $catSlugs  = $this->extractHrefSlugs($catBlock ?? '', 'product-category');

        // ── Tags (used for meta_keywords) ─────────────────────────────────────
        $tagBlock = $this->firstMatch($html, '/<span[^>]*class="[^"]*tagged_as[^"]*"[^>]*>(.*?)<\/span>/si');
        $tags     = $this->extractAnchorTexts($tagBlock ?? '');

        // ── Images ────────────────────────────────────────────────────────────
        $images = $this->extractImages($html, $sitemapImages);

        // ── SKU ───────────────────────────────────────────────────────────────
        $sku = $this->cleanText(
            $this->firstMatch($html, '/<span[^>]*class="[^"]*sku[^"]*"[^>]*>(.*?)<\/span>/si') ?? ''
        );
        $sku = ($sku && $sku !== 'N/A' && $sku !== '') ? $sku : 'mazzy-'.$slug;

        return [
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
    }

    // =========================================================================
    // HTML extraction helpers
    // =========================================================================

    protected function extractShortDescription(string $html): string
    {
        $patterns = [
            '/<div[^>]*class="[^"]*woocommerce-product-details__short-description[^"]*"[^>]*>(.*?)<\/div>\s*<\/div>/si',
            '/<div[^>]*class="[^"]*woocommerce-product-details__short-description[^"]*"[^>]*>(.*?)<\/div>/si',
        ];

        foreach ($patterns as $p) {
            $m = $this->firstMatch($html, $p);
            if ($m) {
                return $this->cleanHtml($m);
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

        $html = preg_replace('/<(script|style)[^>]*>.*?<\/\1>/si', '', $html) ?? $html;

        return trim($html);
    }

    protected function parsePrice(string $html): float
    {
        $text = $this->cleanText($html);
        // SA format: R1,234.00 — strip currency symbol and thousands comma.
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

    /**
     * Remove CDATA wrappers so regular regexes work on the XML.
     */
    protected function stripCdata(string $xml): string
    {
        return str_replace(['<![CDATA[', ']]>'], '', $xml);
    }

    protected function slugToName(string $slug): string
    {
        return Str::title(str_replace(['-', '_'], ' ', $slug));
    }
}
