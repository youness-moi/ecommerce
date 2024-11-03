<?php

namespace App\Providers;

use App\Models\OrderItem;
use App\Models\Orders;
use App\Services\StockService;
use Error;
use Illuminate\Support\ServiceProvider;
use Monolog\ErrorHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(StockService::class );
        $this->app->singleton(ErrorHandler::class);
        $this->app->bind(Orders::class, function ($app) { return new Orders(); });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
