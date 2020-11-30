<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use Illuminate\Support\Facades\Redirect;
use  App\Paymentdetail;

class PayPalController extends Controller
{
    public function payment(Request $request)
    {

        $totalcost = $request->totalcost;
        $totalduration = $request->totalduration;
        $data = [];
        $data['items'] = [
            [
                'name' => 'ItSolutionStuff.com',
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
        //dd($data);


        // $totalcost = $request->totalcost;
        // $totalduration = $request->totalduration;
//dd($totalcost,$totalduration);
      
        //  $data = [];
        // $data['items'] = [
        //     [

        //         'name' => 'null',
        //         'price' => $totalcost,
        //         'desc'  => 'description',
        //         'qty' => 1


        //     ]
        // ];
       
        // $data['invoice_id'] = 1;
        // $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        // $data['return_url'] = route('payment.success');
        // $data['cancel_url'] = route('payment.cancel');
        // $data['total'] = $totalduration;
       
    
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
        dd('Your payment is canceled. You can create cancel page here.');
    }
  
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {
       
        $provider = new ExpressCheckout; 
        $response = $provider->getExpressCheckoutDetails($request->token);
       
         if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
             //dd($response);
        


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


           


        //     dd('Your payment was successfully');
             return Redirect::to('/home')->with(['message' => 'Your payment done was successfully']);
        }
  
        // dd('Something is wrong.');
    }
}
