<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\UserSubscription;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user' => ['required'],
            'streetaddress' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'country' => ['required'],
            'zipcode' => ['required'],
            'CaptchaCode'=> 'valid_captcha'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user' => $data['user'],
            'address'=>$data['streetaddress'],
            'city'=>$data['city'],
            'state'=>$data['state'],
            'country'=>$data['country'],
            'zip_code'=>$data['zipcode']
        ]);

        if($user){
            UserSubscription::create([
                'user_id' => $user->id,
                'subscription_type_id' => $data['user'],
                'activation_date' => date('Y-m-d'),
                'end_date' => date('Y-m-d',strtotime('+30 days')),
            ]);
        }

        return $user;
    }
}
