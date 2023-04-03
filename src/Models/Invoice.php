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

    public function order()
    {
        return $this->belongsTo(config('bill.models.order'));
    }

    public function user()
    {
        return $this->belongsTo(config('bill.models.user'));
    }

    public function payMethod()
    {
        return $this->belongsTo(config('bill.models.pay_method'));
    }

    public function payments()
    {
        return $this->hasMany(config('bill.models.payment'));
    }

    public function payMethodRecords()
    {
        return $this->hasMany(config('bill.models.pay_method_record'));
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

    public static function createFromOrder($order){

        $invoice = new self();
        $invoice->fill($order->getAttributes());
        $invoice->save();
        $order_items = $order->items;
        $invoice_item_class = config('bill.invoice_item_model');
        foreach($order_items as $order_item){
            $invoice_item = new  $invoice_item_class();
            $invoice_item->fill($order_item->getAttributes());
            $invoice_item->invoice_id = $invoice->id;
            $invoice_item->save();
        }

        return $invoice;
    }



}