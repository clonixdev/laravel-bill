<?php

namespace Clonixdev\LaravelBill\Models;

use Illuminate\Database\Eloquent\Model;

class PayMethod extends Model
{
    public function currency()
    {
        return $this->belongsTo(config('bill.models.currency'));
    }



    public function getConfig(){
        return json_decode($this->params);
    }

}
