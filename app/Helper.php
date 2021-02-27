<?php

use App\FreeSubscription;

function get_free_trial_days(){
    return FreeSubscription::first()->days;
}

?>
