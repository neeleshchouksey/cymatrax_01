<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Upload extends Model
{
    protected $fillable = [
        'user_id', 'file_name',
    ];

    public function getCreatedAtAttribute($value)
    {
        // Use Carbon to format the created_at attribute
        return Carbon::parse($value)->format('y-m-d h:i:s A');
    }
}
