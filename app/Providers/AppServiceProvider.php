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
            $processingCount = 0;
            $hasHistory = false;
            
            if (!empty($userOrderIds)) {
                $orders = \App\Models\Sale::whereIn('id', $userOrderIds)->get();
                $pendingCount = $orders->where('order_status', 'menunggu_pembayaran')->count();
                $processingCount = $orders->where('order_status', 'diproses')->count();
                $hasHistory = $orders->count() > 0;
            }

            $view->with([
                'pendingOrdersCount' => $pendingCount,
                'processingOrdersCount' => $processingCount,
                'hasOrderHistory' => $hasHistory
            ]);
        });
    }
}
