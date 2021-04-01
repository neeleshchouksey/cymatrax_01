<?php

use App\Admin;
use App\FreeSubscription;
use Illuminate\Support\Facades\Auth;

function get_free_trial_days(){
    return FreeSubscription::first()->days;
}

function checkRoleFeature($feature){

    $admin_id = Auth::guard('admin')->user()->id;
        return Admin::
            join("admin_role_features","admins.role_id","admin_role_features.role_id")
            ->join("features","features.id","admin_role_features.feature_id")
            ->where("admins.id",$admin_id)
            ->where("features.feature",$feature)
            ->first();

    }

?>
