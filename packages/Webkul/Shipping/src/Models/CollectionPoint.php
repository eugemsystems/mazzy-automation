<?php

namespace Webkul\Shipping\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Shipping\Contracts\CollectionPoint as CollectionPointContract;

class CollectionPoint extends Model implements CollectionPointContract
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'handling_fee' => 'float',
        'status' => 'boolean',
    ];
}
