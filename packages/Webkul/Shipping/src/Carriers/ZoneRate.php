<?php

namespace Webkul\Shipping\Carriers;

use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Models\CartShippingRate;
use Webkul\Shipping\Repositories\ShippingZoneRepository;

class ZoneRate extends AbstractShipping
{
    /**
     * Shipping method carrier code.
     *
     * @var string
     */
    protected $code = 'zone_rate';

    /**
     * Shipping method code.
     *
     * @var string
     */
    protected $method = 'zone_rate_zone_rate';

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
     * Calculate the quantity-based shipping rate for the customer's zone.
     *
     * @return CartShippingRate|false
     */
    public function calculate()
    {
        if (! $this->isAvailable()) {
            return false;
        }

        $cart = Cart::getCart();

        if (! $cart) {
            return false;
        }

        $state = $cart->shipping_address?->state;

        $zone = app(ShippingZoneRepository::class)->findByProvince($state);

        if (! $zone) {
            return false;
        }

        $breakdown = $this->computeShipping($cart, $zone);

        $cartShippingRate = new CartShippingRate;

        $cartShippingRate->carrier = $this->getCode();
        $cartShippingRate->carrier_title = $this->getConfigData('title');
        $cartShippingRate->method = $this->getMethod();
        $cartShippingRate->method_title = $this->getConfigData('title');
        $cartShippingRate->method_description = $this->getMethodDescription($state, $breakdown);
        $cartShippingRate->price = core()->convertPrice($breakdown['total']);
        $cartShippingRate->base_price = $breakdown['total'];

        return $cartShippingRate;
    }

    /**
     * Compute the shipping cost for the cart within the resolved zone.
     *
     * Each stockable item is charged its product's base shipping price. When
     * the item quantity exceeds the zone's included quantity, every extra unit
     * adds the zone's per-unit cost. The optional zone base cost is added once.
     *
     * Example: product price R10, zone includes 5 units at R2 per extra unit,
     * quantity 10 → 10 + (10 - 5) * 2 = R20.
     */
    public function getCost($cart, $zone): float
    {
        return $this->computeShipping($cart, $zone)['total'];
    }

    /**
     * Break the shipping cost down into its components so the customer can see
     * how the total was reached.
     *
     * @return array{base: float, extra_units: int, extra_cost: float, zone_fee: float, total: float}
     */
    public function computeShipping($cart, $zone): array
    {
        $freeQty = (int) $zone->free_qty;

        $extraUnitCost = (float) $zone->extra_unit_cost;

        $base = 0.0;

        $extraUnits = 0;

        foreach ($cart->items as $item) {
            if (! $item->getTypeInstance()->isStockable()) {
                continue;
            }

            $base += (float) $this->getProductShippingPrice($item);

            $extraUnits += max(0, $item->quantity - $freeQty);
        }

        $zoneFee = (float) $zone->base_cost;

        $extraCost = $extraUnits * $extraUnitCost;

        return [
            'base' => $base,
            'extra_units' => $extraUnits,
            'extra_cost' => $extraCost,
            'zone_fee' => $zoneFee,
            'total' => $base + $extraCost + $zoneFee,
        ];
    }

    /**
     * Resolve a cart item's base shipping price, falling back to its parent
     * product (for configurable variants) when the variant has none.
     */
    protected function getProductShippingPrice($item): float
    {
        $price = $item->product->shipping_price ?? null;

        if (! $price && $item->product->parent_id) {
            $price = $item->product->parent?->shipping_price;
        }

        return (float) $price;
    }

    /**
     * Build a clear, customer facing description with a cost breakdown, e.g.
     * "Shipping to Gauteng: R10.00 base + R10.00 for 5 extra units".
     */
    protected function getMethodDescription(?string $state, ?array $breakdown = null): string
    {
        $province = $this->provinces[strtoupper((string) $state)] ?? null;

        $label = $province
            ? trans('shop::app.checkout.onepage.shipping.province-shipping-to', ['province' => $province])
            : ($this->getConfigData('description') ?: '');

        if (! $breakdown) {
            return $label;
        }

        $parts = [
            trans('shop::app.checkout.onepage.shipping.breakdown-base', [
                'amount' => core()->formatBasePrice($breakdown['base']),
            ]),
        ];

        if ($breakdown['extra_units'] > 0) {
            $parts[] = trans('shop::app.checkout.onepage.shipping.breakdown-extra', [
                'amount' => core()->formatBasePrice($breakdown['extra_cost']),
                'count' => $breakdown['extra_units'],
            ]);
        }

        if ($breakdown['zone_fee'] > 0) {
            $parts[] = trans('shop::app.checkout.onepage.shipping.breakdown-zone-fee', [
                'amount' => core()->formatBasePrice($breakdown['zone_fee']),
            ]);
        }

        $breakdownText = implode(' + ', $parts);

        return $label ? $label.': '.$breakdownText : $breakdownText;
    }
}
