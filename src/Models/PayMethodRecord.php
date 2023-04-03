<?php

namespace Clonixdev\LaravelBill\Models;

use Illuminate\Database\Eloquent\Model;

class PayMethodRecord extends Model
{

    use \Clonixdev\LaravelBill\Models\Concerns\UsesUuid;
    public $incrementing = false;

   // const STATUS_PENDING = 1;
    const STATUS_INCOMING = 2;
    const STATUS_PROCESSED = 3;

    public function payMethod()
    {
        return $this->belongsTo(config('bill.models.pay_method'));
    }


    public function payment()
    {
        return $this->belongsTo(config('bill.models.payment'));
    }


    public function invoice()
    {
        return $this->belongsTo(config('bill.models.invoice'));
    }

}
