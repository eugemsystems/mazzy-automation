<?php

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Webkul\Netcash\Http\Controllers\NetcashController;

Route::group(['middleware' => ['web']], function () {
    Route::controller(NetcashController::class)
        ->prefix('netcash')
        ->group(function () {
            Route::get('redirect', 'redirect')->name('netcash.redirect');

            Route::match(['get', 'post'], 'accept', 'accept')
                ->withoutMiddleware(VerifyCsrfToken::class)
                ->name('netcash.accept');

            Route::match(['get', 'post'], 'decline', 'decline')
                ->withoutMiddleware(VerifyCsrfToken::class)
                ->name('netcash.decline');

            Route::post('notify', 'notify')
                ->withoutMiddleware(VerifyCsrfToken::class)
                ->name('netcash.notify');
        });
});
