<?php

namespace Clonixdev\LaravelBill\Models;

use Illuminate\Database\Eloquent\Model;

class PayMethod extends Model
{

    protected $fillable = ['name','description','status','params','adapter_class','currency_id'];

    protected $casts = [
        'params' => 'array',
    ];

    public function currency()
    {
        return $this->belongsTo(config('bill.models.currency'));
    }


  public function getParamsAttribute($value)
    {
        if ($value) {
            if (is_array($value)) return (object) $value;
            if (is_string($value)) return json_decode($value);
        }
        return (object) [
            "access_token" => null,
        ];
    }

    public function getConfig(){
         return $this->params;
    }

}