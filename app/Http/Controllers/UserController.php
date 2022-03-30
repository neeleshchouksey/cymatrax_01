<?php

namespace App\Http\Controllers;

use App\FreeSubscription;
use App\UserCard;
use App\User;
use Illuminate\Http\Request;
use App\Upload;
use Facade\FlareClient\Stacktrace\File;
use FFMpeg;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

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

        return view('home', compact('title'));
    }

    public function upload_audio()
    {
//        $dir = "public/upload/";
//        $inName = $dir."Ashnikko-DaisyLyrics.mp3";
//        $outName1 = $dir."Ashnikko-DaisyLyrics.wav";
//        $res = shell_exec("lame --quiet --decode  $inName  $outName1  2>&1;");
//        dd($res);

        $title = "Upload Audio";
        return view('upload', compact('title'));
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

        return Redirect::to('/profile')->with('alert', 'Profile Updated Successfully');

    }

    public function upload(Request $request)
    {
        $count = count($request->file);
        foreach ($request->file as $item) {
            $img = $item->getClientOriginalName();
            $img = preg_replace("/[^a-z0-9\_\-\.]/i", '', $img);

            $imageName = time() . '_' . $img;
            $item->move(public_path('upload'), $imageName);
            $data = new Upload();
            $data->user_id = auth()->user()->id;
            $data->file_name = $imageName;
            $data->save();

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
                $message->to('neelesh@manifestinfotech.com', env('APP_NAME'))->subject
                ('Weekly New Registered Users');
                $message->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
                $message->attach(storage_path('users.csv'));
            });
            echo "Email Sent";

        } else {
            //$data = array('message'=>"Users not registered this week");
            Mail::raw('Hi, Users not registered this week', function ($message) {
                $message->to('neelesh@manifestinfotech.com', env('APP_NAME'))->subject
                ('Weekly New Registered Users');
                $message->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
            });
            echo "Email Sent";
        }


    }

    public function account()
    {
        $title = "My Account";
        $getData = DB::table('uploads')->where('user_id', '=', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return view('account', compact('getData', 'title'));
    }

    public function upload_summary($id)
    {
        $title = "Upload Summary";
        $getData = Upload::where('user_id', '=', auth()->user()->id)->orderBy('created_at', 'desc')->take($id)->get();
        return view('upload-summary', compact('title', 'getData', 'id'));

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
            $days = FreeSubscription::first()->days;
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
        if(file_exists($public_dir.'/download/'.$zipFileName)){
            unlink($public_dir.'/download/'.$zipFileName);
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
}
