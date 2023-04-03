<?php

namespace Clonixdev\LaravelBill\Http\Controllers;


class OrderController  extends ApiBaseController
{

    protected $invoice_classname;

    function __construct() {
        $this->classname = config('bill.models.order');
        $this->invoice_classname = config('bill.models.invoice');
    }


    public function bill()
    {
        $request = request();
        $id = $request->id;
       
        $order = $this->classname::where('id',$id)->first();

        $invoice = $this->invoice_classname::createFromOrder($order);
        
        return [ 'success' => true , 'invoice' => $invoice];
    }


}
