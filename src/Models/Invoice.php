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


    protected $attributes = [
        'status' => self::STATUS_PENDING,
    ];


    protected $fillable = [
        "seller_name" ,
        "seller_last_name" ,
        "seller_tax_id" ,
        "seller_email" ,
        "seller_phone" ,
        "seller_address" ,
        "seller_city" ,
        "seller_state" ,
        "seller_country" ,
        "buyer_name" ,
        "buyer_last_name" ,
        "buyer_tax_id" ,
        "buyer_email",
        "buyer_phone" ,
        "buyer_address",
        "buyer_city" ,
        "buyer_state" ,
        "buyer_country" ,
        "status" ,
        "sub_total",
        "tax" ,
        "ship" ,
        "total" ,
        "invoice_date" ,
        "invoice_date_range" ,
        "expire_at" ,
        "currency_id" ,
        "pay_method_id" ,
        "order_id" ,
        "comments" ,
        "record_id",
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($invoice) {
            $invoice->calculate();
        });

        static::updated(function ($invoice) {
            if ($invoice->isDirty('status')) {
                $oldStatus = $invoice->getOriginal('status');
                $newStatus = $invoice->getAttribute('status');
                if ($newStatus === self::STATUS_PAID ) {
                    InvoicePaid::dispatch($website_id,$invoice);
                }else  if ($newStatus === self::STATUS_REJECT ) {
                    InvoiceCancelled::dispatch($website_id,$invoice);
                }
            }
        });

    }


    public function items()
    {
        return $this->hasMany(config('bill.models.invoice_item'));
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

    public function calculate(){


        $items = $this->items;

        $total = 0;
        $sub_total = 0;
        $tax = 0;

        foreach($items as $item){
            $sub_total += $item->amount;
            $tax += $tax;

        }

        $total = $sub_total + $tax;

        $this->total = $total;
        $this->sub_total = $sub_total;
        $this->tax = $tax;

    }

}