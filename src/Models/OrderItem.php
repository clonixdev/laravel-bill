<?php

namespace Clonixdev\LaravelBill\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use \Clonixdev\LaravelBill\Models\Concerns\UsesUuid;


    protected $guarded = [];
    public $incrementing = false;

    protected $fillable = [
        'order_id',
        'tax_type',
        'description',
        'qty',
        'unit',
        'price',
        'amount',
        'tax',
    ];



    public function order()
    {
        return $this->belongsTo(config('bill.models.order'));
    }

}