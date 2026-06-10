<?php

use Illuminate\Support\Facades\Route;
use Webkul\Shop\Http\Controllers\BookingProductController;
use Webkul\Shop\Http\Controllers\CompareController;
use Webkul\Shop\Http\Controllers\HomeController;
use Webkul\Shop\Http\Controllers\PageController;
use Webkul\Shop\Http\Controllers\ProductController;
use Webkul\Shop\Http\Controllers\ProductsCategoriesProxyController;
use Webkul\Shop\Http\Controllers\SearchController;
use Webkul\Shop\Http\Controllers\SubscriptionController;

/**
 * Store landing page — /store
 */
Route::get('', [HomeController::class, 'store'])
    ->name('shop.home.store')
    ->middleware('cache.response');

/**
 * CMS pages — /store/page/{slug}
 */
Route::get('page/{slug}', [PageController::class, 'view'])
    ->name('shop.cms.page')
    ->middleware('cache.response');

/**
 * Search — /store/search
 */
Route::get('search', [SearchController::class, 'index'])
    ->name('shop.search.index')
    ->middleware('cache.response');

Route::post('search/upload', [SearchController::class, 'upload'])
    ->name('shop.search.upload');

/**
 * Newsletter subscriptions — /store/subscription
 */
Route::controller(SubscriptionController::class)->group(function () {
    Route::post('subscription', 'store')->name('shop.subscription.store');
    Route::get('subscription/{token}', 'destroy')->name('shop.subscription.destroy');
});

/**
 * Compare — /store/compare
 */
Route::get('compare', [CompareController::class, 'index'])
    ->name('shop.compare.index')
    ->middleware('cache.response');

/**
 * Downloadable / file products
 */
Route::controller(ProductController::class)->group(function () {
    Route::get('downloadable/download-sample/{type}/{id}', 'downloadSample')
        ->name('shop.downloadable.download_sample');

    Route::get('product/{id}/{attribute_id}', 'download')
        ->name('shop.product.file.download');
});

/**
 * Booking product slots
 */
Route::get('booking-slots/{id}', [BookingProductController::class, 'index'])
    ->name('shop.booking-product.slots.index');

/**
 * Product / category catch-all — MUST be last.
 * Handles /store/{url_key} for product detail and category pages.
 */
Route::get('{path}', [ProductsCategoriesProxyController::class, 'index'])
    ->name('shop.product_or_category.index')
    ->where('path', '.*')
    ->middleware('cache.response');
