<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;
use Synfony\Component\HttpFoundation\InputBag;
use  App\Paymentdetail;
use DB;
use Illuminate\Support\Facades\Redirect;



class Paymentcontroller extends Controller
{
    public $gateway;
 
    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Pro');
        $this->gateway->setUsername(env('PAYPAL_API_USERNAME'));
        $this->gateway->setPassword(env('PAYPAL_API_PASSWORD'));
        $this->gateway->setSignature(env('PAYPAL_API_SIGNATURE'));
        $this->gateway->setTestMode(true); // here 'true' is for sandbox. Pass 'false' when go live
    }
 
    public function index()
    {
        return view('payment');
    }
 
    public function soxProcessFile ($fName) {
        $dir = "public/upload/";
        
        $inName = $dir.$fName;
     
        $coreName = explode('.',$fName);
   
        $coreName = $coreName[0];
      
        $outName1 = $dir.$coreName . '.WAV';


        $outName2 = $dir.$coreName . 'B.WAV';
      

        $outName = $dir.'new_'.$coreName.".mp3";
 

        exec('lame --quiet --decode ' . $inName . ' ' . $outName1 . ' 2>&1;' .'sox ' . $outName1 . ' -C6 ' . $outName2 . ' --effects-file public/sox/ce.fkt 2>&1;' . 'lame --quiet -V 2 ' . $outName2 . ' ' . $outName);
     
        return $outName;
        }



    public function store(Request $request)
    {

         $arr_expiry = explode("/", $request->input('expiry'));
  
        // $formData = array(
        //     'firstName' => $request->input('first-name'),
        //     'lastName' => $request->input('last-name'),
        //     'number' => $request->input('number'),
        //     'expiryMonth' => trim($arr_expiry[0]),
        //     'expiryYear' => trim($arr_expiry[1]),
        //     'cvv' => $request->input('cvc'),
            
        // );


        // start new code get card id
        $formData = array(
            'firstName' => $request->input('first-name'),
            'lastName' => $request->input('last-name'),
            'number' => $request->input('number'),
            'expiryMonth' => trim($arr_expiry[0]),
            'expiryYear' => trim($arr_expiry[1]),
            'cvv' => $request->input('cvc'),
            'billingAddress1'       => $request->input('streetaddress'),
            'billingCountry'        => 'AU',
            'billingCity'           => $request->input('city'),
            'billingPostcode'       => $request->input('zipcode'),
            'billingState'          => $request->input('email'),
            
        );     
        

        $gateway = Omnipay::create('PayPal_Rest');
        // Initialise the gateway
        $gateway->initialize(array(
                'clientId' => 'Adv3jhEKut2LArUJsrYLivAIyXznwWEgWG2Q2dpXUxVUbDwo40sqxZtSX6fdUVVxWb2I25qB0deSRdll',
                'secret'   => 'EOqYgWNYRjmHw2a0mKBD6XyerOFdg-1gwujR8MdtldBJaDH3uDX4YmOaJarvlaP5fP1tNyu5bpuOJB2x',
                'testMode' => true, // Or false when you are ready for live transactions
        ));

        $card = new CreditCard($formData);
       
            // Do a create card transaction on the gateway
            $transaction = $gateway->createCard(array(
            'card' => $card,
            ));
          
            $response1 = $transaction->send();
            $data = $response1->getData();
            $cardId = $data['id'];
       
         
        //  $response1 =   $gateway->purchase(array('amount' => '10.00', 'currency' => 'USD', 'card' => $cardId ));
       
        // end new code end get card id

     
        try {
            // Send purchase request
            // $response = $this->gateway->purchase([
            //     'amount' => $request->input('amount'),
            //     'currency' => 'USD',
            //     'card' => $formData
            // ])->send();
          //dd($formData2,$cardId);
         
            $response = $this->gateway->purchase([
                'amount' => $request->input('amount'),
                'currency' => 'USD',
                'card' => $formData
            ])->send();
             
            //new code
           
          
            //new code
            // Process response
           

            if ($response->isSuccessful()) {
              
                // Payment was successful
                $arr_body = $response->getData();
                $amount = $arr_body['AMT'];
                $currency = $arr_body['CURRENCYCODE'];
                $transaction_id = $arr_body['TRANSACTIONID'];
                $card = new CreditCard($formData);
                $CardData = $card->getparameters();

                $paymentdetails = new Paymentdetail();
                $paymentdetails->firstname =  $CardData['billingFirstName'];  
                $paymentdetails->lastname =   $CardData['billingLastName'];
                $paymentdetails->email=$request->email;
                $paymentdetails->currencycode =  $currency;  
                $paymentdetails->totalprice =$amount;
                $paymentdetails->timestamp = $arr_body['TIMESTAMP'];   
                $paymentdetails->transationId = $transaction_id;
                $paymentdetails->user_id = auth()->user()->id;   
                $paymentdetails->patmentstatus = $arr_body['ACK'];
                $paymentdetails->duration = $request->totalduration;
                $paymentdetails->card_id = $cardId;
                $paymentdetails->save();



            $paymentid =  db::table('paymentdetails')->where('id','=',$paymentdetails->id)->first();
            $Audio_Ids = $request->fileids;
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
            



                // echo "Payment of $amount $currency is successful. Your Transaction ID is: $transaction_id";
            
            
            } else {
                // Payment failed
                return redirect()->back()->with('error', $response->getMessage());
                // echo "Payment failed. ". $response->getMessage();
            }
        } catch(Exception $exception) {
            dd('error');
            dd($exception);
            echo $e->getMessage();
        }
    }
}
