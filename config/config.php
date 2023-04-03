<?php

return [
    'defaultCurrency' => 'ARS',

    'routes' => [
        'register' => true,
        'prefix' => 'api',
        'middleware' => ['web'],
    ],

    'models' => [
        'user' => 'App\Models\User',
        'currency' => 'Clonixdev\LaravelBill\Models\Currency',
        'invoice' => 'Clonixdev\LaravelBill\Models\Invoice',
        'invoice_item' => 'Clonixdev\LaravelBill\Models\InvoiceItem',
        'order' => 'Clonixdev\LaravelBill\Models\Order',
        'order_item' => 'Clonixdev\LaravelBill\Models\OrderItem',
        'pay_method' => 'Clonixdev\LaravelBill\Models\PayMethod',
        'pay_method_record' => 'Clonixdev\LaravelBill\Models\PayMethodRecord',
        'default_interface' => 'Clonixdev\LaravelBill\Models\PayMethodInterface',
        'process_external_job' => 'Clonixdev\LaravelBill\Jobs\ProcessExternal', 
    ],




];