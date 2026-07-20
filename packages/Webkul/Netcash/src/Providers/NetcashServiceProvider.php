<?php

namespace Webkul\Netcash\Providers;

use Illuminate\Support\ServiceProvider;

class NetcashServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerConfig();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'netcash');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'netcash');
    }

    /**
     * Merge the Netcash configuration with payment methods
     */
    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/payment-methods.php', 'payment_methods'
        );
    }
}
