<?php

use Illuminate\Support\Facades\Route;

/**
 * Main site routes (no URL prefix — /, /contact-us, /about-us, etc.)
 */
require 'main-site-routes.php';

/**
 * Store / e-commerce routes — all prefixed with /store
 * Includes the store landing page, product/category browsing,
 * customer account, and checkout flows.
 */
Route::prefix('store')->group(function () {
    require 'customer-routes.php';
    require 'checkout-routes.php';
    require 'shop-store-routes.php'; // wildcard catch-all must be last
});
