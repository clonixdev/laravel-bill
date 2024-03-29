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
     

        if($this->pay_method->adapter_class){


            
            $return_callback = call_user_func($this->pay_method->adapter_class .'::onMessage',$this->request,$this->pay_method,$this->record);
            $this->record->payload = $this->request;
            $this->record->adapter_result =$return_callback;
            if(isset($return_callback['invoice_id'])){
                $invoice_id = $return_callback['invoice_id'];
                $this->record->invoice_id = $return_callback['invoice_id'];
            }
            if(isset($return_callback['payment_id'])){

                $this->record->payment_id = $return_callback['payment_id'];

                $payment_class = config('bill.models.payment');
                $payment = $payment_class::where('id',$return_callback['payment_id'])->first();
                if($payment) {
                    $payment->adapter_result = $return_callback;
                    $payment->status = $payment_class::STATUS_PROCESSED;
                    $payment->save();
                }
            }

            if(isset($return_callback['pay_status'])){
                $new_status = $return_callback['pay_status'];

                if(isset($return_callback['invoice_id'])){
                    $invoice_class = config('bill.models.invoice');
                    $invoice = $invoice_class::where('id',$invoice_id)->first();

                    $invoice->status = $new_status;
                    $invoice->save();
                }

            }

            $this->record->status = PayMethodRecord::STATUS_PROCESSED;
            $this->record->save();


            
        }
    }
}