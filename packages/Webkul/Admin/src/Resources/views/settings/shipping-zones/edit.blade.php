<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.settings.shipping-zones.edit.title')
    </x-slot>

    @php
        $selectedProvinces = old('provinces', $shippingZone->provinces ?? []);
    @endphp

    <x-admin::form
        :action="route('admin.settings.shipping_zones.update', $shippingZone->id)"
        method="PUT"
    >
        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                @lang('admin::app.settings.shipping-zones.edit.title')
            </p>

            <div class="flex items-center gap-x-2.5">
                <a
                    href="{{ route('admin.settings.shipping_zones.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
                >
                    @lang('admin::app.settings.shipping-zones.edit.back-btn')
                </a>

                <button type="submit" class="primary-button">
                    @lang('admin::app.settings.shipping-zones.edit.save-btn')
                </button>
            </div>
        </div>

        <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
            <!-- Left -->
            <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
                <!-- General -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('admin::app.settings.shipping-zones.create.general')
                    </p>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('admin::app.settings.shipping-zones.create.name')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="name"
                            rules="required"
                            :value="old('name') ?? $shippingZone->name"
                            :label="trans('admin::app.settings.shipping-zones.create.name')"
                            :placeholder="trans('admin::app.settings.shipping-zones.create.name')"
                        />

                        <x-admin::form.control-group.error control-name="name" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="!mb-0">
                        <x-admin::form.control-group.label>
                            @lang('admin::app.settings.shipping-zones.create.code')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="code"
                            :value="old('code') ?? $shippingZone->code"
                            :label="trans('admin::app.settings.shipping-zones.create.code')"
                            :placeholder="trans('admin::app.settings.shipping-zones.create.code-placeholder')"
                        />

                        <x-admin::form.control-group.error control-name="code" />
                    </x-admin::form.control-group>
                </div>

                <!-- Provinces -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-1 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('admin::app.settings.shipping-zones.create.provinces')
                    </p>

                    <p class="mb-4 text-xs text-gray-500">
                        @lang('admin::app.settings.shipping-zones.create.provinces-info')
                    </p>

                    <div class="grid grid-cols-2 gap-2 max-sm:grid-cols-1">
                        @foreach ($provinces as $province)
                            <label class="flex cursor-pointer items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <input
                                    type="checkbox"
                                    name="provinces[]"
                                    value="{{ $province->code }}"
                                    {{ in_array($province->code, $selectedProvinces) ? 'checked' : '' }}
                                >
                                {{ $province->default_name }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Quantity-based pricing -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-1 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('admin::app.settings.shipping-zones.create.pricing')
                    </p>

                    <p class="mb-4 text-xs text-gray-500">
                        @lang('admin::app.settings.shipping-zones.create.pricing-info')
                    </p>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('admin::app.settings.shipping-zones.create.free-qty')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="free_qty"
                            :value="old('free_qty') ?? $shippingZone->free_qty"
                            :label="trans('admin::app.settings.shipping-zones.create.free-qty')"
                            :placeholder="trans('admin::app.settings.shipping-zones.create.free-qty')"
                        />

                        <p class="mt-1 text-xs text-gray-500">
                            @lang('admin::app.settings.shipping-zones.create.free-qty-info')
                        </p>

                        <x-admin::form.control-group.error control-name="free_qty" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="!mb-0">
                        <x-admin::form.control-group.label>
                            @lang('admin::app.settings.shipping-zones.create.extra-unit-cost')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="extra_unit_cost"
                            :value="old('extra_unit_cost') ?? $shippingZone->extra_unit_cost"
                            :label="trans('admin::app.settings.shipping-zones.create.extra-unit-cost')"
                            :placeholder="trans('admin::app.settings.shipping-zones.create.extra-unit-cost')"
                        />

                        <p class="mt-1 text-xs text-gray-500">
                            @lang('admin::app.settings.shipping-zones.create.extra-unit-cost-info')
                        </p>

                        <x-admin::form.control-group.error control-name="extra_unit_cost" />
                    </x-admin::form.control-group>
                </div>
            </div>

            <!-- Right -->
            <div class="flex w-[360px] max-w-full flex-col gap-2">
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <!-- Base cost -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('admin::app.settings.shipping-zones.create.base-cost')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="base_cost"
                            :value="old('base_cost') ?? $shippingZone->base_cost"
                            :label="trans('admin::app.settings.shipping-zones.create.base-cost')"
                            :placeholder="trans('admin::app.settings.shipping-zones.create.base-cost')"
                        />

                        <p class="mt-1 text-xs text-gray-500">
                            @lang('admin::app.settings.shipping-zones.create.base-cost-info')
                        </p>

                        <x-admin::form.control-group.error control-name="base_cost" />
                    </x-admin::form.control-group>

                    <!-- Fallback -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('admin::app.settings.shipping-zones.create.fallback')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="hidden" name="is_fallback" value="0" />

                        <x-admin::form.control-group.control
                            type="switch"
                            name="is_fallback"
                            value="1"
                            :checked="(bool) (old('is_fallback') ?? $shippingZone->is_fallback)"
                        />

                        <p class="mt-1 text-xs text-gray-500">
                            @lang('admin::app.settings.shipping-zones.create.fallback-info')
                        </p>
                    </x-admin::form.control-group>

                    <!-- Status -->
                    <x-admin::form.control-group class="!mb-0">
                        <x-admin::form.control-group.label>
                            @lang('admin::app.settings.shipping-zones.create.status')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="hidden" name="status" value="0" />

                        <x-admin::form.control-group.control
                            type="switch"
                            name="status"
                            value="1"
                            :checked="(bool) (old('status') ?? $shippingZone->status)"
                        />
                    </x-admin::form.control-group>
                </div>
            </div>
        </div>
    </x-admin::form>
</x-admin::layouts>
