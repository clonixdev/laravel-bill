<?php

namespace Clonixdev\LaravelBill\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    
    protected $fillable = [
        'comment',
        'description',
        'qty',
        'price',
        'tax',
        'unit',
        'amount'
    ];


    protected $attributes = [
        'qty' => 1,
        'tax' => 0,
    ];

    public function invoice()
    {
        return $this->belongsTo(config('bill.models.invoice'));
    }

}