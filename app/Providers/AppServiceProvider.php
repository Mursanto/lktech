<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\ProductObserver;
use App\Models\Product;

use Illuminate\Pagination\Paginator;

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
        Paginator::useTailwind();
        Product::observe(ProductObserver::class);

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('web_settings')) {
                \Illuminate\Support\Facades\View::share('settings', \App\Models\WebSetting::first());
            }
        } catch (\Exception $e) {
            // Ignore if DB is not ready
        }

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $userOrderIds = session()->get('user_orders', []);
            $pendingCount = 0;
            
            if (!empty($userOrderIds)) {
                $pendingCount = \App\Models\Sale::whereIn('id', $userOrderIds)
                                     ->where('payment_status', 'pending')
                                     ->count();
            }

            $view->with('pendingOrdersCount', $pendingCount);
        });
    }
}
