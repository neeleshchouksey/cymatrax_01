<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;



class PaypalController extends Controller
{
    public function createView($id)
    {
        $data = DB::table('subscription_type')->where('id', $id)->get()->toArray();
        return view('payments.create', compact('data'));
    }

    function generateAccessToken()
    {
        $client = new Client(['base_uri' => 'https://api.sandbox.paypal.com/']);
        $client_id = env('PAYPAL_CLIENT_ID');
        $secret_id = env('PAYPAL_SECRET');
        try {
            $response = $client->post('/v1/oauth2/token', [
                'auth' => [
                    $client_id,
                    $secret_id
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials'
                ]
            ]);
            $data = json_decode($response->getBody(), true);
            return $data['access_token'];
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $errorMessage = json_decode($response->getBody(), true);
            return $errorMessage['message'];
        }
    }

    public function paymentProcess(Request $request)
    {
        $planId = $request->input('plan_id');
        $client = new Client();

        try {
            $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->generateAccessToken(),
                'PayPal-Request-Id' => '987654',
            ];
            $startTime = date('Y-m-d\TH:i:s\Z', strtotime('+1 day'));
            $payload = [
                'plan_id' => $planId,
                'start_time' => $startTime,
                'quantity' => 1,
                'subscriber' => [
                    'name' => [
                        'given_name' => 'John',
                        'surname' => 'Doe',
                    ],
                    'email_address' => 'john@gmail.com',
                ],
                'application_context' => [
                    'return_url' => route('paymentSuccess'),
                ],
            ];
        
            $response = $client->post('https://api-m.sandbox.paypal.com/v1/billing/subscriptions', [
                'headers' => $headers,
                'json' => $payload,
            ]);
            
            $responseBody = $response->getBody()->getContents();
            $responseData = json_decode($responseBody, true);
            $approvalUrl = $responseData['links'][0]['href'];
            $tabId = uniqid();

            $javascript = <<<EOT
            <script>
                window.location.href = "{$approvalUrl}";
            </script>
            EOT;
            if(session()->has('plan_details')) {
                session()->forget('plan_details');
            }
            $plan_details = ['id' => $planId, 'user_id' => Auth::user()->id];
            $request->session()->put('plan_details', $plan_details);
           return response($javascript)->header('Content-Type', 'text/html');
        
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $errorBody = $response->getBody()->getContents();
            return $errorBody;
        }
    }

    public function paymentSuccess(Request $request)
    {
        if(session()->has('plan_details')) {
            $plan_details = session()->get('plan_details');
            $user_id = $plan_details['user_id'];
            $plan_id = $plan_details['id'];
            $subscription_id = $request->query('subscription_id');
            $plan_data = DB::table('subscription_type')->where('plan_id', $plan_id)->first();
            if($user_id == Auth::user()->id && (!Auth::user()->subscription_id || $subscription_id != Auth::user()->subscription_id)){
                User::where('id', $user_id)->update([
                    'subscription' => 1,
                    'plan_id' => $plan_data->plan_id,
                    'plan_name' => $plan_data->name,
                    'charges' => $plan_data->charges,
                    'no_of_clean_file' => $plan_data->no_of_clean_file,
                    'subscription_id' => $subscription_id
                ]);
                $status = 1;
                $plan_name = $plan_data->name;
            }
        }else {
            $plan_name = '';
            $status = 0;
        }
        return view('payments.success', compact('status', 'plan_name'));
    }

    public function paymentCancel(Request $request)
    {
        // Cancel Plan API
        $client = new Client();
        try {

            $cancelHeaders = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->generateAccessToken(),
            ];

            $cancelPayload = [
                'reason' => 'Cancellation reason',
            ];

            $subscription_id = Auth::user()->subscription_id;

            $cancelUrl = 'https://api-m.sandbox.paypal.com/v1/billing/subscriptions/' . $subscription_id . '/cancel';

            $cancelResponse = $client->post($cancelUrl, [
                'headers' => $cancelHeaders,
                'json' => $cancelPayload,
            ]);

            if (!$cancelResponse) {
                return redirect()->route('userProfile')->with('message', 'Something went wrong, please try again');
            }

            // Process cancellation response if needed
            $update_user = User::where('id', Auth::user()->id)->update([
                'subscription' => 0,
                'plan_id' => null,
                'plan_name' => null,
                'charges' => null,
                'no_of_clean_file' => null,
                'subscription_id' => null
            ]);

            if ($update_user) {
                return redirect()->route('userProfile');
            } else {
                return redirect()->route('userProfile')->with('message', 'Something went wrong, please try again');
            }
        } catch (ClientException $e) {
            // Handle cancellation error
            $cancelResponse = $e->getResponse();
            $statusCode = $cancelResponse->getStatusCode();
            $errorBody = $cancelResponse->getBody()->getContents();

            // Return cancellation error response or handle it appropriately
            return $errorBody;
        }
    }

    public function createPlan()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->generateAccessToken(),
            'Content-Type' => 'application/json',
            'PayPal-Request-Id' => '12121213',
        ])->post('https://api-m.sandbox.paypal.com/v1/billing/plans', [
            "product_id" => "PROD-6YD61333M01533729",
            "name" => "Platinum",
            "description" => "Our platinum plan",
            "billing_cycles" => [
                [
                    "frequency" => [
                        "interval_unit" => "MONTH",
                        "interval_count" => 1
                    ],
                    "tenure_type" => "TRIAL",
                    "sequence" => 1,
                    "total_cycles" => 1
                ],
                [
                    "frequency" => [
                        "interval_unit" => "MONTH",
                        "interval_count" => 1
                    ],
                    "tenure_type" => "REGULAR",
                    "sequence" => 2,
                    "total_cycles" => 12,
                    "pricing_scheme" => [
                        "fixed_price" => [
                            "value" => "45",
                            "currency_code" => "USD"
                        ]
                    ]
                ]
            ],
            "payment_preferences" => [
                "auto_bill_outstanding" => true,
                "setup_fee" => [
                    "value" => "45",
                    "currency_code" => "USD"
                ],
                "setup_fee_failure_action" => "CONTINUE",
                "payment_failure_threshold" => 3
            ],
            "taxes" => [
                "percentage" => "10",
                "inclusive" => false
            ]
        ]);

        return $response;
    }

    public function test()
    {
        return view('payments.test');
    }
}
