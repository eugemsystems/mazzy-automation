<?php

namespace Webkul\Shipping\Providers;

use Webkul\Core\Providers\CoreModuleServiceProvider;
use Webkul\Shipping\Models\CollectionPoint;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    /**
     * Models.
     *
     * @var array
     */
    protected $models = [
        CollectionPoint::class,
    ];
}
