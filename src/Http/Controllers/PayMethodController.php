<?php

namespace Clonixdev\LaravelBill\Http\Controllers;

class PayMethodController extends ApiBaseController
{

    function __construct() {
        $this->classname = config('bill.models.pay_method');
    }



    public function externalLink(){




        $request = request();
        $pay_method_id = $request->pay_method_id;
        $pay_method = $this->classname::where('id',$pay_method_id)->first();
        $request = request();
        $pay_method_record_class = config('bill.models.pay_method_record');

        $record = new $pay_method_record_class();
        $record->pay_method_id = $pay_method->id;
        $record->status = $pay_method_record_class::STATUS_INCOMING;
        $record->save();

        $process_external_class = config('bill.models.process_external_job');

        $process_external_class::dispatch($request->all(),$pay_method,$record);

        return ['success' => true];
    }

}
