<?php

namespace Clonixdev\LaravelBill\Http\Controllers;

use Clonixdev\LaravelBill\Models\Invoice;

class InvoiceController  extends ApiBaseController
{


    function __construct() {
        $this->classname = config('bill.invoice_model');
    }


    public function checkout()
    {
        $request = request();
        $id = $request->id;
        if (! auth()->check()) {
            abort (403, 'Only authenticated users can checkout invoices.');
        }
        $invoice =  $this->classname::where('id',$id)->first();
        if(!$invoice){
            abort(404,'Invalid invoice.');
        }
        $pay_method = $invoice->payMethod;
        $client = auth()->user();
        if($pay_method->interface){
            $return_callback = call_user_func($pay_method->interface .'::checkout',$invoice,$pay_method->params);
        }
        return ['success' => true];
    }


}
