<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\ProductObserver;
use App\Models\Product;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Product::observe(ProductObserver::class);

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('web_settings')) {
                \Illuminate\Support\Facades\View::share('settings', \App\Models\WebSetting::first());
            }
        } catch (\Exception $e) {
            // Ignore if DB is not ready
        }
    }
}
