<?php

namespace Clonixdev\LaravelBill\Models;

use Illuminate\Database\Eloquent\Model;

class PayMethodRecord extends Model
{
    const STATUS_INCOMING = 1;
    const STATUS_PROCESSED = 2;


    public function payMethod()
    {
        return $this->belongsTo(config('bill.pay_method_model'));
    }

    public function invoice()
    {
        return $this->belongsTo(config('bill.invoice_model'));
    }

}
