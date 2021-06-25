<?php

namespace Clonixdev\LaravelBill\Http\Controllers;

use Clonixdev\LaravelBill\Jobs\ProcessExternal;
use Clonixdev\LaravelBill\Models\PayMethod;
use Clonixdev\LaravelBill\Models\PayMethodRecord;

class PayMethodController extends ApiBaseController
{

    protected $classname = PayMethod::class;




    public function externalLink($id){
        $pay_method = PayMethod::where('id',$id)->first();
        $request = request();

        $record = new PayMethodRecord();
        $record->pay_method_id = $pay_method->id;
        $record->payload = $request->all();

        $record->save();
        ProcessExternal::dispatch($record);

    }
}