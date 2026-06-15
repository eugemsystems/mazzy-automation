<?php

use Webkul\Shipping\Models\CollectionPoint;

use function Pest\Laravel\get;
use function Pest\Laravel\postJson;

it('should return the collection points index page', function () {
    $this->loginAsAdmin();

    get(route('admin.settings.collection_points.index'))
        ->assertOk()
        ->assertSeeText(trans('admin::app.settings.collection-points.index.title'));
});

it('should return the collection points create page', function () {
    $this->loginAsAdmin();

    get(route('admin.settings.collection_points.create'))
        ->assertOk()
        ->assertSeeText(trans('admin::app.settings.collection-points.create.add-title'));
});

it('should fail validation when required fields are missing', function () {
    $this->loginAsAdmin();

    postJson(route('admin.settings.collection_points.store'))
        ->assertJsonValidationErrorFor('code')
        ->assertJsonValidationErrorFor('name')
        ->assertJsonValidationErrorFor('country')
        ->assertJsonValidationErrorFor('state')
        ->assertJsonValidationErrorFor('city')
        ->assertJsonValidationErrorFor('street')
        ->assertJsonValidationErrorFor('postcode')
        ->assertJsonValidationErrorFor('handling_fee')
        ->assertUnprocessable();
});

it('should store a new collection point', function () {
    $this->loginAsAdmin();

    postJson(route('admin.settings.collection_points.store'), [
        'code'           => $code = fake()->numerify('cp#######'),
        'name'           => $name = fake()->company(),
        'country'        => 'ZA',
        'state'          => 'GP',
        'city'           => fake()->city(),
        'street'         => fake()->streetName(),
        'postcode'       => fake()->postcode(),
        'contact_number' => '0123456789',
        'handling_fee'   => '45.50',
        'status'         => '1',
    ])
        ->assertRedirect(route('admin.settings.collection_points.index'));

    $this->assertModelWise([
        CollectionPoint::class => [
            [
                'code'         => $code,
                'name'         => $name,
                'state'        => 'GP',
                'handling_fee' => 45.50,
                'status'       => 1,
            ],
        ],
    ]);
});
