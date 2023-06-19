<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    function authenticated(Request $request, $user)
    {
        // return session('email__');
        if($user->id != 1 && $user->is_verified == 0 && is_null($user->google_id)){
            Auth::logout();
            $request->session()->put('email__', $user->email);
            return redirect()->back()->with('error', 'Please verify your email!');
        }
        session()->forget('email__');
        session()->forget('email__sentt');
        $user->last_login_at = time();
        $user->save();
    }

    public function sendVerifyEmail($email, Request $request)
    {
        $user = User::where('email', $email)->first();
        if($user->is_verified == 0 && is_null($user->google_id)) {
            $to = $user->email;
            $subject = 'User Verification';
            try {
                $mail = Mail::send('emails.verify', [
                    "id" => $user->id
                ], function ($message) use ($to, $subject) {
                    $message->to($to);
                    $message->subject($subject);
                });
                $request->session()->put('email__sentt', $to);
                $currentDateTime = Carbon::now();
                User::where('email',$email)->update([
                    'email_sent_at' => $currentDateTime->format('Y-m-d H:i:s')
                ]);
    
                return redirect()->route('open-inbox');
            } catch (Exception $e) {
                return $e->getMessage();
            } 
        }else {
            return redirect(url('/login'))->with('message', 'Your email is already verified, Now you can login');
        }
    }
}
