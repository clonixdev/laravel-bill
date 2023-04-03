<?php

namespace Clonixdev\LaravelBill\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    use \Clonixdev\LaravelBill\Models\Concerns\UsesUuid;
    public $incrementing = false;

    const STATUS_PENDING = 1;
    const STATUS_INCOMING = 2;
    const STATUS_PROCESSED = 3;

    const PAY_STATUS_PENDING = 1;
    const PAY_STATUS_PAID = 2;
    const PAY_STATUS_REJECT = 3;

    public function payMethod()
    {
        return $this->belongsTo(config('bill.models.pay_method'));
    }

    public function invoice()
    {
        return $this->belongsTo(config('bill.models.invoice'));
    }

    public function payMethodRecords()
    {
        return $this->hasMany(config('bill.models.pay_method_record'));
    }
}
