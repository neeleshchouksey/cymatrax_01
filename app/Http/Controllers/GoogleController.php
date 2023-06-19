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
        try {

            $user = Socialite::driver('google')->user();

            
            $is_user = User::where('email', $user->getEmail())->first();

            if (!$is_user) {
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
                Auth::loginUsingId($save_user->id);
            } else {
                $save_user = User::where('email', $user->getEmail())->update([
                    'google_id' => $user->getId()
                ]);

                $save_user = User::where('email', $user->getEmail())->first();
                Auth::loginUsingId($save_user->id);

            }
            return redirect(url('/dashboard'))->with('message', 'You have sucessfully login with google!');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
