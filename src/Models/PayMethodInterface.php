<?php

namespace Clonixdev\LaravelBill\Models;



class PayMethodInterface 
{
    


    const STATUS_PENDING = 1;
    const STATUS_REJECT = 2;
    const STATUS_PAID = 3;

    

    /*
        Params: 
        - invoice

        Return:
        - 
    */
    public static function checkout($invoice){




    }


    /*
        Params: 
        - record

        Return:
        - [ 'status' => 1 | 2 | 3 , 'transaction' => 'XXXXXXX' ]
    */
    public static function onMessage($record){


        return [ 'status' => PayMethodInterface::STATUS_PENDING , 'transaction' => 'XXXXXX'];

    }
}