@php
    $shippingPrice = old('shipping_price') ?? ($product->shipping_price ?? 0);
@endphp

<div class="box-shadow mt-3.5 rounded bg-white p-4 dark:bg-gray-900">
    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
        @lang('admin::app.catalog.products.edit.shipping-price')
    </p>

    <x-admin::form.control-group class="!mb-0">
        <x-admin::form.control-group.label>
            @lang('admin::app.catalog.products.edit.shipping-price')
        </x-admin::form.control-group.label>

        <x-admin::form.control-group.control
            type="text"
            name="shipping_price"
            :value="$shippingPrice"
            :label="trans('admin::app.catalog.products.edit.shipping-price')"
            placeholder="0"
        />

        <p class="mt-1 text-xs text-gray-500">
            @lang('admin::app.catalog.products.edit.shipping-price-info')
        </p>
    </x-admin::form.control-group>
</div>
