# Laravel Bill
Billing package
### Install
Follow next steps:

```shell script
composer require clonixdev/laravel-bill
```


1. run composer require clonixdev/laravel-bill

2. php artisan vendor:publish --provider="Clonixdev\LaravelBill\LaravelBillProvider" --tag="config"

3. php artisan vendor:publish --provider="Clonixdev\LaravelBill\LaravelBillProvider" --tag="migrations"

4. run php artisan migrate


### Config

[
    'defaultCurrency' => 'ARS',
    'prefix' => 'api',
    'middleware' => ['web'],
]
### Routes

GET /invoices
POST /invoices
GET /invoices/{ID}
PUT /invoices/{ID}

### Acknowledgements

