<?php

namespace Webkul\Shipping\Repositories;

use Webkul\Core\Eloquent\Repository;

class ShippingClassRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return 'Webkul\Shipping\Contracts\ShippingClass';
    }
}
