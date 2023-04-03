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


    public $pay_method;
    public $request;
    public $record;

    public function __construct($request,$pay_method,$record)
    {
        $this->pay_method = $pay_method;
        $this->request = $request;
        $this->record = $record;
    }

    public function handle()
    {
     

        if($this->pay_method->interface){

            $return_callback = call_user_func($this->pay_method->interface .'::onMessage',$this->request,$this->pay_method,$this->record);

            if(isset($return_callback['payment_id'])){
                $payment_class = config('bill.payment_model');
                $payment = $payment_class::where('id',$return_callback['payment_id'])->first();
                if($payment) {
                    $payment->interface_result = $return_callback;
                    $payment->status = $payment_class::STATUS_PROCESSED;
                    $payment->save();
                }
            }
        }
    }
}