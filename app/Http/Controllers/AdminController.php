<?php

namespace App\Http\Controllers;

use App\FreeSubscription;
use App\UserCard;
use Illuminate\Http\Request;
use App\Upload;
use DB;
use FFMpeg;
use Illuminate\Support\Facades\Auth;
use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function login()
    {
        return view('admin.login');
    }

    public function admin_login(Request $request)
    {

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/admin/dashboard');
        } else {
            return redirect(url('/admin'))->with('error', 'Invalid Credentials');
        }
    }

    public function index()
    {
        return view('admin.index');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    public function free_subscription()
    {
        $data = FreeSubscription::first();
        return view('admin.free-subscription',compact('data'));
    }

    public function update_free_subscription_days(Request $request){
        $fs = FreeSubscription::first();
        $fs->days = $request->days;
        $fs->save();
        return redirect()->back()->with('success','Updated Successfully');

    }
}
