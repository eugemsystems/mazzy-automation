<?php

namespace Webkul\Shipping\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webkul\Shipping\Contracts\ShippingZone as ShippingZoneContract;

class ShippingZone extends Model implements ShippingZoneContract
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
        'provinces' => 'array',
        'base_cost' => 'float',
        'free_qty' => 'integer',
        'extra_unit_cost' => 'float',
        'is_fallback' => 'boolean',
        'status' => 'boolean',
    ];

    /**
     * Quantity-tier rates that belong to the zone.
     */
    public function rates(): HasMany
    {
        return $this->hasMany(ShippingZoneRateProxy::modelClass());
    }
}
