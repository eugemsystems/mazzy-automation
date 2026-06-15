<?php

return [
    'flatrate' => [
        'code' => 'flatrate',
        'title' => 'Flat Rate',
        'description' => 'Flat Rate Shipping',
        'active' => false,
        'default_rate' => '10',
        'type' => 'per_unit',
        'class' => 'Webkul\Shipping\Carriers\FlatRate',
    ],

    'free' => [
        'code' => 'free',
        'title' => 'Free Shipping',
        'description' => 'Free Shipping',
        'active' => false,
        'default_rate' => '0',
        'class' => 'Webkul\Shipping\Carriers\Free',
    ],

    'province_rate' => [
        'code' => 'province_rate',
        'title' => 'Delivery by Province',
        'description' => 'Shipping rate based on your South African province',
        'active' => true,
        'default_rate' => '0',
        'class' => 'Webkul\Shipping\Carriers\ProvinceRate',
    ],

    'collection_point' => [
        'code' => 'collection_point',
        'title' => 'Collect from our store',
        'description' => 'Collect your order from our store',
        'active' => true,
        'class' => 'Webkul\Shipping\Carriers\CollectionPoint',
    ],
];
