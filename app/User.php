<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;

// At the top under your namespace

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user', 'address', 'city', 'state', 'email_sent_at', 'country', 'zip_code', 'google_id','plan_id','plan_name','no_of_clean_file'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function uploadedFiles()
    {
        return $this->hasMany(Upload::class, 'user_id', 'id');
    }

    public function cleanedFiles()
    {
        return $this->hasMany(Upload::class, 'user_id', 'id')->where("cleaned",1);
    }
     public function paidFiles()
    {
        return $this->hasMany(Upload::class, 'user_id', 'id');
    }
}
