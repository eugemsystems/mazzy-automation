<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SanitizeProductDescriptionsCommand extends Command
{
    protected $signature = 'mazzy:sanitize-descriptions';

    protected $description = 'Strip malformed WooCommerce HTML from imported product descriptions';

    public function handle(): int
    {
        $attributeIds = DB::table('attributes')
            ->whereIn('code', ['description', 'short_description'])
            ->pluck('id');

        $rows = DB::table('product_attribute_values')
            ->whereIn('attribute_id', $attributeIds)
            ->whereNotNull('text_value')
            ->select('id', 'text_value')
            ->get();

        $this->info("Sanitizing {$rows->count()} description fields…");

        $bar = $this->output->createProgressBar($rows->count());

        foreach ($rows as $row) {
            $clean = $this->sanitizeHtml($row->text_value);

            if ($clean !== $row->text_value) {
                DB::table('product_attribute_values')
                    ->where('id', $row->id)
                    ->update(['text_value' => $clean]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Done. Run php artisan optimize:clear to clear view/config caches.');

        return self::SUCCESS;
    }

    protected function sanitizeHtml(string $html): string
    {
        if (! $html) {
            return '';
        }

        // Strip elements that should never appear in a product description.
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

        // DOMDocument repairs orphaned closing tags (e.g. a stray </div>) that break
        // Vue's template compiler when the description is output inside a Vue mount point.
        $doc = new \DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $doc->loadHTML('<html><head><meta charset="UTF-8"></head><body>'.$html.'</body></html>', LIBXML_NOERROR);
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
}
