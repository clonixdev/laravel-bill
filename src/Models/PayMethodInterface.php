<?php

namespace Clonixdev\LaravelBill\Models;



class PayMethodInterface 
{
    



    

    /*
        Params: 
        - invoice

        Return:
        - 
    */
    public static function checkout($invoice,$params){




    }


    /*
        Params: 
        - record

        Return:
        - [ 'status' => 1 | 2 | 3 , 'transaction' => 'XXXXXXX' ]
    */
    public static function onMessage($record,$request){


        return [ 'status' => Invoice::STATUS_PAID ,'pay_status' => Invoice::PAY_STATUS_PAID , 'ship_status' => Invoice::SHIP_STATUS_DISPATCHING , 'transaction' => 'XXXXXX'];

    }
}