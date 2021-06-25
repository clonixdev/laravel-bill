<?php

namespace Clonixdev\LaravelBill;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
class LaravelBillProvider extends ServiceProvider
{
    public function boot(): void
    {
      
        if ($this->app->runningInConsole()) {
            // Export the migration
            if (! class_exists('CreateInvoicesTable')) {
              $this->publishes([
                __DIR__ . '/../database/migrations/2021_04_30_094108_create_invoices_table.php' => database_path('migrations/2021_04_30_094108_create_invoices_table.php'),
                __DIR__ . '/../database/migrations/2021_04_30_094130_create_invoice_items_table.php' => database_path('migrations/2021_04_30_094130_create_invoice_items_table.php'),
                __DIR__ . '/../database/migrations/2021_04_30_094154_create_pay_methods_table.php' => database_path('migrations/2021_04_30_094154_create_pay_methods_table.php'),
                __DIR__ . '/../database/migrations/2021_04_30_094155_create_pay_method_records_table.php' => database_path('migrations/2021_04_30_094155_create_pay_method_records_table.php'),
                __DIR__ . '/../database/migrations/2021_04_30_094156_create_currencies_table.php' => database_path('migrations/2021_04_30_094156_create_currencies_table.php'),
                // you can add any number of migrations here
              ], 'migrations');    
              
              $this->publishes([
                __DIR__.'/../config/config.php' => config_path('bill.php'),
              ], 'config');
            }
          }
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