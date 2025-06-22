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
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'zapi' => [
        'url' => env('INSTANCIA_API_ZAPI'),
        'token' => env('ZAPI_CLIENT_TOKEN'),
        'phone1' => env('WHATSAPP_PHONE1'),
        'phone2' => env('WHATSAPP_PHONE2'),
        'phone3' => env('WHATSAPP_PHONE3'),
        'phone4' => env('WHATSAPP_PHONE4'),
        'phone5' => env('WHATSAPP_PHONE5'),
        ],

];
