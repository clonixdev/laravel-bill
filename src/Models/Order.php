<?php

namespace Clonixdev\LaravelBill\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use \Clonixdev\LaravelBill\Models\Concerns\UsesUuid;

    protected $guarded = [];
    public $incrementing = false;

    const STATUS_PENDING = 1;
    const STATUS_BILLED = 2;
    const STATUS_REJECT = 3;

    public function items()
    {
        return $this->hasMany(config('bill.order_item_model'));
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