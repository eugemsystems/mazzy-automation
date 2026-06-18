<?php

namespace Webkul\Shipping\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class ShippingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/../Http/helpers.php';

        $this->registerConfig();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'shipping');

        $this->registerProductShippingPrice();
    }

    /**
     * Hook the product shipping price field into the product edit form and
     * persist its value when the product is saved.
     *
     * @return void
     */
    protected function registerProductShippingPrice()
    {
        Event::listen('bagisto.admin.catalog.product.edit.form.after', function ($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('shipping::admin.product-shipping-price');
        });

        Event::listen('catalog.product.update.after', function ($product) {
            if (! request()->has('shipping_price')) {
                return;
            }

            $product->shipping_price = request('shipping_price') ?: 0;

            $product->save();
        });
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/carriers.php', 'carriers'
        );
    }
}
