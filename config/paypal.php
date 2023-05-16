<?php
/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */

return [
    'mode'    => env('PAYPAL_MODE', 'sandbox'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
    
    'sandbox' => [
        'username'    => env('PAYPAL_SANDBOX_API_USERNAME', ''),
        'password'    => env('PAYPAL_SANDBOX_API_PASSWORD', ''),
        'secret'      => env('PAYPAL_SANDBOX_API_SECRET', ''),
        'certificate' => env('PAYPAL_SANDBOX_API_CERTIFICATE', ''),
        'app_id'      => 'APP-80W284485P519543T',
    ],

    'live' => [
        'client_id'         => env('PAYPAL_LIVE_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_LIVE_CLIENT_SECRET', ''),
        'app_id'            => '',
    ],

    'payment_action' => 'Sale',

    'currency'       => env('PAYPAL_CURRENCY', 'USD'),

    'billing_type'   => 'MerchantInitiatedBilling',

    'notify_url'     => '',

    'locale'         => '',
    'validate_ssl'   => false,
    'client_id' => env('PAYPAL_CLIENT_ID'),
    'secret' => env('PAYPAL_SECRET'),
    'settings' => array(
        'mode' => env('PAYPAL_MODE', 'sandbox'),
        'http.ConnectionTimeOut' => 30,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'DEBUG'
    )
];
