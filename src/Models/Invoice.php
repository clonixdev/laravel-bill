<?php

namespace Clonixdev\LaravelBill\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use \Clonixdev\LaravelBill\Models\Concerns\UsesUuid;

    protected $guarded = [];
    public $incrementing = false;

    const STATUS_PENDING = 1;
    const STATUS_PAID = 2;
    const STATUS_REJECT = 3;
    const STATUS_SHIPPING = 4;
    const STATUS_FINISHED = 5;

    const PAY_STATUS_PENDING = 1;
    const PAY_STATUS_PAID = 2;
    const PAY_STATUS_REJECT = 3;

    const SHIP_STATUS_NO_SHIPPING = 0;
    const SHIP_STATUS_PENDING = 1;
    const SHIP_STATUS_DISPATCHING = 2;
    const SHIP_STATUS_SENT = 3;
    const SHIP_STATUS_DELIVERED = 4;

    public function items()
    {
        return $this->hasMany(config('bill.invoice_item_model'));
    }

    public function user()
    {
        return $this->belongsTo(config('bill.user_model'));
    }

    public function payMethod()
    {
        return $this->belongsTo(config('bill.pay_method_model'));
    }
    public function currency()
    {
        return $this->belongsTo(config('bill.currency_model'));
    }



    public function calculateShipping()
    {



        if ($this->has_shipping ) {

            return $this->ship;

        }

        return 0; // NO SHIPPING
    }



}