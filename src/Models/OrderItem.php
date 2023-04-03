<?php

namespace Clonixdev\LaravelBill\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    
    public function order()
    {
        return $this->belongsTo(config('bill.order_model'));
    }

}