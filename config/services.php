<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => 'AKIAJDJ2OUUKUEU4VH6A',
        'secret' => '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',
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\StripeUser::class,
        'key' => env('STRIPE_KEY'),
        'secret' =>env('STRIPE_SECRET'),
    ],

];
