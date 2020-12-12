<?php

namespace App\Http\Controllers;

use App\UserCard;
use App\User;
use Illuminate\Http\Request;
use App\Upload;
use DB;
use FFMpeg;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('upload');
    }

    public function profile()
    {
        $user = User::find(Auth::user()->id);
        return view('profile', ["user" => $user]);
    }

    public function update_profile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->name = $request->name ? $request->name : $user->name;
        $user->user = $request->user ? $request->user : $user->user;
        $user->save();

        return Redirect::to('/profile')->with('alert', 'Profile Updated Successfully');

    }

    public function upload(Request $request)
    {
        $count = count($request->file);
        foreach ($request->file as $item) {
            $imageName = time() . '_' . $item->getClientOriginalName();
            $item->move(public_path('upload'), $imageName);
            $data = new Upload();
            $data->user_id = auth()->user()->id;
            $data->file_name = $imageName;
            $data->save();

        }
        return response()->json(['success' => $imageName, 'count' => $count]);
    }

    public function account()
    {
        $getData = DB::table('uploads')->where('user_id', '=', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return view('account', compact('getData'));
    }

    public function upload_summary($id)
    {
        $getData = Upload::where('user_id', '=', auth()->user()->id)->orderBy('created_at', 'desc')->take($id)->get();
        $Audio_ids = array();
        foreach ($getData as $item) {
            $Audio_ids[] = $item->id;
        }
        $audioids = (implode(',', $Audio_ids));
        return view('upload-summary', compact('getData', 'audioids', 'id'));

    }

    public function transaction_details($id)
    {

        $getData = Upload::where('paymentdetails_id', '=', $id)->get();

        return view('transaction-details', compact('getData'));

    }

    public function transactions()
    {
        $paymentdetails = DB::table('paymentdetails')->orderBy('created_at', 'desc')->get();
        return view('transactions', compact('paymentdetails'));
    }

    public function audio_analysis($id){
        $file = Upload::find($id);
        return view('audio-analysis', compact('file'));

    }

    public function directpayment($id)
    {

        $getData = Upload::where('user_id', '=', auth()->user()->id)->orderBy('created_at', 'desc')->take($id)->get();

        $Audio_ids = array();
        foreach ($getData as $item) {
            $Audio_ids[] = $item->id;
        }

        $audioids = (implode(',', $Audio_ids));


        return view('propaypal', compact('getData', 'audioids'));

    }


}
