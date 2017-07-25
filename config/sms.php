<?php

/*
 * https://simplesoftware.io/docs/simple-sms#docs-configuration for more information.
 */
return [
    'driver' => env('SMS_DRIVER', 'nexmo'),

    'from' => env('SMS_FROM', 'HMS'),

    'callfire' => [
        'app_login' => env('CALLFIRE_LOGIN', 'Your CallFire API Login'),
        'app_password' => env('CALLFIRE_PASSWORD', 'Your CallFire API Password')
    ],

    'eztexting' => [
        'username' => env('EZTEXTING_USERNAME', 'Your EZTexting Username'),
        'password' => env('EZTEXTING_PASSWORD', 'Your EZTexting Password')
    ],

    'flowroute' => [
        'access_key' => env('FLOWROUTE_ACCESS_KEY', 'Your Flowroute Access Key'),
        'secret_key' => env('FLOWROUTE_SECRET_KEY', 'Your Flowroute Secret Key')
    ],

    'infobip'=> [
         'username' => env('INFOBIP_USERNAME', 'Your Infobip Username'),
         'password' => env('INFOBIP_PASSWORD', 'Your Infobip Password')
    ],

    'labsmobile' => [
        'client_id' => env('LABSMOBILE_CLIENT_ID', 'Your Labsmobile Client ID'),
        'username' => env('LABSMOBILE_USERNAME', 'Your Labsmobile Username'),
        'password' => env('LABSMOBILE_PASSWORD', 'Your Labsmobile Password'),
        'test' => env('LABSMOBILE_TEST', false)
    ],

    'mozeo' => [
        'company_key' => env('MOZEO_COMPANY_KEY', 'Your Mozeo Company Key'),
        'username' => env('MOZEO_USERNAME', 'Your Mozeo Username'),
        'password' => env('MOZEO_PASSWORD', 'Your Mozeo Password')
    ],

    'nexmo' => [
        'api_key' => env('NEXMO_KEY', '0187a24d'),
        'api_secret' => env('NEXMO_SECRET', '6c530cd4e54aa68f')
    ],

    'plivo' => [
        'auth_id' => env('PLIVO_AUTH_ID', 'Your Plivo Auth ID'),
        'auth_token' => env('PLIVO_AUTH_TOKEN', 'Your Plivo Auth Token')
    ],

    'twilio' => [
        'account_sid' => env('TWILIO_SID', 'Your Twilio SID'),
        'auth_token' => env('TWILIO_TOKEN', 'Your Twilio Token'),
        'verify' => env('TWILIO_VERIFY', true)
    ],

    'zenvia' => [
        'account_key' => env('ZENVIA_KEY','Your Zenvia account key'),
        'passcode' => env('ZENVIA_PASSCODE','Your Zenvia Passcode'),
        'call_back_option' => env('ZENVIA_CALLBACK_OPTION', 'NONE')
    ],
];
