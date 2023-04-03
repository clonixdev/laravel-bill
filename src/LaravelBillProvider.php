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
                __DIR__ . '/../database/migrations/2023_04_03_144131_create_currencies_table.php' => database_path('migrations/2023_04_03_144131_create_currencies_table'),
                __DIR__ . '/../database/migrations/2023_04_03_144132_create_pay_methods_table.php' => database_path('migrations/2023_04_03_144132_create_pay_methods_table.php'),
                __DIR__ . '/../database/migrations/2023_04_03_144134_create_orders_table.php' => database_path('migrations/2023_04_03_144134_create_orders_table.php'),
                __DIR__ . '/../database/migrations/2023_04_03_144135_create_invoices_table.php' => database_path('migrations/2023_04_03_144135_create_invoices_table.php'),
                __DIR__ . '/../database/migrations/2023_04_03_144137_create_pay_method_records_table.php' => database_path('migrations/2023_04_03_144137_create_pay_method_records_table.php'),
                __DIR__ . '/../database/migrations/2023_04_03_144139_create_invoice_items_table.php' => database_path('migrations/2023_04_03_144139_create_invoice_items_table.php'),
                __DIR__ . '/../database/migrations/2023_04_03_144140_create_order_items_table.php' => database_path('migrations/2023_04_03_144140_create_order_items_table.php'),
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