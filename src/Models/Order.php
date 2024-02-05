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

    protected $fillable = [
        'code',
        'code_format',
        'external_code',
        'tracking_code',
        'seller_name',
        'seller_tax_id',
        'seller_last_name',
        'seller_email',
        'seller_phone',
        'seller_address',
        'seller_city',
        'seller_state',
        'seller_country',
        'buyer_name',
        'buyer_tax_id',
        'buyer_last_name',
        'buyer_email',
        'buyer_phone',
        'buyer_address',
        'buyer_city',
        'buyer_state',
        'buyer_country',
        'status',
        'sub_total',
        'tax',
        'ship',
        'total',
        'ship_lat',
        'ship_lng',
        'ship_address',
        'ship_city',
        'ship_state',
        'ship_country',
        'order_date',
        'order_date_range',
        'expire_at',
        'is_subscription',
        'has_shipping',
        'currency_id',
        'pay_method_id',
        'user_id',
        'comments',
    ];
    
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