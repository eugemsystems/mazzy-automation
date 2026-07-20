<?php

return [
    'address' => env('COMPANY_ADDRESS', '2 Sandown Valley Cres, Sandown, Johannesburg, 2031'),

    'phone' => [
        'mobile' => env('COMPANY_PHONE_MOBILE', '+27787972186'),
        'telephone' => env('COMPANY_PHONE_TELEPHONE', '0107463674'),
    ],

    'email' => env('COMPANY_EMAIL', 'info@mazzyautomations.co.za'),

    'hours' => [
        'weekdays' => env('COMPANY_HOURS_WEEKDAYS', '8 am–4 pm'),
        'saturday' => env('COMPANY_HOURS_SATURDAY', 'Closed'),
        'sunday' => env('COMPANY_HOURS_SUNDAY', 'Closed'),
    ],
];
