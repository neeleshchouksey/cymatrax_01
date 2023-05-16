<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;

// At the top under your namespace

class UserSubscription extends Authenticatable
{
  
    protected $table="user_subscription";
    protected $fillable = [
        'user_id','subscription_type_id','status','activation_date','end_date'
    ];
   
}
