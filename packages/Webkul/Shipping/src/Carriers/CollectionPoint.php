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
     * Build the available collection (pickup) options.
     *
     * The store's shipping origin address (configured under Configure → Sales
     * → Shipping) is always offered as a pickup point, free of charge. Any
     * active records added under Settings → Collection Points are offered too.
     *
     * @return array<CartShippingRate>|false
     */
    public function calculate()
    {
        if (! $this->isAvailable()) {
            return false;
        }

        $rates = [];

        if ($storeRate = $this->getStoreOriginRate()) {
            $rates[] = $storeRate;
        }

        foreach ($this->getCollectionPoints() as $collectionPoint) {
            $rates[] = $this->getRate(
                'collection_point_'.$collectionPoint->id,
                $collectionPoint->name,
                $this->formatAddress([
                    $collectionPoint->street,
                    $collectionPoint->city,
                    $collectionPoint->state,
                    $collectionPoint->postcode,
                ]),
                (float) $collectionPoint->handling_fee
            );
        }

        if (empty($rates)) {
            return false;
        }

        return $rates;
    }

    /**
     * Build the pickup option for the store's shipping origin address.
     */
    protected function getStoreOriginRate(): ?CartShippingRate
    {
        $address = $this->formatAddress([
            core()->getConfigData('sales.shipping.origin.address'),
            core()->getConfigData('sales.shipping.origin.city'),
            core()->getConfigData('sales.shipping.origin.state'),
            core()->getConfigData('sales.shipping.origin.zipcode'),
        ]);

        if (empty($address)) {
            return null;
        }

        return $this->getRate(
            'collection_point_store',
            $this->getConfigData('title'),
            $address,
            0
        );
    }

    /**
     * Get the active collection points configured under Settings.
     */
    protected function getCollectionPoints()
    {
        return CollectionPointProxy::modelClass()::where('status', 1)
            ->orderBy('name')
            ->get();
    }

    /**
     * Build a shipping rate for a pickup option.
     */
    public function getRate(string $method, ?string $title, string $description, float $fee): CartShippingRate
    {
        $cartShippingRate = new CartShippingRate;

        $cartShippingRate->carrier = $this->getCode();
        $cartShippingRate->carrier_title = $this->getConfigData('title');
        $cartShippingRate->method = $method;
        $cartShippingRate->method_title = $title ?: $this->getConfigData('title');
        $cartShippingRate->method_description = $description;
        $cartShippingRate->price = core()->convertPrice($fee);
        $cartShippingRate->base_price = $fee;

        return $cartShippingRate;
    }

    /**
     * Build a human readable, comma separated address line.
     *
     * @param  array<?string>  $parts
     */
    protected function formatAddress(array $parts): string
    {
        return collect($parts)->filter()->implode(', ');
    }
}
