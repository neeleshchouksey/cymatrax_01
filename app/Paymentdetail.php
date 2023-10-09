<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paymentdetail extends Model
{
    protected $fillable = [
       'firstname','lastname','currencycode','totalprice','timestamp','payid', 'user_id', 'payment_status','duration'
    ];
}
