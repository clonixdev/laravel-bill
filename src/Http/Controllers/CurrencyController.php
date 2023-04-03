<?php

namespace Clonixdev\LaravelBill\Http\Controllers;

class CurrencyController extends ApiBaseController
{

    function __construct() {
        $this->classname = config('bill.models.currency');
    }


}