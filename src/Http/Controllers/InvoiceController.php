<?php

namespace Clonixdev\LaravelBill\Http\Controllers;

use Clonixdev\LaravelBill\Models\Invoice;

class InvoiceController  extends ApiBaseController
{

    protected $classname = Invoice::class;

  

    public function checkout($id)
    {

        if (! auth()->check()) {
            abort (403, 'Only authenticated users can checkout invoices.');
        }

        $invoice =  Invoice::where('id',$id)->first();

        $pay_method = $invoice->pay_method;

        $client = auth()->user();

        if($pay_method->interface){
            $return_callback = call_user_func($this->pay_method->interface .'::checkout',$invoice,$pay_method->params);
        }


        return ['success' => true];
    }


}