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
        $title = "Dashboard";

        return view('home',compact('title'));
    }
  public function upload_audio()
    {
//        $dir = "public/upload/";
//        $inName = $dir."Ashnikko-DaisyLyrics.mp3";
//        $outName1 = $dir."Ashnikko-DaisyLyrics.wav";
//        $res = shell_exec("lame --quiet --decode  $inName  $outName1  2>&1;");
//        dd($res);

        $title = "Upload Audio";
        return view('upload',compact('title'));
    }

    public function profile()
    {
        $title = "Profile";
        $user = User::find(Auth::user()->id);
        return view('profile', ["user" => $user,"title"=>$title]);
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
            $img = $item->getClientOriginalName();
            $img = preg_replace("/[^a-z0-9\_\-\.]/i", '',$img);

            $imageName = time() . '_' . $img;
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
        $title = "My Account";
        $getData = DB::table('uploads')->where('user_id', '=', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return view('account', compact('getData','title'));
    }

    public function upload_summary($id)
    {
        $title = "Upload Summary";
        $getData = Upload::where('user_id', '=', auth()->user()->id)->orderBy('created_at', 'desc')->take($id)->get();
        $Audio_ids = array();
        foreach ($getData as $item) {
            $Audio_ids[] = $item->id;
        }
        $audioids = (implode(',', $Audio_ids));
        return view('upload-summary', compact('title','getData', 'audioids', 'id'));

    }

    public function transaction_details($id)
    {
        $title = "Transaction Details";
        $getData = Upload::where('paymentdetails_id', '=', $id)->get();

        return view('transaction-details', compact('title','getData'));

    }

    public function transactions()
    {
        $title = "Transaction History";
        $paymentdetails = DB::table('paymentdetails')
            ->where("user_id",Auth::user()->id)
            ->orderBy('created_at', 'desc')->get();
        return view('transactions', compact('paymentdetails','title'));
    }

    public function audio_analysis($id){
        $title = "Audio Analysis";
        $file = Upload::find($id);
        return view('audio-analysis', compact('title','file'));

    }

    public function download_file($file){
        $file = public_path().'/upload/'.$file;
//        $file = asset('public/upload/').'/'.$file;
        return response()->download($file, 'file.mp3');
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
