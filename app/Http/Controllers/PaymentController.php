<?php

namespace App\Http\Controllers;

use App\Upload;
use App\UserCard;
use App\User;
use http\Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Omnipay\Common\Exception\InvalidCreditCardException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;
use  App\Paymentdetail;
use DB;
use Illuminate\Support\Facades\Redirect;


class PaymentController extends Controller
{
    public $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Pro');
        $this->gateway->setUsername(env('PAYPAL_API_USERNAME'));
        $this->gateway->setPassword(env('PAYPAL_API_PASSWORD'));
        $this->gateway->setSignature(env('PAYPAL_API_SIGNATURE'));
//        $this->gateway->setClientId('Adv3jhEKut2LArUJsrYLivAIyXznwWEgWG2Q2dpXUxVUbDwo40sqxZtSX6fdUVVxWb2I25qB0deSRdll');
//        $this->gateway->setSecret('EOqYgWNYRjmHw2a0mKBD6XyerOFdg-1gwujR8MdtldBJaDH3uDX4YmOaJarvlaP5fP1tNyu5bpuOJB2x');
        $this->gateway->setTestMode(true); // here 'true' is for sandbox. Pass 'false' when go live
    }

    public function index()
    {
        return view('payment');
    }

    public function checkout($id){
        $title = "Process Payment";
        $user = User::find(Auth::user()->id);

        $getData = Upload::where('user_id','=',auth()->user()->id)->orderBy('created_at', 'desc')->take($id)->get();
        $Audio_ids=array();
        foreach($getData  as $item){
            $Audio_ids[]=$item->id;
        }
        $audioids=(implode(',',$Audio_ids));

        return view('checkout',compact('getData','title','audioids','user'));
    }

    public function checkout_single($id)
    {
        $user = User::find(Auth::user()->id);
        $getData = Upload::where('id', '=', $id)->where('user_id', '=', auth()->user()->id)->orderBy('created_at', 'desc')->get();

        $Audio_ids = array();
        foreach ($getData as $item) {
            $Audio_ids[] = $item->id;
        }

        $audioids = (implode(',', $Audio_ids));


        return view('checkout', compact('getData', 'audioids','user'));

    }


    public function soxProcessFile($fName)
    {
        $dir = "public/upload/";

        $inName = $dir . $fName;

        $coreName = explode('.', $fName);

        $coreName = $coreName[0];


        $outName1 = $dir . $coreName . '.WAV';


        $outName2 = $dir . $coreName . 'B.WAV';


        $outName = $dir . 'new_' . $coreName . ".mp3";
        exec('lame --quiet --decode ' . $inName . ' ' . $outName1 . ' 2>&1;' . 'sox ' . $outName1 . ' -C6 ' . $outName2 . ' --effects-file public/sox/ce.fkt 2>&1;' . 'lame --quiet -V 2 ' . $outName2 . ' ' . $outName);

        return $outName;
    }

    public function store(Request $request){
        $checkout_id = $request->checkout_id;
        $email = $request->input('email');
        $first_name = $request->input('firstName');
        $last_name = $request->input('lastName');
        $number = $request->input('number');
        $arr_expiry = explode("/", $request->input('expiry'));
        $month = "";
        $year = "";
        if(isset($arr_expiry[0])){
            $month = $arr_expiry[0];
        }
        if(isset($arr_expiry[1])){
            $year = $arr_expiry[1];
        }
        $cvv = $request->input('cvc');
        $amt = $request->amount;
        $address = $request->input('streetaddress');
        $country = $request->input('country');
        $city = $request->input('city');
        $state = $request->input('state');
        $zipcode = $request->input('zipcode');
        $total_duration = $request->totalduration;
        $Audio_Ids = $request->fileids;


        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'expiry' => 'required',
            'cvc' => 'required',
            'email' => 'required|max:255',
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'streetaddress'=>'required',
            'city'=>'required',
            'state'=>'required',
            'country'=>'required',
            'zipcode'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'msg' => $validator->errors()->first()], 400);
        }else {
            $formData = array(
                'firstName' => $first_name,
                'lastName' => $last_name,
                'number' => $number,
                'expiryMonth' => trim($month),
                'expiryYear' => trim($year),
                'cvv' => $cvv,
                'billingAddress1' => $address,
                'billingCountry' => $country,
                'billingCity' => $city,
                'billingPostcode' => $zipcode,
                'billingState' => $state,
            );

            try {

                $response = $this->gateway->purchase([
                    'amount' => $amt,
                    'currency' => 'USD',
                    'card' => $formData,
                ])->send();

                // Process response
                if ($response->isSuccessful()) {
                    // Payment was successful
                    $arr_body = $response->getData();
                    $amount = $arr_body['AMT'];
                    $currency = $arr_body['CURRENCYCODE'];
                    $transaction_id = $arr_body['TRANSACTIONID'];


                    $paymentdetails = new Paymentdetail();
                    $paymentdetails->firstname = $first_name;
                    $paymentdetails->lastname = $last_name;
                    $paymentdetails->email = $email;
                    $paymentdetails->currencycode = $currency;
                    $paymentdetails->totalprice = $amount;
                    $paymentdetails->timestamp = $arr_body['TIMESTAMP'];
                    $paymentdetails->transationId = $transaction_id;
                    $paymentdetails->user_id = auth()->user()->id;
                    $paymentdetails->payment_status = $arr_body['ACK'];
                    $paymentdetails->duration = $total_duration;
                    $paymentdetails->address = $address;
                    $paymentdetails->city = $city;
                    $paymentdetails->state = $state;
                    $paymentdetails->country = $country;
                    $paymentdetails->zip_code = $zipcode;
                    $paymentdetails->save();

                    $paymentid = db::table('paymentdetails')->where('id', '=', $paymentdetails->id)->first();
                    $ids_in_array = (explode(",", $Audio_Ids)); //convert into array
                    foreach ($ids_in_array as $item) {
                        $getfilename = DB::table('uploads')
                            ->where('id', $item)
                            ->select('file_name')  //get file name
                            ->first();

                        $totalfilename = $this->soxProcessFile($getfilename->file_name); //call function for file cleaning
                        $filename_new = substr($totalfilename, 14);

                        $uploads = DB::table('uploads')
                            ->where('id', $item)  //update uploads
                            ->update(['paymentdetails_id' => $paymentid->id, 'processed_file' => $filename_new, 'cleaned' => 1]);
                    }

                    return response()->json(["status" => "success", "msg" => "Payment Completed Successfully"], 200);

//                return Redirect::to('/transactions')->with('alert', 'Payment Completed Successfully');

                } else {
                    // Payment failed
//                return redirect()->back()->with('error', $response->getMessage());
                    return response()->json(["status" => "error", "msg" => $response->getMessage()], 400);
                }
            } catch (InvalidCreditCardException $ce) {
                return response()->json(["status" => "error", "msg" => $ce->getMessage()], 400);
            } catch (InvalidRequestException $re) {
                return response()->json(["status" => "error", "msg" => $re->getMessage()], 400);
            } catch (Exce $e) {
                return response()->json(["status" => "error", "msg" => $e->getMessage()], 400);
            }
        }
    }

}
