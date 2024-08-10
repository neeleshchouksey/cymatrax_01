<?php

use App\Admin;
use App\FreeSubscription;
use App\ConstantSettings;
use Illuminate\Support\Facades\Auth;

function get_free_trial_days()
{
    $days = ConstantSettings::where('id', 1)->first();
    $days = $days->value;
    return $days;
}

function checkRoleFeature($feature)
{

    $admin_id = Auth::guard('admin')->user()->id;
    return Admin::
        join("admin_role_features", "admins.role_id", "admin_role_features.role_id")
        ->join("features", "features.id", "admin_role_features.feature_id")
        ->where("admins.id", $admin_id)
        ->where("features.feature", $feature)
        ->first();

}
function convertToReadableSize($size)
{
    $base = log($size) / log(1024);
    $suffix = array("", "KB", "MB", "GB", "TB");
    $f_base = floor($base);
    return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
}


function currentPlan()
{
    $user = \Auth::user();

    if ($user->plan_id == 0)
    {
        $old_subscription = \DB::table('user_subscription')
            ->where("user_id", $user->id)
            ->orderBy("created_at", "DESC")
            ->first();
          if(!$old_subscription){
     $old_subscription = \Auth::user();
}
         if(!isset($old_subscription->is_cancelled)){
          $old_subscription->is_cancelled = 0;
          }
        if ($old_subscription && $old_subscription->plan_end_date && strtotime($old_subscription->plan_end_date) > strtotime(date('Y-m-d')))
        {
            return $old_subscription;
        }
    }

    return $user;
}



?>
