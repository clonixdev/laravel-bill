<?php

namespace Clonixdev\LaravelBill\Models;

use Illuminate\Database\Eloquent\Model;

class PayMethodRecord extends Model
{
    const STATUS_INCOMING = 1;
    const STATUS_PROCESSED = 2;

}
