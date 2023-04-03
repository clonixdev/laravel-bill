<?php

namespace Clonixdev\LaravelBill\Models;



class PayMethodAdapter 
{
    



    

    /*
        Params: 
        - invoice

        Return:
        - 
    */
    public static function checkout($invoice,$params,$payment){




    }


    /*
        Params: 
        - record

        Return:
        - [ 'status' => 1 | 2 | 3 , 'transaction' => 'XXXXXXX' ]
    */
    public static function onMessage($request,$pay_method,$record){


        return [ 'status' => Invoice::STATUS_PAID ,'pay_status' => Invoice::PAY_STATUS_PAID , 'ship_status' => Invoice::SHIP_STATUS_DISPATCHING , 'transaction' => 'XXXXXX'];

    }

    public static function getPayment($payment_id){
        $payment_class = config('bill.payment_model');
        $payment = $payment_class::where('id',$payment_id)->first();
        if(!$payment) return;

        return $payment;
    }

    public static function saveRequest($record,$request){
        $pay_method_record_class = config('bill.pay_method_record_model');
        if(!$record) return;
        $record->payload_in = json_encode($request->all());
        $record->status = $pay_method_record_class::STATUS_INCOMING;
        $record->save();
        return $record;
        
    }
}