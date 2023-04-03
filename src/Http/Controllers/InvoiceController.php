<?php

namespace Clonixdev\LaravelBill\Http\Controllers;

class InvoiceController  extends ApiBaseController
{


    function __construct() {
        $this->classname = config('bill.models.invoice');
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
            abort(400,'Invalid invoice.');
        }
        $pay_method = $invoice->payMethod;
        if(!$pay_method){
            abort(400,'Invalid pay method.');
        }
        $client = auth()->user();



        $payment_class = config('bill.models.payment');

        $payment = new $payment_class();
        $payment->pay_method_id = $pay_method->id;
        $payment->invoice_id = $id;
        $payment->status = $payment_class::STATUS_PENDING;
        $payment->pay_status = $payment_class::PAY_STATUS_PENDING;
        $payment->save();

  


        if($pay_method->adapter_class){
            $return_callback = call_user_func($pay_method->adapter_class .'::checkout',$invoice,$pay_method->params,$payment);
            return ['success' => true , 'callback' => $return_callback ];
        }else{
            abort(400,'Invalid Adapter class.');
        }
    
    }


}
