<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function loginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackFromGoogle()
    {
        try
        {
            $user = Socialite::driver('google')->user();
            $is_user = User::where('email', $user->getEmail())->first();
            //

            if (!$is_user)
            {
                $save_user = User::updateOrCreate(
                    [
                        'google_id' => $user->getId()
                    ],
                    [
                        'name' => $user->getName(),
                        'email' => $user->getEmail(),
                        'password' => Hash::make($user->getName() . '@' . $user->getId()),

                    ]
                );

                $save_user = User::where('email', $user->getEmail())->first();

                if ($save_user->plan_id == null && $save_user->plan_name == null)
                {
                    $subscriptions = \DB::table('subscription_type')->where("plan_id", '0')->first();

                    $save_user->plan_name = $subscriptions->name;
                    $save_user->charges = $subscriptions->charges;
                    $save_user->no_of_clean_file = $subscriptions->no_of_clean_file;
                    $save_user->plan_id = $subscriptions->plan_id;
                    $save_user->price_per_minute = $subscriptions->price_per_minute;
                    $save_user->plan_start_date = \Carbon\Carbon::now();
                    $save_user->subscription = 1;
                    $save_user->save();

                    \DB::table('user_subscription')->insert([
                        'subscription' => 1,
                        'user_id' => $save_user->id,
                        'plan_id' => $subscriptions->plan_id ?? '',
                        'plan_name' => $subscriptions->name ?? '',
                        'charges' => $subscriptions->charges ?? '',
                        'no_of_clean_file' => $subscriptions->no_of_clean_file ?? '',
                        'price_per_minute' => $subscriptions->price_per_minute ?? '',
                        'plan_start_date' => $save_user->plan_start_date,
                    ]);

                }


                Auth::loginUsingId($save_user->id);

            } else
            {
                $save_user = User::where('email', $user->getEmail())->update([
                    'google_id' => $user->getId()
                ]);

                $save_user = User::where('email', $user->getEmail())->first();
                Auth::loginUsingId($save_user->id);

            }
            return redirect(url('/dashboard'))->with('message', 'You have successfully login with google!');
        } catch (Exception $e)
        {
            // dd($e->getMessage());
            return $e->getMessage();
        }
    }
}
