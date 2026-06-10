<?php

use Illuminate\Support\Facades\Route;
use Webkul\Shop\Http\Controllers\HomeController;

/**
 * Main site routes — no /store prefix.
 * These are the marketing/content pages.
 */

Route::get('/', [HomeController::class, 'index'])
    ->name('shop.home.index')
    ->middleware('cache.response');

Route::get('contact-us', [HomeController::class, 'contactUs'])
    ->name('shop.home.contact_us')
    ->middleware('cache.response');

Route::post('contact-us/send-mail', [HomeController::class, 'sendContactUsMail'])
    ->name('shop.home.contact_us.send_mail');

Route::post('quote/send', [HomeController::class, 'sendQuoteMail'])
    ->name('shop.home.quote.send');

Route::get('about-us', [HomeController::class, 'aboutUs'])
    ->name('shop.home.about_us')
    ->middleware('cache.response');

Route::get('gallery', [HomeController::class, 'gallery'])
    ->name('shop.home.gallery')
    ->middleware('cache.response');

Route::get('our-work', [HomeController::class, 'ourWork'])
    ->name('shop.home.our_work')
    ->middleware('cache.response');

Route::get('planning-and-design', [HomeController::class, 'planningAndDesign'])
    ->name('shop.home.planning_and_design')
    ->middleware('cache.response');

Route::get('{slug}', [HomeController::class, 'solutions'])
    ->name('shop.home.solutions')
    ->where('slug', 'smart-lighting-systems|smart-door-lock-systems|smart-curtain-systems|smart-hotel-solutions|smart-gate-systems|smart-controlled-light-strips|lighting-accessories|ai-systems|robotic-systems|dcs-systems|servo-systems|iot-systems|scada-systems|smart-security-sensors|alarm-and-access-control|smart-monitoring-and-control|smart-entertainment-systems')
    ->middleware('cache.response');
