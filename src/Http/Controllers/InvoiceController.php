<?php

namespace Clonixdev\LaravelBill\Http\Controllers;

class InvoiceController  extends ApiBaseController
{

    protected $eager_loading = ['items'];

    function __construct() {
        $this->classname = config('bill.models.invoice');
        
    }



        /**
     * @OA\Get(
     *     path="/api/invoices",
     *     tags={"bill","invoices"},
     *     @OA\Response(response="200", description="invoices")
     * )
     */
    public function index(){
        return parent::index();
    }

    /**
     * @OA\Get(
     *     path="/api/invoices/{id}",
     *     tags={"bill","invoices"},
     *     @OA\Response(response="200", description="invoices")
     * )
     */
    public function show(){
        $request = request();
        $id = $request->id;
        return $this->classname::where('id',$id)->with($this->eager_loading)->firstOrFail();
    }

    

    /**
     * @OA\Post(
     *     path="/api/invoices/",
     *     tags={"bill","invoices"},
     *     @OA\Response(response="200", description="invoices")
     * )
     */
    public function store(){
        return parent::store();
    }

    /**
     * @OA\Put(
     *     path="/api/invoices/{id}",
     *     tags={"bill","invoices"},
     *     @OA\Response(response="200", description="invoices")
     * )
     */
    public function update(){
        return parent::update();
    }

    /**
     * @OA\Delete(
     *     path="/api/invoices/{id}",
     *     tags={"bill","invoices"},
     *     @OA\Response(response="200", description="invoices")
     * )
     */
    public function destroy(){
        return parent::destroy();
    }


    /**
     * @OA\Post(
     *     path="/api/invoices/{id}/checkout",
     *     tags={"bill","invoices"},
     *     @OA\Response(response="200", description="invoices")
     * )
     */
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


        
        $pay_method_id = $request->pay_method_id;
        $pay_method_class = config('bill.models.pay_method');

        if($pay_method_id){
            $pay_method = $pay_method_class::where('id',$pay_method_id)->first();
            if($pay_method){
                $invoice->pay_method_id =    $pay_method->id;
                $invoice->save();
            }

        }else{
            $pay_method = $invoice->payMethod;
        }


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
            $callback_modal = false;

            return ['success' => true , 'callback' => $return_callback , 'callback_modal' => $callback_modal ];
        }else{
            abort(400,'Invalid Adapter class.');
        }

    }


}