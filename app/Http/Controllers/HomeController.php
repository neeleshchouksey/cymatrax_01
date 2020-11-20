<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Upload;
use DB;

class HomeController extends Controller
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
        return view('home');
    }

   

    public function upload(Request $request)
    { 
  
        
        
        foreach($request->file as $item){
         
            $imageName = time().'_'.$item->getClientOriginalName();
            $item->move(public_path('images'), $imageName);
            $data = new Upload();
            $data->user_id = auth()->user()->id;   
            $data->file_name = $imageName;
            // $data->audio_duration = ($item.duration);
            $data->save();
           
        }
      
        return response()->json(['success' => $imageName]);
    

    }

    public function fetch()
    {
          $getData=DB::table('uploads')->where('user_id','=',auth()->user()->id)->get();
        //   foreach($getData as $item){
        

        // //   function calculateFileSize($file){

        // //     $ratio = 16000; //bytespersec
        
        // //     if (!$file) {
        
        // //         exit("Verify file name and it's path");
        
        // //     }
            
        // //     $file_size = filesize($file);
        
        // //     if (!$file_size)
        // //         exit("Verify file, something wrong with your file");
        
        // //     $duration = ($file_size / $ratio);
        // //     $minutes = floor($duration / 60);
        // //     $seconds = $duration - ($minutes * 60);
        // //     $seconds = round($seconds);
        // //     echo "$minutes:$seconds minutes";
        
        // // }
        
        // // $file = 'file_example_MP3_700KB.mp3'; //Enter File Name mp3/wav
        // // print(calculateFileSize($file));

        // //   }
          
          return view('displayprofile',compact('getData'));
    }

   



}
