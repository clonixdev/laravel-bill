<?php

namespace Clonixdev\LaravelBill\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    
    public function invoice()
    {
        return $this->belongsTo(config('bill.invoice_model'));
    }

}