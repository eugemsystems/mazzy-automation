<?php

use Illuminate\Support\Facades\Route;
use Webkul\Shop\Http\Controllers\GoogleMerchantFeedController;
use Webkul\Shop\Http\Controllers\HomeController;
use Webkul\Shop\Http\Controllers\PageController;
use Webkul\Shop\Http\Controllers\ProductController;

/**
 * Main site routes — no /store prefix.
 * These are the marketing/content pages.
 */
Route::get('/', [HomeController::class, 'index'])
    ->name('shop.home.index');

Route::get('contact-us', [HomeController::class, 'contactUs'])
    ->name('shop.home.contact_us')
    ->middleware('cache.response');

Route::post('contact-us/send-mail', [HomeController::class, 'sendContactUsMail'])
    ->name('shop.home.contact_us.send_mail');

Route::post('quote/send', [HomeController::class, 'sendQuoteMail'])
    ->name('shop.home.quote.send');

Route::post('products/enquire', [ProductController::class, 'sendEnquiryMail'])
    ->name('shop.products.enquire.send_mail');

/**
 * Public Google Merchant Center product feed — protected by a secret token
 * in the URL instead of a login, so Merchant Center can pull it directly.
 */
Route::get('feed/google-merchant/{token}', [GoogleMerchantFeedController::class, 'index'])
    ->name('shop.feed.google_merchant');

Route::get('about-us', [HomeController::class, 'aboutUs'])
    ->name('shop.home.about_us')
    ->middleware('cache.response');

Route::get('gallery', [HomeController::class, 'gallery'])
    ->name('shop.home.gallery');

Route::get('our-work', [HomeController::class, 'ourWork'])
    ->name('shop.home.our_work');

Route::get('planning-and-design', [HomeController::class, 'planningAndDesign'])
    ->name('shop.home.planning_and_design')
    ->middleware('cache.response');

Route::get('projects', [HomeController::class, 'projects'])
    ->name('shop.home.projects');

Route::get('page/{slug}', [PageController::class, 'view'])
    ->name('shop.cms.page.root')
    ->middleware('cache.response');

Route::get('{slug}', [HomeController::class, 'solutions'])
    ->name('shop.home.solutions')
    ->where('slug', 'smart-lighting-systems|smart-door-lock-systems|smart-curtain-systems|smart-hotel-solutions|smart-gate-systems|smart-controlled-light-strips|lighting-accessories|ai-systems|robotic-systems|dcs-systems|servo-systems|iot-systems|scada-systems|smart-security-sensors|alarm-and-access-control|smart-monitoring-and-control|smart-entertainment-systems')
    ->middleware('cache.response');
