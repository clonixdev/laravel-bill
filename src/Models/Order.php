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
        return $this->hasMany(config('bill.models.order_item'));
    }

    public function user()
    {
        return $this->belongsTo(config('bill.models.user'));
    }

    public function payMethod()
    {
        return $this->belongsTo(config('bill.models.pay_method'));
    }
    
    public function currency()
    {
        return $this->belongsTo(config('bill.models.currency'));
    }

    public function calculateShipping()
    {
        if ($this->has_shipping ) {
            return $this->ship;
        }
        return 0; // NO SHIPPING
    }



}