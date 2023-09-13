<?php

namespace App\Http\Controllers;

use App\FileDeleteSetting;
use App\FreeSubscription;
use App\UserCard;
use App\User;
use Illuminate\Http\Request;
use App\Upload;
use Facade\FlareClient\Stacktrace\File;
use FFMpeg;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use App\Settings;
use App\ConstantSettings;


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
        $subscriptions = DB::table('subscription_type')->get();
        $free_clean_files = DB::table('constant_settings')->where('id',3)->first();
        $uploads =  DB::table('uploads')->where('user_id', Auth::user()->id)->groupBy('user_id')
            ->selectRaw('sum(duration_in_sec) as duration, count(*) as count, user_id')->get();

        return view('home', compact('title', 'uploads', 'subscriptions', 'free_clean_files'));
    }

    public function upload_audio()
    {
        //        $dir = "public/upload/";
        //        $inName = $dir."Ashnikko-DaisyLyrics.mp3";
        //        $outName1 = $dir."Ashnikko-DaisyLyrics.wav";
        //        $res = shell_exec("lame --quiet --decode  $inName  $outName1  2>&1;");
        //        dd($res);

        $upload_limits = 'Unlimited';
        $user_limits = null;
        $maxlimit = Auth::user()->no_of_clean_file;
        $uploads = 0;
        if(Auth::user()->subscription == 0 && is_null(Auth::user()->trial_expiry_date)){

            $clean_files = DB::table('constant_settings')->select('value')->where('id', 3)->first();
            $upload_limits = $clean_files->value;
            $user_limits = Upload::where('user_id', Auth::user()->id)->count();

            $upload_limits = (int)$upload_limits + (int)$user_limits;

            // if(($user_limits + $count) > $upload_limits){
            //     return redirect()->back()->with('failed', 'You can not further process');
            // }
        }
        if(Auth::user()->subscription == 1 && is_null(Auth::user()->trial_expiry_date)){

            $clean_files = DB::table('constant_settings')->select('value')->where('id', 3)->first();
            $upload_limits = $clean_files->value;
            $user_limits = Upload::where('user_id', Auth::user()->id)->count();

            $upload_limits = (int)$upload_limits + (int)$user_limits;
            $uploads =  DB::table('uploads')->where('user_id', Auth::user()->id)->groupBy('user_id')
            ->selectRaw('count(*) as count')->where('cleaned', 1)->get();
            // if(($user_limits + $count) > $upload_limits){
            //     return redirect()->back()->with('failed', 'You can not further process');
            // }
        }

        $select =  DB::table('constant_settings')->select('value')->where('id', 4)->first();
        $val = $select->value;
        $title = "Upload Audio";

        $select =  DB::table('constant_settings')->select('value')->where('id', 6)->first();
        $dollerval = $select->value;
        $select =  DB::table('constant_settings')->select('value')->where('id', 7)->first();
        $per_minute = $select->value;
        
        	

        return view('upload', compact('title', 'val','dollerval','per_minute', 'upload_limits','maxlimit','uploads'));
    }

    public function profile()
    {
        $title = "Profile";
        $countries = DB::table("countries")->get();
        $user = User::find(Auth::user()->id);
        return view('profile', ["user" => $user, "title" => $title, "countries" => $countries]);
    }

    public function update_profile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->name = $request->name ? $request->name : $user->name;
        $user->user = $request->user ? $request->user : $user->user;
        $user->address = $request->streetaddress ? $request->streetaddress : $user->address;
        $user->city = $request->city ? $request->city : $user->city;
        $user->state = $request->state ? $request->state : $user->state;
        $user->country = $request->country ? $request->country : $user->country;
        $user->zip_code = $request->zipcode ? $request->zipcode : $user->zip_code;
        $user->save();

        return redirect()->back()->with('message', 'Profile Updated Successfully');
    }

    public function upload(Request $request)
    {
        $count = count($request->file);

        // $upload_limits = 'Unlimited';
        // if(Auth::user()->subscription == 0 && is_null(Auth::user()->trial_expiry_date)){
        //     $upload_limits = FileDeleteSetting::value('clean_files_limits');
        //     $user_limits = Upload::where('user_id', Auth::user()->id)->count();
        //     $upload_limits = (int)$upload_limits + (int)$user_limits;
        //     // if(($user_limits + $count) > $upload_limits){
        //     //     return redirect()->back()->with('failed', 'You can not further process');
        //     // }
        // }

        // return 123123;
        foreach ($request->file as $item) {
            $img = $item->getClientOriginalName();
            $img = preg_replace("/[^a-z0-9\_\-\.]/i", '', $img);

            $imageName = time() . '_' . $img;
            $item->move(public_path('upload'), $imageName);
            $data = new Upload();
            $data->user_id = auth()->user()->id;
            $data->file_name = $imageName;
            $data->save();
            Cache::flush();


        }
        return response()->json(['success' => $imageName, 'count' => $count]);
    }

    public function sendCsvEmail(Request $request)
    {
        $fileName = 'users.csv';
        $lastWeek = date("Y-m-d 00:00:00", strtotime("-7 days"));
        $users = User::where('is_admin', '=', 0)
            ->where('created_at', '>', $lastWeek)
            ->withCount(['uploadedFiles', 'cleanedFiles', 'paidFiles' => function ($q) {
                $q->join("paymentdetails", "paymentdetails.id", "uploads.paymentdetails_id");
            }])->orderBy('id', 'desc')->get();
        if (count($users)) {
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );

            $columns = array('S.No', 'Name', 'Email', 'Address', 'City', 'State', 'Country', 'Zip Code', 'Created At', 'Uploaded Files', 'Cleaned Files', 'Paid Files');

            $file = fopen(storage_path($fileName), 'w');
            fputcsv($file, $columns);

            foreach ($users as $key => $user) {
                $sno = $key + 1;
                $row['sno'] = $sno;
                $row['name'] = $user->name;
                $row['email'] = $user->email;
                $row['address'] = $user->address;
                $row['city'] = $user->city;
                $row['state'] = $user->state;
                $row['country'] = $user->country;
                $row['zip_code'] = $user->zip_code;
                $row['created_at'] = $user->created_at;
                $row['uploaded_files'] = $user->uploaded_files_count;
                $row['cleaned_files'] = $user->cleaned_files_count;
                $row['paid_files'] = $user->paid_files_count;


                fputcsv($file, array(
                    $row['sno'],
                    $row['name'],
                    $row['email'],
                    $row['address'],
                    $row['city'],
                    $row['state'],
                    $row['country'],
                    $row['zip_code'],
                    $row['created_at'],
                    $row['uploaded_files'],
                    $row['cleaned_files'],
                    $row['paid_files'],
                ));
            }

            fclose($file);


            //$data = array('message'=>"Hi, user");
            Mail::raw('Hi, user', function ($message) {
                $message->to('neelesh@manifestinfotech.com', env('APP_NAME'))->subject('Weekly New Registered Users');
                $message->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
                $message->attach(storage_path('users.csv'));
            });
            echo "Email Sent";
        } else {
            //$data = array('message'=>"Users not registered this week");
            Mail::raw('Hi, Users not registered this week', function ($message) {
                $message->to('neelesh@manifestinfotech.com', env('APP_NAME'))->subject('Weekly New Registered Users');
                $message->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
            });
            echo "Email Sent";
        }
    }

    public function account()
    {
        $title = "My Account";
        $getData = Upload::where('user_id', '=', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        foreach ($getData as $key => $upload) {
            $seconds = $upload->duration;
            $minutes = floor($seconds / 60);
            $secondsleft = $seconds % 60;
            if ($minutes < 10) {
                $minutes = '0' . $minutes;
            }
            if ($secondsleft < 10) {
                $secondsleft = '0' . $secondsleft;
            }
            $getData[$key]['duration'] = $minutes . ':' . $secondsleft;
            $getData[$key]['duration_in_min'] = $minutes . ':' . $secondsleft;
        }
      
        $expire_trial_subs = Auth::user()->trial_expiry_date;
        $remaining_file_limits = "'Default'";
        // if(is_null($expire_trial_subs) && Auth::user()->subscription == 0){
        //     $file_limits = FileDeleteSetting::value('clean_files_limits');
        //     $user_limits = Upload::where('user_id', Auth::user()->id)->count();
        //     // return $user_limits;
        //     $remaining_file_limits = $file_limits - $user_limits;
        //     }
        // return $remaining_file_limits;
        $user_limits = Upload::where('user_id', Auth::user()->id)->where('cleaned', 1)->count();
        
        if (Auth::user()->subscription ==  1) {
           
            $file_limits = DB::table('subscription_type')->where('id', Auth::user()->plan_id)->value('no_of_clean_file');
            
            if ($file_limits == 'Unlimited') {
                $remaining_file_limits = "'Unlimited'";
            } else {
                $remaining_file_limits = $file_limits - $user_limits;
                $remaining_file_limits = $remaining_file_limits <= 0 ? 0 : $remaining_file_limits;
            }
        }else if (is_null(Auth::user()->trial_expiry_date)){
           
            $clean_files = DB::table('constant_settings')->select('value')->where('id', 3)->first();
            $file_limits = $clean_files->value;
            $remaining_file_limits = $file_limits - $user_limits;
                $remaining_file_limits = $remaining_file_limits <= 0 ? 0 : $remaining_file_limits;
        }
       
        return view('account', compact('getData', 'title', 'remaining_file_limits'));
    }

    public function upload_summary($id)
    {
        $title = "Upload Summary";
        $getData = Upload::where('user_id', '=', auth()->user()->id)->orderBy('created_at', 'desc')->take($id)->get();

        $expire_trial_subs = Auth::user()->trial_expiry_date;
        $remaining_file_limits = "'Default'";

        $user_limits = Upload::where('user_id', Auth::user()->id)->where('cleaned', 1)->count();
        $dollerValue = DB::table('constant_settings')->where('id',6)->first();
        if (Auth::user()->subscription ==  1) {
            // $file_limits = DB::table('subscription_type')->where('plan_id', Auth::user()->plan_id)->value('no_of_clean_file');
            // if ($file_limits == 'Unlimited') {
            //     $remaining_file_limits = "'Unlimited'";
            // } else {
            //     $remaining_file_limits = $file_limits - $user_limits;
            //     $remaining_file_limits = $remaining_file_limits <= 0 ? 0 : $remaining_file_limits;
            // }

            $user_limits = Upload::where('user_id', Auth::user()->id)->where('cleaned', 1)->count();
            $maxlimit = Auth::user()->no_of_clean_file;

            $remaining_file_limits = ($maxlimit - $user_limits);

        }else if (is_null(Auth::user()->trial_expiry_date)){
            // $file_limits = FileDeleteSetting::value('clean_files_limits');
            // $remaining_file_limits = $file_limits - $user_limits;

               // $remaining_file_limits = $remaining_file_limits <= 0 ? 0 : $remaining_file_limits;
               $user_limits = Upload::where('user_id', Auth::user()->id)->where('cleaned', 1)->count();
               $maxlimit = Auth::user()->no_of_clean_file;

               $remaining_file_limits = ($maxlimit - $user_limits);

        }



        return view('upload-summary', compact('title', 'getData', 'id', 'remaining_file_limits','dollerValue'));
    }

    public function redirectToPayment(Request $request){
        $postData = $request->all();

        // $durationValues = $request->input('durationValues');
        // $ids = $request->input('iDs');
    
        // // Loop through the IDs and update records
        // foreach ($ids as $index => $id) {
        //     $durationValue = $durationValues[$index];
    
        //     // Update the record
        //     Upload::where('id', $id)->where('user_id', Auth::user()->id)
        //         ->update(['duration' => $durationValue]);
        // }

        
        $charge = $postData['charge'];
    
        // Store the data in the session
        session(['postData' => $postData]);
    
        
         return true;
        
    }


    public function redirectToPayInfo(){
        
        $postData = session('postData');
        if ($postData) {
            // Clear the data from the session
            session()->forget('postData');
    
            // Pass the data to the view
            return view('payments.payinfo', compact('postData'));
        }

       // return view('payments.payinfo', compact('charge'));
    }

    public function transaction_details($id)
    {
        $title = "Transaction Details";
        $getData = Upload::where('paymentdetails_id', '=', $id)->get();

        return view('transaction-details', compact('title', 'getData'));
    }

    public function transactions()
    {
        $title = "Transaction History";
        $paymentdetails = DB::table('paymentdetails')
            ->where("user_id", Auth::user()->id)
            ->orderBy('created_at', 'desc')->get();
        return view('transactions', compact('paymentdetails', 'title'));
    }

    public function audio_analysis($id)
    {
        $title = "Audio Analysis";
        $file = Upload::find($id);
        $path = public_path() . "/upload/$file->file_name";
        $ppath = public_path() . "/upload/$file->processed_file";

        $ext = explode(".", $file->file_name)[1];
        if ($ext == "wav") {
            $res = shell_exec("soxi $path");
            $res = explode("\n", $res);
            $res = explode(":", $res[6]);
            $size = $res[1];
        } else {
            $size = convertToReadableSize(filesize(public_path() . '/upload/' . $file->file_name));
        }
        $ext1 = explode(".", $file->processed_file)[1];
        if ($ext1 == "wav") {
            $res1 = shell_exec("soxi $ppath");
            $res1 = explode("\n", $res1);
            $res1 = explode(":", $res1[6]);
            $psize = $res1[1];
        } else {
            $psize = convertToReadableSize(filesize(public_path() . '/upload/' . $file->processed_file));
        }
        return view('audio-analysis', compact('title', 'file', 'size', 'psize'));
    }

    public function download_file($file)
    {
        $file = public_path() . '/upload/' . $file;
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

    public function getUploadedAudio($id)
    {
        $getData = Upload::select('*', DB::Raw('DATE_FORMAT(created_at, "%m-%d-%Y %H:%i %p") as created'))
            ->where('user_id', '=', auth()->user()->id)
            ->orderBy('created_at', 'desc')->take($id)->get();
        return response()->json(['status' => 'success', 'res' => $getData], 200);
    }

    public function getAudio($id)
    {
        $getData = Upload::find($id);
        return response()->json(['status' => 'success', 'res' => $getData], 200);
    }

    public function getTransactionAudio($id)
    {
        $getData = Upload::select('*', DB::Raw('DATE_FORMAT(created_at, "%m-%d-%Y %H:%i %p") as created'))->where('paymentdetails_id', '=', $id)->get();
        return response()->json(['status' => 'success', 'res' => $getData], 200);
    }

    public function getAccountAudio($value)
    {
        $query = Upload::join("users", "users.id", "uploads.user_id")
            ->select('uploads.*', 'users.is_admin', 'users.trial_expiry_date', DB::Raw('DATE_FORMAT(uploads.created_at, "%m-%d-%Y %H:%i %p") as created'))
            ->where('user_id', '=', auth()->user()->id)
            ->orderBy('created_at', 'desc');

        if ($value == 0) {
            $query->where('cleaned', 1);
        }
        if ($value == 1) {
            $query->where('cleaned', 0);
        }

        $getData = $query->get();

        foreach ($getData as $key => $upload) {
            $seconds = $upload->duration;
            $minutes = floor($seconds / 60);
            $secondsleft = $seconds % 60;
            if ($minutes < 10) {
                $minutes = '0' . $minutes;
            }
            if ($secondsleft < 10) {
                $secondsleft = '0' . $secondsleft;
            }
            $getData[$key]['duration'] = $minutes . ':' . $secondsleft;
            $getData[$key]['duration_in_min'] = $minutes . ':' . $secondsleft;
        }

        return response()->json(['status' => 'success', 'res' => $getData], 200);
    }

    public function free_subscription()
    {
        $title = "Confirm Free Subscription";
        return view("free-subscription", compact("title"));
    }

    public function confirm_subscription()
    {
        $user = User::find(Auth::user()->id);
        if (!$user->trial_expiry_date) {
            $days = ConstantSettings::where('id',1)->first();
            $days = $days->value;
            $trial_expiry_date = strtotime("+$days days ", time());
            $user->trial_expiry_date = $trial_expiry_date;
            $user->save();
            return redirect(url('/upload-audio'))->with('message', 'You have successfully subscribed free trial!');
        } else {
            return redirect(url('/dashboard'))->with('error', 'You have already subscribed free trial!');
        }
    }

    public function save_duration(Request $request)
    {
        $arr = $request->duration_arr;
        foreach ($arr as $k => $v) {
            $up = Upload::find($v['id']);
            $up->duration = $v['duration'];
            $up->duration_in_sec = $v['duration_in_sec'];
            $up->save();
        }
        return response()->json(['status' => 'success'], 200);
    }

    public function download(Request $request)
    {
        $files = explode(',', $request->download_files);
        $public_dir = public_path();
        $zipFileName = 'all-files.zip';

        $zip = new ZipArchive;
        if (file_exists($public_dir . '/download/' . $zipFileName)) {
            unlink($public_dir . '/download/' . $zipFileName);
        }

        if ($zip->open($public_dir . '/download/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
            // Add File in ZipArchive
            foreach ($files as $file) {
                $file = trim($file);
                $zip->addFile($public_dir . "/upload/" . $file, $file);
            }
        } else {
            return redirect(url('/account'))->with('error', 'File not created');
        }
        $zip->close();
        // Set Header
        $headers = array(
            'Content-Type' => 'application/octet-stream',
        );
        $filetopath = $public_dir . '/download/' . $zipFileName;
        // Create Download Response
        if (file_exists($filetopath)) {
            return response()->download($filetopath, $zipFileName, $headers);
        } else {
            return redirect(url('/account'))->with('error', 'File not found');
        }
    }

    public function subscription()
    {
        $title = "Select Subscription";
        $subscriptions = DB::table('subscription_type')->get();
        $free_clean_files = DB::table('constant_settings')->where('id',3)->first();
        return view("subscription", compact("title", "subscriptions", "free_clean_files"));
    }
}