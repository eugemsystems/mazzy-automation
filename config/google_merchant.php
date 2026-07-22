<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Google Merchant Center feed token
    |--------------------------------------------------------------------------
    |
    | A secret token that protects the public Google Shopping product feed
    | URL. Generate a long random value and set it here — Merchant Center
    | polls the feed URL directly, on its own schedule, with no login and
    | no credentials of any kind.
    |
    */

    'feed_token' => env('GOOGLE_MERCHANT_FEED_TOKEN'),

];
