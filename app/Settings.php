<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
     protected $table="settings";
     protected $fillable = [
        'user_id', 'key', 'value', 'created_at', 'updated_at'
    ];

}
