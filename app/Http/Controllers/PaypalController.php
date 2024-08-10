<?php
namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class PaypalController extends Controller
{
    private $PAYPAL_URL_SANDBOX = "https://api.sandbox.paypal.com"; // Test (Sandbox) API url

    private $PAYPAL_URL_LIVE = "https://api-m.paypal.com"; // Live (production) API url

    private $PAYPAL_URL = "";

    private $API_VERSION = 'v1';

    public function __construct()
    {
        if (env('PAYPAL_MODE') == "live")
        {
            $this->PAYPAL_URL = $this->PAYPAL_URL_LIVE . '/' . $this->API_VERSION;
        }
        else
        {
            $this->PAYPAL_URL = $this->PAYPAL_URL_SANDBOX . "/" . $this->API_VERSION;
        }

    }

    public function createView($id)
    {

        $plan_start_date = Carbon::now()->format('Y-m-d');

        $data = DB::table('subscription_type')->where('id', $id)->first();

        //   dd($data);

        if (Auth::user()->plan_id != '0' &&   \Auth::user()->plan_id != null)
        {
            \Session::flash('error', "You must cancel subscription to downgrade, go to edit profile");
            return back();
        }
        else if ($data->plan_id == 0 && $data->id == 1 && \Auth::user()->plan_id == null)
        {
            User::where('id', Auth::id())->update([
                'subscription' => 1,
                'plan_id' => $data->plan_id,
                'plan_name' => $data->name,
                'charges' => $data->charges,
                'no_of_clean_file' => $data->no_of_clean_file,
                'price_per_minute' => $data->price_per_minute,
                'subscription_id' => '',//$subscription_id,
                'plan_start_date' => $plan_start_date,
                'is_cancelled' => 0
            ]);
            $status = "free";
            $plan_name = $data->name;
            return view('payments.success', compact('status', 'plan_name'));

        }
        else if ($data->plan_id == 0 && $data->id == 1 && \Auth::user()->plan_id != null)
        {
            // \Session::flash('error', " You have already availed the " . $data->name . ' package.');
            return back();
        }
        $data = DB::table('subscription_type')->where('id', $id)->get()->toArray();
        return view('payments.create', compact('data'));
    }
    function generateAccessToken(): string
    {
        // Use Laravel's config helper for environment variables
        $client_id = env('PAYPAL_CLIENT_ID');
        $secret_id = env('PAYPAL_SECRET');
        // Combine and base64 encode credentials in one step
        $authString = base64_encode($client_id . ':' . $secret_id);
        try
        {
            // Use Guzzle for HTTP requests (more recommended than cURL)
            $client = new Client();
            $response = $client->post($this->PAYPAL_URL . '/oauth2/token', [
                'form_params' => ['grant_type' => 'client_credentials'],
                'headers' => [
                    'Authorization' => "Basic $authString",
                ],

            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['access_token']))
            {
                return $data['access_token'];
            }

            throw new \Exception('Failed to retrieve access token: ' . $data['error_description'] ?? 'Unknown error');

            // dd($data);

        } catch (\Exception $e)
        {
            // Log the error (e.g., using Laravel's Log facade)
            \Log::info("Error generating access token: " . $e->getMessage());
            return ''; // Indicate failure
        }

    }



    public function paymentProcess(Request $request)
    {
        $planId = $request->input('plan_id');
        $client = new Client();

        try
        {
            $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->generateAccessToken(),
                'PayPal-Request-Id' => '987654',
            ];
            // $startTime = date('Y-m-d\TH:i:s\Z', strtotime('+1 day'));
            // $startTime = date('Y-m-d\TH:i:s\Z', strtotime('+1 day'));

            $payload = [
                'plan_id' => $planId,
                // 'start_time' => $startTime,
                'quantity' => 1,
                'subscriber' => [
                    'name' => [
                        'given_name' => \Auth::user()->name,
                        'surname' => 'Doe',
                    ],
                    'email_address' => \Auth::user()->email,
                ],
                'application_context' => [
                    'return_url' => route('paymentSuccess'),
                ],

            ];

            $response = $client->post($this->PAYPAL_URL . '/billing/subscriptions', [
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

            if (session()->has('plan_details'))
            {
                session()->forget('plan_details');
            }

            $plan_details = ['id' => $planId, 'user_id' => Auth::user()->id];
            $request->session()->put('plan_details', $plan_details);
            return response($javascript)->header('Content-Type', 'text/html');

        } catch (ClientException $e)
        {

            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $errorBody = $response->getBody()->getContents();
            return $errorBody;

        }

    }



    public function paymentSuccess(Request $request)
    {
	\Log::info($request->all());

        if (session()->has('plan_details'))
        {

            $plan_details = session()->get('plan_details');

            $user_id = $plan_details['user_id'];

            $plan_id = $plan_details['id'];

            $subscription_id = $request->query('subscription_id');
            // $req = $request->get();

            $next_billing_time = isset($request->billing_info->next_billing_time) ? $request->billing_info->next_billing_time : \Carbon\Carbon::now();;

            $plan_data = DB::table('subscription_type')->where('plan_id', $plan_id)->first();

            $plan_start_date = Carbon::now()->format('Y-m-d');

            if ($user_id == Auth::user()->id && (!Auth::user()->subscription_id || $subscription_id != Auth::user()->subscription_id))
            {

                User::where('id', $user_id)->update([
                    'subscription' => 1,
                    'plan_id' => $plan_data->plan_id,
                    'plan_name' => $plan_data->name,
                    'charges' => $plan_data->charges,
                    'no_of_clean_file' => $plan_data->no_of_clean_file,
                    'price_per_minute' => $plan_data->price_per_minute,
                    'subscription_id' => $subscription_id,
                    'plan_start_date' => $plan_start_date,
                    'plan_end_date' => $next_billing_time ?? '',
                    'is_cancelled' => 0
                ]);

                $update_user = \DB::table('user_subscription')->insert([
                    'subscription' => 1,
                    'user_id' => Auth::user()->id,
                    'plan_id' => $plan_data->plan_id ?? '',
                    'plan_name' => $plan_data->name ?? '',
                    'charges' => $plan_data->charges ?? '',
                    'no_of_clean_file' => $plan_data->no_of_clean_file ?? '',
                    'price_per_minute' => $plan_data->price_per_minute ?? '',
                    'subscription_id' => $subscription_id,
                    'plan_start_date' => $plan_start_date,
                    'plan_end_date' => $next_billing_time ?? '',
                ]);

                $status = 1;

                $plan_name = $plan_data->name;
                $to = Auth::user()->email;
                $subject = 'Your plan has been upgraded';

                $from = env("MAIL_FROM_ADDRESS");

                if (!empty($to))
                {
                    $mail = Mail::send('emails.upgradePlan', [
                        "plan_name" => $plan_name
                    ], function ($message) use ($to, $from, $subject) {
                        $message->to($to);
                        //  $message->cc($cc);
                        $message->from($from);
                        $message->subject($subject);
                    });

                }

            }
             $status = 1;;
  $plan_name = $plan_data->name ?? '';
        } else
        {

            $plan_name = '';

            $status = 0;

        }

        return view('payments.success', compact('status', 'plan_name'));

    }



    public function paymentCancel(Request $request)
    {

        // Cancel Plan API

//        $client = new Client();

        try
        {

  /*          $cancelHeaders = [

                'Content-Type' => 'application/json',

                'Authorization' => 'Bearer ' . $this->generateAccessToken(),

            ];

            $cancelPayload = [

                'reason' => 'Cancellation reason',

            ];

            $subscription_id = Auth::user()->subscription_id;

            $cancelUrl = $this->PAYPAL_URL . '/billing/subscriptions/' . $subscription_id . '/cancel';

          \Log::info(['url'=>$cancelUrl,"cancelHeaders"=>$cancelHeaders,'cancelPayload'=>$cancelPayload]);
            $cancelResponse = $client->post($cancelUrl, [

                'headers' => $cancelHeaders,

                'json' => $cancelPayload,

            ]);

            if (!$cancelResponse)
            {

                return redirect()->route('userProfile')->with('message', 'Something went wrong, please try again');

            }
*/

              $subscription_id = Auth::user()->subscription_id;
            $cancelUrl = $this->PAYPAL_URL . '/billing/subscriptions/' . $subscription_id . '/cancel';
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $cancelUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                    "reason": "Item out of stock"
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '. $this->generateAccessToken(),
                    'Cookie: l7_az=ccg13.slc'
                ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);

                \Log::info($response);
            // Process cancellation response if needed

            $now = Carbon::now();

            $futureDate = $now->addMonth();

            $month = $futureDate->format('m');

            $current_date = $now->format('d');

            $current_month = $now->format('m');

            $current_year = $now->format('Y');

            $date = Carbon::createFromFormat('Y-m-d', Auth::user()->plan_start_date)->format('d');

            if ($current_date > $date)
            {

                $expiry_date = $current_year . '-' . $month . '-' . $date;

            } else
            {

                $expiry_date = $current_year . '-' . $current_month . '-' . $date;

            }



            $subscription_type = DB::table("subscription_type")->where("plan_id", 0)->first();




            // chnage a old subscription status
            $old_subscription = \DB::table('user_subscription')
                ->where("plan_id", \Auth::user()->plan_id)
                ->where("user_id", \Auth::user()->id)
                ->orderBy("created_at", "DESC")
                ->first();

            if (!empty($old_subscription))
            {
                \DB::table('user_subscription')->where("id", $old_subscription->id)->update(
                    array(
                        'status' => '0',
                    )
                );
            }

            $update_user = User::where('id', Auth::user()->id)->update([
                // 'is_cancelled' => 1,
                // 'plan_end_date' => $expiry_date,
                'subscription' => 1,
                'plan_id' => $subscription_type->plan_id ?? '',
                'plan_name' => $subscription_type->name ?? '',
                'charges' => $subscription_type->charges ?? '',
                'no_of_clean_file' => $subscription_type->no_of_clean_file ?? '',
                'price_per_minute' => $subscription_type->price_per_minute ?? '',
                'subscription_id' => $subscription_type->id,
                'plan_start_date' => Carbon::now(),
                'is_cancelled' => 0
            ]);


            $update_user = \DB::table('user_subscription')->insert([
                'subscription' => 1,
                'user_id' => Auth::user()->id,
                'plan_id' => $subscription_type->plan_id ?? '',
                'plan_name' => $subscription_type->name ?? '',
                'charges' => $subscription_type->charges ?? '',
                'no_of_clean_file' => $subscription_type->no_of_clean_file ?? '',
                'price_per_minute' => $subscription_type->price_per_minute ?? '',
                'plan_start_date' => Carbon::now()
            ]);





            if ($request->ajax())
            {

                return ["status" => "success", "message" => "Unsubscribe successfully"];

            }



            if ($update_user)
            {

                return redirect()->route('userProfile');

            } else
            {

                return redirect()->route('userProfile')->with('message', 'Something went wrong, please try again');

            }

        } catch (ClientException $e)
        {
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

        ])->post($this->PAYPAL_URL . '/v1/billing/plans', [

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



    public function onetimePaymentProcess(Request $request)
    {

        try
        {

            $client = new Client();

            // $sandboxBaseUrl = 'https://api.sandbox.paypal.com';



            $response = $client->post($this->PAYPAL_URL . '/payments/payment', [

                'headers' => [

                    'Authorization' => 'Bearer ' . $this->generateAccessToken(),

                    'Content-Type' => 'application/json',

                ],

                'json' => [

                    'intent' => 'sale',

                    'payer' => [

                        'payment_method' => 'paypal',

                    ],

                    'transactions' => [

                        [

                            'amount' => [

                                'total' => $request->value,

                                'currency' => 'USD',

                            ],

                        ],

                    ],

                    'redirect_urls' => [

                        'return_url' => url('/dashboard'),

                        'cancel_url' => url('/dashboard'),

                    ],

                ],

            ]);



            $data = json_decode($response->getBody(), true);



            return redirect($data['links'][1]['href']);

        } catch (RequestException $e)
        {
            dd($e);
            if ($e->getResponse())
            {

                $statusCode = $e->getResponse()->getStatusCode();

                $responseBody = json_decode($e->getResponse()->getBody(), true);

            } else
            {

                echo 'Something went wrong';
                exit;

            }

        }

    }



    public function test()
    {

        return view('payments.test');

    }

}

