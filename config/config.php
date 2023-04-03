<?php

return [
    'defaultCurrency' => 'ARS',
    'prefix' => 'api',
    'middleware' => ['web'],


    'user_model' => 'App\Models\User',
    'currency_model' => 'Clonixdev\LaravelBill\Models\Currency',
    'invoice_model' => 'Clonixdev\LaravelBill\Models\Invoice',
    'invoice_item_model' => 'Clonixdev\LaravelBill\Models\InvoiceItem',

    'order_model' => 'Clonixdev\LaravelBill\Models\Order',
    'order_item_model' => 'Clonixdev\LaravelBill\Models\OrderItem',

    'pay_method_model' => 'Clonixdev\LaravelBill\Models\PayMethod',
    'pay_method_record_model' => 'Clonixdev\LaravelBill\Models\PayMethodRecord',

    'default_interface' => 'Clonixdev\LaravelBill\Models\PayMethodInterface',

    'process_external_job' => 'Clonixdev\LaravelBill\Jobs\ProcessExternal', 


];