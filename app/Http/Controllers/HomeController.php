<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Upload;
use DB;
use FFMpeg;
use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;

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
  
        
        $count = count($request->file);
        foreach($request->file as $item){
         
        
            $imageName = time().'_'.$item->getClientOriginalName();
            $item->move(public_path('upload'), $imageName);
            $data = new Upload();
            $data->user_id = auth()->user()->id;   
            $data->file_name = $imageName;
            $data->save();
           
        }
      
        return response()->json(['success' => $imageName,'count'=>$count]);
    

    }

    public function fetch()
    {
          $getData=DB::table('uploads')->where('user_id','=',auth()->user()->id)->orderBy('created_at', 'desc')->get();

         

          return view('displayprofile',compact('getData'));
    }

    public function filedetail($id)
    {
      
       
       $getData = Upload::where('user_id','=',auth()->user()->id)->orderBy('created_at', 'desc')->take($id)->get();
        
       $Audio_ids=array();
       foreach($getData  as $item){
           $Audio_ids[]=$item->id;
       }
   
       $audioids=(implode(',',$Audio_ids));
      

       return view('filedetail',compact('getData','audioids','id'));
    
    }
    public function transactionfile_info($id)
    {
       
       $getData = Upload::where('paymentdetails_id','=',$id)->get();

       return view('paymentinfo',compact('getData'));
    
    }
    

    public function transactondetails(){

        $paymentdetails=DB::table('paymentdetails')->orderBy('created_at', 'desc')->get();

        return view('transactonHistory',compact('paymentdetails'));
    }

    public function propaypal($id){

        $getData = Upload::where('user_id','=',auth()->user()->id)->orderBy('created_at', 'desc')->take($id)->get();
        
        $Audio_ids=array();
        foreach($getData  as $item){
            $Audio_ids[]=$item->id;
        }
    
        $audioids=(implode(',',$Audio_ids));
       

        return view('propaypal',compact('getData','audioids'));
       
    }

    public function propaypalsingle($id){

        $getData = Upload::where('id','=',$id)->where('user_id','=',auth()->user()->id)->orderBy('created_at', 'desc')->get();
        
        $Audio_ids=array();
        foreach($getData  as $item){
            $Audio_ids[]=$item->id;
        }
    
        $audioids=(implode(',',$Audio_ids));
       

        return view('propaypal',compact('getData','audioids'));
       
    }



    public function directpayment($id){

        $getData = Upload::where('user_id','=',auth()->user()->id)->orderBy('created_at', 'desc')->take($id)->get();
        
        $Audio_ids=array();
        foreach($getData  as $item){
            $Audio_ids[]=$item->id;
        }
    
        $audioids=(implode(',',$Audio_ids));
       

        
        return view('propaypal',compact('getData','audioids'));
       
    }

    
}
