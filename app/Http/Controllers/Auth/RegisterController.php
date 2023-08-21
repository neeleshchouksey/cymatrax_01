<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\UserSubscription;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $countries = DB::table("countries")->get();
        return view('auth.register',compact('countries'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        
        return Validator::make($data, [
            // 'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            // 'user' => ['required'],
            // 'streetaddress' => ['required'],
            // 'city' => ['required'],
            // 'state' => ['required'],
            // 'country' => ['required'],
            // 'zipcode' => ['required'],
            // 'CaptchaCode'=> 'valid_captcha'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function doRegister(Request $request)
    {
        $data = $request->all();
        $currentDateTime = Carbon::now();
        $exists_user = User::where('email',$data['email'])->first();
        if($exists_user){
            return redirect()->route('register')->with('error', 'This is email is already exists');
        }
        // return $currentDateTime->format('Y-m-d H:i:s');
        $user =  User::create([
            // 'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_sent_at' => $currentDateTime->format('Y-m-d H:i:s'),
            'plan_name'=> 'Community',
            // 'user' => $data['user'],
            // 'address'=>$data['streetaddress'],
            // 'city'=>$data['city'],
            // 'state'=>$data['state'],
            // 'country'=>$data['country'],
            // 'zip_code'=>$data['zipcode']
        ]);
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
            return redirect()->route('open-inbox');
        } catch (Exception $e) {
            return $e->getMessage();
        }

        // if($user){
        //     UserSubscription::create([
        //         'user_id' => $user->id,
        //         'subscription_type_id' => $data['user'],
        //         'activation_date' => date('Y-m-d'),
        //         'end_date' => date('Y-m-d',strtotime('+30 days')),
        //     ]);
        // }

        return $user;
    }

    public function verifyEmail($id)
    {
        $currentDateTime = Carbon::now();
        $oneDayAgo = $currentDateTime->subDay()->format('Y-m-d H:i:s');
        $user = User::find($id);
        if ($user->email_sent_at < $oneDayAgo) {
            return redirect(url('/login'))->with('error', 'Verify link is expired please send new verify mail!');
        }
        $user = User::where('id', $id)->update([
            'is_verified' => 1
        ]);
        if($user){
            session()->forget('email__sentt');
            session()->forget('email__');
            return redirect(url('/login'))->with('message', 'Your email is verified, Now you can login');
        }
    }

    public function openInbox()
    {
        return view('emails.openInbox');
    }
}
