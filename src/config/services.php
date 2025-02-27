<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'client_id' => env('SLACK_CLIENT_ID'),
        'client_secret' => env('SLACK_CLIENT_SECRET'),
        'redirect' => 'https://appsare.com/auth/slack/callback',
    ],
    'pushover' => [
        'api_key' => env('PUSHOVER_API_KEY'),
        'base_redirect_uri' => env('PUSHOVER_BASE_REDIRECT_URI'),
        'base_redirect_success' => env('PUSHOVER_REDIRECT_SUCCESS'),
        'base_redirect_failure' => env('PUSHOVER_REDIRECT_FAILURE'),
    ],

];
