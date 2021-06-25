<?php

namespace Clonixdev\LaravelBill;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
class LaravelBillProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->registerRoutes();

    }


    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        });
    }


    protected function routeConfiguration()
    {
        return [
            'prefix' => config('bill.prefix'),
            'middleware' => config('bill.middleware'),
        ];
    }


    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'bill');
    }
}