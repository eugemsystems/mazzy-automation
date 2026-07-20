<?php

use Webkul\Netcash\Payment\Netcash;

return [
    'netcash' => [
        'class' => Netcash::class,
        'code' => 'netcash',
        'title' => 'Netcash',
        'description' => 'Pay securely via Netcash Pay Now',
        'active' => true,
        'service_key' => 'SERVICE_KEY',
        'sort' => 8,
    ],
];
