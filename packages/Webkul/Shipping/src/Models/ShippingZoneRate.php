<?php

namespace Webkul\Shipping\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\Shipping\Contracts\ShippingZoneRate as ShippingZoneRateContract;

class ShippingZoneRate extends Model implements ShippingZoneRateContract
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
        'min_qty' => 'integer',
        'max_qty' => 'integer',
        'cost' => 'float',
    ];

    /**
     * The zone the rate belongs to.
     */
    public function zone(): BelongsTo
    {
        return $this->belongsTo(ShippingZoneProxy::modelClass(), 'shipping_zone_id');
    }

    /**
     * The shipping class the rate applies to (null = items without a class).
     */
    public function shippingClass(): BelongsTo
    {
        return $this->belongsTo(ShippingClassProxy::modelClass(), 'shipping_class_id');
    }
}
