<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, SparkPost and others. This file provides a sane default
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'facebook' => [
        'client_id' => '293909921875610',
        'client_secret' => '0ee884d5c4a469d9c649862a5e24b4f1',
        'redirect' => 'https://mypos.devel/login/facebook/callback',
    ],
    'google' => [
        'client_id' => '690013991737-j2sv9anbguibdlgnhacn0u8raihlqbjn.apps.googleusercontent.com',
        'client_secret' => '5LLrmdxs3u4Q_A_paQNtV2pl',
        'redirect' => 'https://mypos.devel/login/google/callback',
    ],
    'linkedin' => [
        'client_id' => '78oubdosrgp7s3',
        'client_secret' => 'sYYmrrDg9V2j60yR',
        'redirect' => 'https://mypos.devel/login/linkedin/callback',
    ],

];
