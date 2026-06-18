<?php

use Webkul\Shipping\Carriers\ZoneRate;
use Webkul\Shipping\Models\ShippingZone;

use function Pest\Laravel\get;
use function Pest\Laravel\postJson;

/**
 * Build a lightweight cart item double exposing only what the carrier reads.
 */
function zoneCartItem(int $quantity, float $shippingPrice)
{
    return new class($quantity, $shippingPrice)
    {
        public $quantity;

        public $product;

        public function __construct($quantity, $shippingPrice)
        {
            $this->quantity = $quantity;
            $this->product = (object) ['shipping_price' => $shippingPrice, 'parent_id' => null];
        }

        public function getTypeInstance()
        {
            return new class
            {
                public function isStockable()
                {
                    return true;
                }
            };
        }
    };
}

it('should return the shipping zones index page', function () {
    $this->loginAsAdmin();

    get(route('admin.settings.shipping_zones.index'))
        ->assertOk()
        ->assertSeeText(trans('admin::app.settings.shipping-zones.index.title'));
});

it('stores a shipping zone with provinces and quantity pricing', function () {
    $this->loginAsAdmin();

    postJson(route('admin.settings.shipping_zones.store'), [
        'name'            => 'Gauteng',
        'base_cost'       => '0',
        'free_qty'        => '5',
        'extra_unit_cost' => '2',
        'status'          => '1',
        'provinces'       => ['GP'],
    ])->assertRedirect(route('admin.settings.shipping_zones.index'));

    $zone = ShippingZone::where('name', 'Gauteng')->first();

    expect($zone)->not->toBeNull();
    expect($zone->code)->toBe('gauteng');
    expect($zone->provinces)->toBe(['GP']);
    expect($zone->free_qty)->toBe(5);
    expect($zone->extra_unit_cost)->toBe(2.0);
});

it('charges the product price plus per-unit cost for quantities above the included amount', function () {
    $zone = ShippingZone::create([
        'code'            => 'gauteng',
        'name'            => 'Gauteng',
        'base_cost'       => 0,
        'free_qty'        => 5,
        'extra_unit_cost' => 2,
        'provinces'       => ['GP'],
        'status'          => 1,
    ]);

    $carrier = new ZoneRate;

    // Product R10, qty 10: 10 + (10 - 5) * 2 = 20  (the user's example)
    $cart = (object) ['items' => collect([zoneCartItem(10, 10)])];
    expect($carrier->getCost($cart, $zone))->toBe(20.0);

    // Within the included quantity (qty 3): just the product price, no extra
    $cart2 = (object) ['items' => collect([zoneCartItem(3, 10)])];
    expect($carrier->getCost($cart2, $zone))->toBe(10.0);

    // Two products combined: (10 + 5*2) + (10 + 0) = 30
    $cart3 = (object) ['items' => collect([zoneCartItem(10, 10), zoneCartItem(3, 10)])];
    expect($carrier->getCost($cart3, $zone))->toBe(30.0);
});

it('exposes a cost breakdown for the customer', function () {
    $zone = ShippingZone::create([
        'code'            => 'gauteng',
        'name'            => 'Gauteng',
        'base_cost'       => 0,
        'free_qty'        => 5,
        'extra_unit_cost' => 2,
        'provinces'       => ['GP'],
        'status'          => 1,
    ]);

    $cart = (object) ['items' => collect([zoneCartItem(10, 10)])];

    $breakdown = (new ZoneRate)->computeShipping($cart, $zone);

    expect($breakdown['base'])->toBe(10.0);
    expect($breakdown['extra_units'])->toBe(5);
    expect($breakdown['extra_cost'])->toBe(10.0);
    expect($breakdown['total'])->toBe(20.0);
});

it('adds the optional zone fee once', function () {
    $zone = ShippingZone::create([
        'code'            => 'coastal',
        'name'            => 'Coastal',
        'base_cost'       => 15,
        'free_qty'        => 5,
        'extra_unit_cost' => 2,
        'provinces'       => ['WC'],
        'status'          => 1,
    ]);

    // zone fee 15 + product 10 (qty 2, within included) = 25
    $cart = (object) ['items' => collect([zoneCartItem(2, 10)])];

    expect((new ZoneRate)->getCost($cart, $zone))->toBe(25.0);
});

it('resolves a zone by province and falls back to the catch-all zone', function () {
    ShippingZone::query()->delete();

    $inland = ShippingZone::create(['code' => 'inland', 'name' => 'Inland', 'base_cost' => 0, 'provinces' => ['GP'], 'status' => 1]);
    $rest = ShippingZone::create(['code' => 'rest', 'name' => 'Rest of SA', 'base_cost' => 0, 'provinces' => [], 'is_fallback' => 1, 'status' => 1]);

    $repo = app(\Webkul\Shipping\Repositories\ShippingZoneRepository::class);

    expect($repo->findByProvince('GP')->id)->toBe($inland->id);
    expect($repo->findByProvince('WC')->id)->toBe($rest->id);
});
