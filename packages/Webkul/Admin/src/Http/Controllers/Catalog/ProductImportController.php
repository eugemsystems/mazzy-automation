<?php

namespace Webkul\Admin\Http\Controllers\Catalog;

use App\Services\WooCommerceImporter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;

class ProductImportController extends Controller
{
    public function __construct(protected WooCommerceImporter $importer) {}

    /**
     * Show the JSON-import page.
     */
    public function index(): View
    {
        return view('admin::catalog.products.import');
    }

    /**
     * Accept a JSON file upload and run the importer.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'json_file' => ['required', 'file', 'mimes:json,txt', 'max:51200'], // 50 MB
        ]);

        $content = file_get_contents($request->file('json_file')->getRealPath());
        $data    = json_decode($content, true);

        if (! is_array($data) || empty($data['products'])) {
            return back()->withErrors(['json_file' => 'Invalid or empty JSON file. Expected keys: categories, products.']);
        }

        try {
            $stats = $this->importer->import($data);
        } catch (\Throwable $e) {
            return back()->withErrors(['json_file' => 'Import failed: '.$e->getMessage()]);
        }

        // Rebuild flat/price/inventory index so products appear in admin and shop.
        Artisan::call('indexer:index');

        $msg = "Imported {$stats['imported']} product(s) successfully. Index rebuilt.";

        if ($stats['failed'] > 0) {
            $msg .= " {$stats['failed']} product(s) failed (check logs).";
        }

        session()->flash('success', $msg);

        return redirect()->route('admin.catalog.products.index');
    }

    /**
     * Export: redirect to the Artisan command result stored as JSON.
     * Call via CLI:  php artisan woocommerce:export
     * Then download from:  /storage/woocommerce-products.json (if symlinked)
     */
    public function exportInfo(): View
    {
        return view('admin::catalog.products.import');
    }
}
