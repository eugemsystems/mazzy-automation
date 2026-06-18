<?php

namespace Webkul\Shipping\Repositories;

use Webkul\Core\Eloquent\Repository;

class ShippingZoneRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return 'Webkul\Shipping\Contracts\ShippingZone';
    }

    /**
     * Find the zone that covers the given province (state code), falling back
     * to the zone flagged as the catch-all when no explicit match exists.
     */
    public function findByProvince(?string $state)
    {
        $zones = $this->model->newQuery()->where('status', 1)->get();

        if ($state) {
            $matched = $zones->first(function ($zone) use ($state) {
                return in_array($state, (array) $zone->provinces);
            });

            if ($matched) {
                return $matched;
            }
        }

        return $zones->firstWhere('is_fallback', true);
    }
}
