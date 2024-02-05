<?php

namespace Clonixdev\LaravelBill\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['name','code','symbol','format','thousands_separator','decimal_point'];



        public static function getOrGenerateCurrency()
    {
        $currency = Currency::where('code', 'ARS')->first();

        if (!$currency) {
            $currency = new Currency();
            $currency->name = "Pesos";
            $currency->code = "ARS";
            $currency->symbol = "$";
            $currency->save();
        }

        return $currency;
    }

}