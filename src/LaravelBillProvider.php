<?php

namespace Grosv\LaravelPackageTemplate;

use Illuminate\Support\ServiceProvider;

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
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
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