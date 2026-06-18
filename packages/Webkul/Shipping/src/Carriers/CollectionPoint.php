<?php

namespace Webkul\Shipping\Carriers;

use Webkul\Checkout\Models\CartShippingRate;
use Webkul\Shipping\Models\CollectionPointProxy;

class CollectionPoint extends AbstractShipping
{
    /**
     * Shipping method carrier code.
     *
     * @var string
     */
    protected $code = 'collection_point';

    /**
     * Offer every active collection point added under Settings → Collection
     * Points as a selectable pickup option at checkout.
     *
     * @return array<CartShippingRate>|false
     */
    public function calculate()
    {
        if (! $this->isAvailable()) {
            return false;
        }

        $collectionPoints = CollectionPointProxy::modelClass()::where('status', 1)
            ->orderBy('name')
            ->get();

        if ($collectionPoints->isEmpty()) {
            return false;
        }

        $rates = [];

        foreach ($collectionPoints as $collectionPoint) {
            $rates[] = $this->getRate($collectionPoint);
        }

        return $rates;
    }

    /**
     * Build a shipping rate for a single collection point.
     */
    public function getRate($collectionPoint): CartShippingRate
    {
        $cartShippingRate = new CartShippingRate;

        $cartShippingRate->carrier = $this->getCode();
        $cartShippingRate->carrier_title = $this->getConfigData('title');
        $cartShippingRate->method = $this->getCode().'_'.$collectionPoint->id;
        $cartShippingRate->method_title = $collectionPoint->name;
        $cartShippingRate->method_description = $this->getAddress($collectionPoint);
        $cartShippingRate->price = core()->convertPrice($collectionPoint->handling_fee);
        $cartShippingRate->base_price = $collectionPoint->handling_fee;

        return $cartShippingRate;
    }

    /**
     * Build a human readable address line for a collection point.
     */
    protected function getAddress($collectionPoint): string
    {
        return collect([
            $collectionPoint->street,
            $collectionPoint->city,
            $collectionPoint->state,
            $collectionPoint->postcode,
        ])->filter()->implode(', ');
    }
}
