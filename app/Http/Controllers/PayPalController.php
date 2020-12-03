<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use Illuminate\Support\Facades\Redirect;
use  App\Paymentdetail;
use App\Upload;
use DB;

class PayPalController extends Controller
{
    public function payment(Request $request)
    {
        //for single file
        $totalcost = $request->totalcost;
        $totalduration = $request->totalduration;
        if($totalcost == "singlefile"){
        $fileid =  $request->fileids;
        $durationseconds = $request->totalduration;
        $minutes = intval($durationseconds / 60);
        $seconds =  $durationseconds % 60;
        $totalduration =  $minutes . '.' . $seconds;
        $totalduration = (float)$totalduration;
        $totalcost = $totalduration*1;
        
        
        // $totalcost = round($totalcost, 2);
        // dd($totalcost);
        }
        // end single file

        // $totalcost = $request->totalcost;
        
        $data = [];
        $data['items'] = [
            [
                'name' => $request->fileids,
                'price' => $totalcost,
                'desc'  => $totalduration,
                'qty' => 1
            ]
        ];
  
        $data['invoice_id'] = 1;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('payment.success');
        $data['cancel_url'] = route('payment.cancel');
        $data['total'] = $totalcost;
        
        $provider = new ExpressCheckout; 
        
        $response = $provider->setExpressCheckout($data);
     
  
        $response = $provider->setExpressCheckout($data, true);
       
  
        return redirect($response['paypal_link']);
    }
   
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        return  Redirect::to('/home')->with('alert', 'Your payment not done.');
    }
  
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */

    public function soxProcessFile ($fName) {
        $dir = "public/images/";
        
        $inName = $dir.$fName;
        // dd($inName);
        $coreName = explode('.',$fName);
       // dd($coreName);
        $coreName = $coreName[0];
        //dd($coreName);
        $outName1 = $dir.$coreName . '.WAV';
        //dd($outName1);

        $outName2 = $dir.$coreName . 'B.WAV';
        //dd($outName2);

        $outName = $dir.'new_'.$coreName.".mp3";
        //dd($outName);

        exec('lame --quiet --decode ' . $inName . ' ' . $outName1 . ' 2>&1;' .'sox ' . $outName1 . ' -C6 ' . $outName2 . ' --effects-file public/sox/ce.fkt 2>&1;' . 'lame --quiet -V 2 ' . $outName2 . ' ' . $outName);
     
        return $outName;
        }

    public function success(Request $request)
    {
       
        $provider = new ExpressCheckout; 
        $response = $provider->getExpressCheckoutDetails($request->token);
      
         if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {

            $paymentdetails = new Paymentdetail();
            $paymentdetails->firstname = $response['FIRSTNAME'];  
            $paymentdetails->lastname = $response['LASTNAME'];
            $paymentdetails->email=$response['EMAIL'];
            $paymentdetails->currencycode = $response['CURRENCYCODE'];  
            $paymentdetails->totalprice = $response['AMT'];
            $paymentdetails->timestamp = $response['TIMESTAMP'];   
            $paymentdetails->payid = $response['PAYERID'];
            $paymentdetails->user_id = auth()->user()->id;   
            $paymentdetails->patmentstatus = $response['ACK'];
            $paymentdetails->duration = $response['L_DESC0'];
            $paymentdetails->save();

            $paymentid =  db::table('paymentdetails')->where('id','=',$paymentdetails->id)->first();
            $Audio_Ids = $response['L_NAME0'];
            $ids_in_array = (explode(",", $Audio_Ids)); //convert into array

            foreach($ids_in_array as $item){

                $getfilename = DB::table('uploads')
                ->where('id', $item)
                ->select('file_name')  //get file name
                ->first();

                $totalfilename = $this->soxProcessFile($getfilename->file_name); //call function for file cleaning 
                $filename_new =  substr($totalfilename, 14);
             
                $uploads = DB::table('uploads')
                ->where('id', $item)  //update uploads
                ->update(['paymentdetails_id' => $paymentid->id,'processed_file' => $filename_new,'cleaned' => 1]);
                
              }

            return  Redirect::to('/transactondetails')->with('alert', 'Payment Completed Successfully');
            //return  Redirect::to('/home')->with('alert', 'Your payment done successfully');

        }
  
    }
}
