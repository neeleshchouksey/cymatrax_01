<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use PhpParser\Node\Expr\AssignOp\Mod;

class AdminRole extends Model
{
    protected $table = "admin_roles";

    function features(){
        return $this->hasMany(AdminRoleFeature::class,"role_id","id");
    }
}
