<?php

namespace Database\Seeders;

use App\Services\WooCommerceImporter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

/**
 * Deletes all existing products and categories (keeping root) then imports
 * products from the WooCommerce export JSON.
 *
 * Workflow:
 *   1.  php artisan woocommerce:export            ← scrape & save JSON
 *   2.  php artisan db:seed --class=WooCommerceProductSeeder
 *   3.  php artisan indexer:index                 ← rebuild search/flat index
 */
class WooCommerceProductSeeder extends Seeder
{
    /**
     * Default JSON path inside storage/app/.
     */
    protected const JSON_FILE = 'woocommerce-products.json';

    public function run(): void
    {
        ini_set('memory_limit', '512M');

        $file = self::JSON_FILE;

        // Auto-generate JSON if it doesn't exist yet.
        if (! Storage::exists($file)) {
            $this->command->warn("JSON file not found at storage/app/{$file}. Running export first…");
            Artisan::call('woocommerce:export', [], $this->command->getOutput());
        }

        if (! Storage::exists($file)) {
            $this->command->error("Export failed. Aborting seeder.");
            return;
        }

        $data = json_decode(Storage::get($file), true);

        if (! is_array($data)) {
            $this->command->error("Invalid JSON in storage/app/{$file}. Aborting.");
            return;
        }

        $this->command->info('Importing WooCommerce products into Mazzy…');

        $importer = new WooCommerceImporter;

        $stats = $importer->import($data, function (int $done, int $total) {
            $this->command->getOutput()->write("\r  Progress: {$done}/{$total}");
        });

        $this->command->newLine();
        $this->command->info("✓ Imported : {$stats['imported']} products");

        if ($stats['failed'] > 0) {
            $this->command->warn("✗ Failed   : {$stats['failed']} products");
            foreach ($stats['errors'] as $err) {
                $this->command->warn("  - $err");
            }
        }

        $this->command->info('Rebuilding product flat/price/inventory index…');
        Artisan::call('indexer:index', [], $this->command->getOutput());
        $this->command->info('✓ Index rebuilt. Products are now visible in admin and shop.');
    }
}
