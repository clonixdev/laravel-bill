<?php

namespace Clonixdev\LaravelBill\Http\Controllers;

use Clonixdev\LaravelBill\Models\Currency;

class CurrencyController extends ApiBaseController
{

    function __construct() {
        $this->classname = config('bill.currency_model');
    }


}