<?php

namespace Webkul\Shipping\Carriers;

use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Models\CartShippingRate;

class ProvinceRate extends AbstractShipping
{
    /**
     * Shipping method carrier code.
     *
     * @var string
     */
    protected $code = 'province_rate';

    /**
     * Shipping method code.
     *
     * @var string
     */
    protected $method = 'province_rate_province_rate';

    /**
     * South African provinces keyed by their ISO 3166-2:ZA code.
     *
     * @var array<string, string>
     */
    protected $provinces = [
        'EC' => 'Eastern Cape',
        'FS' => 'Free State',
        'GP' => 'Gauteng',
        'KN' => 'KwaZulu-Natal',
        'LP' => 'Limpopo',
        'MP' => 'Mpumalanga',
        'NC' => 'Northern Cape',
        'NW' => 'North West',
        'WC' => 'Western Cape',
    ];

    /**
     * Calculate rate for the customer's province.
     *
     * @return CartShippingRate|false
     */
    public function calculate()
    {
        if (! $this->isAvailable()) {
            return false;
        }

        return $this->getRate();
    }

    /**
     * Get rate based on the shipping address province (state).
     */
    public function getRate(): CartShippingRate
    {
        $cart = Cart::getCart();

        $state = $cart?->shipping_address?->state;

        $rate = $this->getProvinceRate($state);

        $cartShippingRate = new CartShippingRate;

        $cartShippingRate->carrier = $this->getCode();
        $cartShippingRate->carrier_title = $this->getConfigData('title');
        $cartShippingRate->method = $this->getMethod();
        $cartShippingRate->method_title = $this->getConfigData('title');
        $cartShippingRate->method_description = $this->getMethodDescription($state);
        $cartShippingRate->price = core()->convertPrice($rate);
        $cartShippingRate->base_price = $rate;

        return $cartShippingRate;
    }

    /**
     * Resolve the shipping rate for the given province, falling back to the
     * configured default rate when no province-specific rate has been set.
     */
    protected function getProvinceRate(?string $state): float
    {
        $defaultRate = (float) $this->getConfigData('default_rate');

        if (empty($state)) {
            return $defaultRate;
        }

        $provinceRate = $this->getConfigData('rate_'.strtolower($state));

        if ($provinceRate === null || $provinceRate === '') {
            return $defaultRate;
        }

        return (float) $provinceRate;
    }

    /**
     * Build a clear, customer facing description for the applied rate, e.g.
     * "Shipping to Gauteng".
     */
    protected function getMethodDescription(?string $state): string
    {
        $province = $this->provinces[strtoupper((string) $state)] ?? null;

        if ($province) {
            return trans('shop::app.checkout.onepage.shipping.province-shipping-to', ['province' => $province]);
        }

        return $this->getConfigData('description') ?: '';
    }
}
