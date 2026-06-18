<?php

namespace Webkul\Shipping\Providers;

use Webkul\Core\Providers\CoreModuleServiceProvider;
use Webkul\Shipping\Models\CollectionPoint;
use Webkul\Shipping\Models\ShippingClass;
use Webkul\Shipping\Models\ShippingZone;
use Webkul\Shipping\Models\ShippingZoneRate;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    /**
     * Models.
     *
     * @var array
     */
    protected $models = [
        CollectionPoint::class,
        ShippingClass::class,
        ShippingZone::class,
        ShippingZoneRate::class,
    ];
}
