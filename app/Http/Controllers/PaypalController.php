<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;



class PaypalController extends Controller
{

    // protected $client;

    // public function __construct()
    // {
    //     $this->client = new Client([
    //         'base_uri' => 'https://api.paypal.com',
    //         'headers' => [
    //             'Authorization' => 'Bearer ' . $this->getToken(),
    //             'Content-Type' => 'application/json',
    //         ],
    //     ]);
    // }
    public function createView($id)
    {
        $data = DB::table('subscription_type')->where('id', $id)->get()->toArray();
        return view('payments.create', compact('data'));
    }

    public function paymentProcess(Request $request)
    {
        $data = DB::table('subscription_type')->where('plan_id', $request->plan_id)->first();
        DB::table('users')->where('id', Auth::user()->id)->update([
            'plan_id' => $data->plan_id,
            'charges' => $data->charges,
            'no_of_clean_file' => $data->plan_id,
            'plan_name' => $data->name,
            'subscription' => 1,
        ]);
        return redirect()->route('userDashboard')->with('message', 'Congratulations ' . Auth::user()->name . ' on your ' . $data->name . ' subscription');
    }

    public function cancelPlan()
    {
        $data = DB::table('users')->where('id', Auth::user()->id)->update([
            'plan_id' => null,
            'plan_name' => null,
            'charges' => null,
            'no_of_clean_file' => null,
            'subscription' => 0,
        ]);
        if ($data) {
            return redirect()->back();
        } else {
            return redirect()->route('userProfile')->with('message', 'Something went wrong, please try again');
        }
    }

    function generateAccessToken()
    {

        $client = new Client(['base_uri' => 'https://api.sandbox.paypal.com/']);

        try {
            $response = $client->post('/v1/oauth2/token', [
                'auth' => [
                    'AcKJgcQMvUirljnaVpwzQvzQt2D-9iPnOZe89upmpgp9IFQ4yS2sQZp3ZyMf4gBtOxDxOR0xWz4qENsk',
                    'EE87pKYrhOyp6QeA2BtjhdsxIMtrtO-2CR-AsENQOgLv1pLeR3T_5xYaePRmwllUxTjEpeKD4THb_WnC'
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

    // protected function getToken()
    // {
    //     $response = $this->client->post('/v1/oauth2/token', [
    //         'auth' => [
    //             'username' => 'AcKJgcQMvUirljnaVpwzQvzQt2D-9iPnOZe89upmpgp9IFQ4yS2sQZp3ZyMf4gBtOxDxOR0xWz4qENsk',
    //             'password' => 'EE87pKYrhOyp6QeA2BtjhdsxIMtrtO-2CR-AsENQOgLv1pLeR3T_5xYaePRmwllUxTjEpeKD4THb_WnC',
    //         ],
    //         'form_params' => [
    //             'grant_type' => 'client_credentials',
    //         ],
    //     ]);

    //     $data = json_decode($response->getBody(), true);

    //     return $data['access_token'];
    // }

    // public function createProduct()
    // {
    //     $response = Http::withHeaders([
    //         'Content-Type' => 'application/json',
    //         'Authorization' => 'Bearer ' . $this->generateAccessToken(),
    //         'PayPal-Request-Id' => '123123123',
    //     ])->post('https://api-m.sandbox.paypal.com/v1/catalogs/products', [
    //         "name" => "Video Streaming Service",
    //         "description" => "A video streaming service",
    //         "type" => "SERVICE",
    //         "category" => "SOFTWARE",
    //         "image_url" => "https://example.com/streaming.jpg",
    //         "home_url" => "https://example.com/home"
    //     ]);

    //     return $response;
    // }

    public function createPlan()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->generateAccessToken(),
            'Content-Type' => 'application/json',
            'PayPal-Request-Id' => '12121212',
        ])->post('https://api-m.sandbox.paypal.com/v1/billing/plans', [
            "product_id" => "PROD-6YD61333M01533729",
            "name" => "latest Test Plan",
            "description" => "Lastest Basic plan",
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
                            "value" => "10",
                            "currency_code" => "USD"
                        ]
                    ]
                ]
            ],
            "payment_preferences" => [
                "auto_bill_outstanding" => true,
                "setup_fee" => [
                    "value" => "10",
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

    // public function createSubscription(Request $request)
    // {
    //     $response = $this->client->post('/v1/billing/subscriptions', [
    //         'json' => [
    //             'plan_id' => 'P-17S68999S89727417MREAOQI',
    //             'start_time' => date('c'),
    //             'subscriber' => [
    //                 'name' => [
    //                     'given_name' => 'John',
    //                     'surname' => 'Doe',
    //                 ],
    //                 'email_address' => 'john.doe@example.com',
    //             ],
    //         ],
    //     ]);

    //     $data = json_decode($response->getBody(), true);

    //     return response()->json($data);
    // }
}
