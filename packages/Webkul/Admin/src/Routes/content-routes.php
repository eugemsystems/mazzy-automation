<?php

use Illuminate\Support\Facades\Route;
use Webkul\Admin\Http\Controllers\Content\BannerController;
use Webkul\Admin\Http\Controllers\Content\GalleryController;
use Webkul\Admin\Http\Controllers\Content\ProjectController;

Route::prefix('content')->group(function () {

    /**
     * Gallery / Our Work items.
     */
    Route::controller(GalleryController::class)->prefix('gallery')->group(function () {
        Route::get('', 'index')->name('admin.content.gallery.index');
        Route::get('create', 'create')->name('admin.content.gallery.create');
        Route::post('create', 'store')->name('admin.content.gallery.store');
        Route::get('edit/{id}', 'edit')->name('admin.content.gallery.edit');
        Route::put('edit/{id}', 'update')->name('admin.content.gallery.update');
        Route::delete('delete/{id}', 'destroy')->name('admin.content.gallery.destroy');
    });

    /**
     * Home page banners.
     */
    Route::controller(BannerController::class)->prefix('banners')->group(function () {
        Route::get('', 'index')->name('admin.content.banners.index');
        Route::get('create', 'create')->name('admin.content.banners.create');
        Route::post('create', 'store')->name('admin.content.banners.store');
        Route::get('edit/{id}', 'edit')->name('admin.content.banners.edit');
        Route::put('edit/{id}', 'update')->name('admin.content.banners.update');
        Route::delete('delete/{id}', 'destroy')->name('admin.content.banners.destroy');
    });

    /**
     * Projects.
     */
    Route::controller(ProjectController::class)->prefix('projects')->group(function () {
        Route::get('', 'index')->name('admin.content.projects.index');
        Route::get('create', 'create')->name('admin.content.projects.create');
        Route::post('create', 'store')->name('admin.content.projects.store');
        Route::get('edit/{id}', 'edit')->name('admin.content.projects.edit');
        Route::put('edit/{id}', 'update')->name('admin.content.projects.update');
        Route::delete('delete/{id}', 'destroy')->name('admin.content.projects.destroy');
        Route::delete('images/{imageId}', 'destroyImage')->name('admin.content.projects.images.destroy');
    });
});
