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

    public function __construct($record)
    {
        $this->record = $record;
    }

    public function handle()
    {
     
        if($this->record->pay_method->interface){

            $return_callback = call_user_func($this->pay_method->interface .'::onMessage');

            $this->record->interface_result = $return_callback;
            $this->record->status = PayMethodRecord::STATUS_PROCESSED;
            $this->record->save();

        }
    }
}