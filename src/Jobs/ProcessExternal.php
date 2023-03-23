<?php
namespace Clonixdev\LaravelBill\Jobs;

use Clonixdev\LaravelBill\Models\PayMethodRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class ProcessExternal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $record;
    public $request;

    public function __construct($record,$request)
    {
        $this->record = $record;
        $this->request = $request;
    }

    public function handle()
    {
     
        if($this->record->pay_method->interface){

            $return_callback = call_user_func($this->record->pay_method->interface .'::onMessage',$this->record,$this->request);
            $pay_method_record_class = config('bill.pay_method_record_model');
            $this->record->interface_result = $return_callback;
            $this->record->status = $pay_method_record_class::STATUS_PROCESSED;
            $this->record->save();

        }
    }
}