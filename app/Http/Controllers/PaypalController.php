<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;



class PaypalController extends Controller
{
    public function createView($id)
    {
        $data = DB::table('subscription_type')->where('id', $id)->get()->toArray();
        return view('payments.create', compact('data'));
    }

    public function paymentProcess(Request $request)
    {
        
        $data = DB::table('subscription_type')->where('id', $request->plan_id)->first();
        DB::table('users')->where('id', Auth::user()->id)->update([
            'plan_id' => $data->plan_id,
            'charges' => $data->charges,
            'no_of_clean_file' => $data->plan_id,
            'plan_name' => $data->name,
            'subscription' => 1,
        ]);
        return redirect()->route('userDashboard')->with('message', 'Congratulations ' . Auth::user()->name . ' on your ' . $data->name . ' subscription');
    }

    public function cancelPlan()
    {
        $data = DB::table('users')->where('id', Auth::user()->id)->update([
            'plan_id' => null,
            'plan_name' => null,
            'charges' => null,
            'no_of_clean_file' => null,
            'subscription' => 0,
        ]);
        if ($data) {
            return redirect()->route('userProfile')->with('message', 'Your plan has been cancelled');
        } else {
            return redirect()->route('userProfile')->with('message', 'Something went wrong, please try again');
        }
    }
}
