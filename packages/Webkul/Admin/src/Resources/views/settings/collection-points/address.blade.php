@php
    $defaultCountry = old('country') ?? ($collectionPoint?->country ?? 'ZA');
    $defaultState   = old('state') ?? ($collectionPoint?->state ?? '');
    $defaultCity    = old('city') ?? ($collectionPoint?->city ?? '');
    $defaultStreet  = old('street') ?? ($collectionPoint?->street ?? '');
    $defaultPostcode = old('postcode') ?? ($collectionPoint?->postcode ?? '');
@endphp

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-collection-point-address-template"
    >
        <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
            <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                @lang('admin::app.settings.collection-points.create.address')
            </p>

            <!-- Country -->
            <x-admin::form.control-group>
                <x-admin::form.control-group.label class="required">
                    @lang('admin::app.settings.collection-points.create.country')
                </x-admin::form.control-group.label>

                <x-admin::form.control-group.control
                    type="select"
                    id="country"
                    name="country"
                    rules="required"
                    v-model="country"
                    :label="trans('admin::app.settings.collection-points.create.country')"
                    :placeholder="trans('admin::app.settings.collection-points.create.country')"
                >
                    <option value="">
                        @lang('admin::app.settings.collection-points.create.select-country')
                    </option>

                    @foreach (core()->countries() as $country)
                        <option value="{{ $country->code }}">
                            {{ $country->name }}
                        </option>
                    @endforeach
                </x-admin::form.control-group.control>

                <x-admin::form.control-group.error control-name="country" />
            </x-admin::form.control-group>

            <!-- State -->
            <x-admin::form.control-group>
                <x-admin::form.control-group.label class="required">
                    @lang('admin::app.settings.collection-points.create.state')
                </x-admin::form.control-group.label>

                <template v-if="haveStates()">
                    <x-admin::form.control-group.control
                        type="select"
                        id="state"
                        name="state"
                        rules="required"
                        v-model="state"
                        :label="trans('admin::app.settings.collection-points.create.state')"
                        :placeholder="trans('admin::app.settings.collection-points.create.state')"
                    >
                        <option value="">
                            @lang('admin::app.settings.collection-points.create.select-state')
                        </option>

                        <option
                            v-for="(stateOption, index) in countryStates[country]"
                            :value="stateOption.code"
                        >
                            @{{ stateOption.default_name }}
                        </option>
                    </x-admin::form.control-group.control>
                </template>

                <template v-else>
                    <x-admin::form.control-group.control
                        type="text"
                        id="state"
                        name="state"
                        rules="required"
                        v-model="state"
                        :label="trans('admin::app.settings.collection-points.create.state')"
                        :placeholder="trans('admin::app.settings.collection-points.create.state')"
                    />
                </template>

                <x-admin::form.control-group.error control-name="state" />
            </x-admin::form.control-group>

            <!-- City -->
            <x-admin::form.control-group>
                <x-admin::form.control-group.label class="required">
                    @lang('admin::app.settings.collection-points.create.city')
                </x-admin::form.control-group.label>

                <x-admin::form.control-group.control
                    type="text"
                    id="city"
                    name="city"
                    rules="required"
                    value="{{ $defaultCity }}"
                    :label="trans('admin::app.settings.collection-points.create.city')"
                    :placeholder="trans('admin::app.settings.collection-points.create.city')"
                />

                <x-admin::form.control-group.error control-name="city" />
            </x-admin::form.control-group>

            <!-- Street -->
            <x-admin::form.control-group>
                <x-admin::form.control-group.label class="required">
                    @lang('admin::app.settings.collection-points.create.street')
                </x-admin::form.control-group.label>

                <x-admin::form.control-group.control
                    type="text"
                    id="street"
                    name="street"
                    rules="required"
                    value="{{ $defaultStreet }}"
                    :label="trans('admin::app.settings.collection-points.create.street')"
                    :placeholder="trans('admin::app.settings.collection-points.create.street')"
                />

                <x-admin::form.control-group.error control-name="street" />
            </x-admin::form.control-group>

            <!-- Postcode -->
            <x-admin::form.control-group class="!mb-0">
                <x-admin::form.control-group.label class="required">
                    @lang('admin::app.settings.collection-points.create.postcode')
                </x-admin::form.control-group.label>

                <x-admin::form.control-group.control
                    type="text"
                    id="postcode"
                    name="postcode"
                    rules="required"
                    value="{{ $defaultPostcode }}"
                    :label="trans('admin::app.settings.collection-points.create.postcode')"
                    :placeholder="trans('admin::app.settings.collection-points.create.postcode')"
                />

                <x-admin::form.control-group.error control-name="postcode" />
            </x-admin::form.control-group>
        </div>
    </script>

    <script type="module">
        app.component('v-collection-point-address', {
            template: '#v-collection-point-address-template',

            data() {
                return {
                    country: "{{ $defaultCountry }}",

                    state: "{{ $defaultState }}",

                    countryStates: @json(core()->groupedStatesByCountries()),
                };
            },

            methods: {
                haveStates() {
                    return !! this.countryStates[this.country]?.length;
                },
            },
        });
    </script>
@endPushOnce
