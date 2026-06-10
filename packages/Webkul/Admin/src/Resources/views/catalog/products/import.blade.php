<x-admin::layouts>
    <x-slot:title>
        Import WooCommerce Products
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            Import WooCommerce Products
        </p>

        <a
            href="{{ route('admin.catalog.products.index') }}"
            class="secondary-button"
        >
            ← Back to Products
        </a>
    </div>

    {{-- Session flash --}}
    @if (session('success'))
        <div class="mt-4 rounded-md bg-green-50 p-4 text-green-800 dark:bg-green-900/20 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    {{-- Errors --}}
    @if ($errors->any())
        <div class="mt-4 rounded-md bg-red-50 p-4 dark:bg-red-900/20">
            <ul class="list-disc pl-5 text-sm text-red-700 dark:text-red-400">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">

        {{-- ── Step 1: Export ──────────────────────────────────────────────── --}}
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">
                Step 1 — Export from WooCommerce
            </h2>

            <p class="mb-3 text-sm text-gray-600 dark:text-gray-400">
                Run the following Artisan command to scrape all products from the WooCommerce store
                and save them to <code class="rounded bg-gray-100 px-1 dark:bg-gray-800">storage/app/woocommerce-products.json</code>.
            </p>

            <div class="rounded-md bg-gray-900 p-4 text-sm font-mono text-green-400">
                php artisan woocommerce:export
            </div>

            <p class="mt-3 text-xs text-gray-500 dark:text-gray-500">
                Options:
                <code class="rounded bg-gray-100 px-1 dark:bg-gray-800">--url=https://example.com/store</code>
                <code class="rounded bg-gray-100 px-1 dark:bg-gray-800">--output=my-products.json</code>
                <code class="rounded bg-gray-100 px-1 dark:bg-gray-800">--delay=400</code> (ms between requests)
            </p>

            <hr class="my-4 border-gray-200 dark:border-gray-700">

            <p class="text-sm text-gray-600 dark:text-gray-400">
                Alternatively, run the seeder which auto-exports if the file is missing:
            </p>
            <div class="mt-2 rounded-md bg-gray-900 p-4 text-sm font-mono text-green-400">
                php artisan db:seed --class=WooCommerceProductSeeder<br>
                php artisan indexer:index
            </div>
        </div>

        {{-- ── Step 2: Import ──────────────────────────────────────────────── --}}
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">
                Step 2 — Import JSON
            </h2>

            <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                Upload the exported JSON file. <strong>This will delete all existing products
                and non-root categories</strong> before importing.
            </p>

            <form
                method="POST"
                action="{{ route('admin.catalog.import.store') }}"
                enctype="multipart/form-data"
                id="import-form"
            >
                @csrf

                <div class="mb-4">
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        JSON File
                    </label>
                    <input
                        type="file"
                        name="json_file"
                        accept=".json,application/json"
                        required
                        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm
                               file:mr-4 file:rounded file:border-0 file:bg-primary-600 file:px-3 file:py-1 file:text-sm file:text-white
                               dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200"
                    >
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-500">
                        Maximum 50 MB. Must be a Bagisto-WooCommerce export JSON.
                    </p>
                </div>

                <div class="rounded-md border border-yellow-200 bg-yellow-50 p-3 text-xs text-yellow-800 dark:border-yellow-700/40 dark:bg-yellow-900/20 dark:text-yellow-400">
                    ⚠ All current products and categories (except root) will be permanently deleted before import.
                </div>

                <button
                    type="submit"
                    id="import-btn"
                    onclick="document.getElementById('import-btn').disabled=true;document.getElementById('import-btn').textContent='Importing…'"
                    class="primary-button mt-4 w-full justify-center"
                >
                    Import Products
                </button>
            </form>
        </div>

    </div>

    {{-- ── JSON format reference ──────────────────────────────────────────── --}}
    <div class="mt-6 rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
        <h2 class="mb-3 text-base font-semibold text-gray-800 dark:text-white">
            Expected JSON Format
        </h2>
        <pre class="overflow-x-auto rounded-md bg-gray-900 p-4 text-xs text-gray-300"><code>{
  "source": "woocommerce",
  "store_url": "https://example.com/store",
  "exported_at": "2025-05-27T00:00:00Z",
  "categories": [
    { "slug": "smart-door-lock",  "name": "Smart Door Lock", "parent_slug": null,              "description": "" },
    { "slug": "geyser-switch",    "name": "Geyser Switch",   "parent_slug": "smart-automation", "description": "" }
  ],
  "products": [
    {
      "sku":               "z2pro-waterproof-wifi-video-door-lock",
      "name":              "Z2pro Waterproof WIFI Video Door Lock",
      "url_key":           "z2pro-waterproof-wifi-video-door-lock",
      "price":             4446.00,
      "special_price":     null,
      "weight":            1,
      "status":            true,
      "new":               false,
      "featured":          false,
      "short_description": "&lt;p&gt;Smart lock with face recognition.&lt;/p&gt;",
      "description":       "&lt;p&gt;Full description here…&lt;/p&gt;",
      "meta_title":        "",
      "meta_keywords":     "",
      "meta_description":  "",
      "category_slugs":    ["smart-door-lock", "home-automation"],
      "images": [
        "https://mazzyautomations.co.za/store/wp-content/uploads/…/image.jpg"
      ],
      "qty": 100
    }
  ]
}</code></pre>
    </div>

</x-admin::layouts>
