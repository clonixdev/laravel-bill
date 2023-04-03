<?php

namespace Clonixdev\LaravelBill\Http\Controllers;

class PayMethodController extends ApiBaseController
{

    function __construct() {
        $this->classname = config('bill.models.pay_method');
    }



    public function externalLink(){
        $request = request();
        $id = $request->id;
        $pay_method = $this->classname::where('id',$id)->first();
        $request = request();
        $pay_method_record_class = config('bill.models.pay_method_record');


        $record = new $pay_method_record_class();
        $record->pay_method_id = $pay_method->id;
        $record->status = $pay_method_record_class::STATUS_PENDING;
        $record->invoice_id = $id;
        $record->save();

        $process_external_class = config('bill.process_external_job');
        $process_external_class::dispatch($request,$pay_method,$record);

    }
}
