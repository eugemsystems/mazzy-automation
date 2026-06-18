{!! view_render_event('bagisto.shop.checkout.onepage.shipping_methods.before') !!}

<v-shipping-methods
    :methods="shippingMethods"
    @processing="stepForward"
    @processed="stepProcessed"
    @refresh="getCart"
>
    <!-- Shipping Method Shimmer Effect -->
    <x-shop::shimmer.checkout.onepage.shipping-method />
</v-shipping-methods>

{!! view_render_event('bagisto.shop.checkout.onepage.shipping_methods.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-shipping-methods-template"
    >
        <div class="mb-7 max-md:mb-0">
            <template v-if="! methods">
                <!-- Shipping Method Shimmer Effect -->
                <x-shop::shimmer.checkout.onepage.shipping-method />
            </template>

            <template v-else>
                <!-- Accordion Blade Component -->
                <x-shop::accordion class="mb-4 overflow-hidden rounded-2xl border border-slate-100 bg-white !border-b shadow-sm">
                    <!-- Accordion Blade Component Header -->
                    <x-slot:header class="!px-5 !py-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-base font-semibold text-slate-900">
                                @lang('shop::app.checkout.onepage.shipping.shipping-method')
                            </h2>
                        </div>
                    </x-slot>

                    <!-- Accordion Blade Component Content -->
                    <x-slot:content class="!px-5 !pb-5 !pt-0">
                        <!-- Province Delivery (auto-applied) -->
                        <div
                            v-if="provinceRate"
                            class="relative mb-3 select-none"
                        >
                            <input
                                type="radio"
                                name="shipping_method"
                                :id="provinceRate.method"
                                :value="provinceRate.method"
                                :checked="selectedMethod === provinceRate.method"
                                class="peer hidden"
                                @change="select(provinceRate.method)"
                            >

                            <label
                                class="flex h-full cursor-pointer items-center gap-3.5 rounded-xl border border-slate-200 bg-white p-4 transition hover:border-slate-300 peer-checked:border-[#332a5e] peer-checked:bg-[#332a5e]/5 peer-checked:ring-1 peer-checked:ring-[#332a5e] ltr:pr-10 rtl:pl-10"
                                :for="provinceRate.method"
                            >
                                <span class="icon-flate-rate shrink-0 text-3xl text-[#332a5e]"></span>

                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-slate-800">
                                        @lang('shop::app.checkout.onepage.shipping.delivery-title')
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-500">
                                        @{{ provinceRate.method_description }}
                                    </p>

                                    <p class="mt-1 text-base font-bold text-[#332a5e]">
                                        @{{ provinceRate.base_formatted_price }}
                                    </p>
                                </div>
                            </label>

                            <label
                                class="icon-radio-unselect peer-checked:icon-radio-select pointer-events-none absolute top-4 text-xl text-slate-300 peer-checked:text-[#332a5e] ltr:right-4 rtl:left-4"
                                :for="provinceRate.method"
                            >
                            </label>
                        </div>

                        <!-- Collection Points (optional alternatives) -->
                        <template v-if="collectionRates.length">
                            <p class="mb-2 mt-4 text-xs font-medium uppercase tracking-widest text-slate-400">
                                @lang('shop::app.checkout.onepage.shipping.or-collect-title')
                            </p>

                            <div class="grid gap-3 sm:grid-cols-2">
                                <div
                                    class="relative select-none"
                                    v-for="rate in collectionRates"
                                >
                                    <input
                                        type="radio"
                                        name="shipping_method"
                                        :id="rate.method"
                                        :value="rate.method"
                                        :checked="selectedMethod === rate.method"
                                        class="peer hidden"
                                        @change="select(rate.method)"
                                    >

                                    <label
                                        class="flex h-full cursor-pointer items-center gap-3.5 rounded-xl border border-slate-200 bg-white p-4 transition hover:border-slate-300 peer-checked:border-[#332a5e] peer-checked:bg-[#332a5e]/5 peer-checked:ring-1 peer-checked:ring-[#332a5e] ltr:pr-10 rtl:pl-10"
                                        :for="rate.method"
                                    >
                                        <span class="icon-flate-rate shrink-0 text-3xl text-[#332a5e]"></span>

                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-semibold text-slate-800">
                                                @{{ rate.method_title }}
                                            </p>

                                            <p class="mt-0.5 text-xs text-slate-500">
                                                @{{ rate.method_description }}
                                            </p>

                                            <p class="mt-1 text-base font-bold text-[#332a5e]">
                                                @{{ rate.base_formatted_price }}
                                            </p>
                                        </div>
                                    </label>

                                    <label
                                        class="icon-radio-unselect peer-checked:icon-radio-select pointer-events-none absolute top-4 text-xl text-slate-300 peer-checked:text-[#332a5e] ltr:right-4 rtl:left-4"
                                        :for="rate.method"
                                    >
                                    </label>
                                </div>
                            </div>
                        </template>

                        <!-- Continue to payment -->
                        <div class="mt-4 flex justify-end">
                            <x-shop::button
                                type="button"
                                class="primary-button"
                                :title="trans('shop::app.checkout.onepage.shipping.continue-to-payment')"
                                ::disabled="isProceeding || ! selectedMethod"
                                ::loading="isProceeding"
                                @click="proceed"
                            />
                        </div>
                    </x-slot>
                </x-shop::accordion>
            </template>
        </div>
    </script>

    <script type="module">
        app.component('v-shipping-methods', {
            template: '#v-shipping-methods-template',

            props: {
                methods: {
                    type: Object,
                    required: true,
                    default: () => null,
                },
            },

            emits: ['processing', 'processed', 'refresh'],

            data() {
                return {
                    selectedMethod: null,

                    isApplying: false,

                    isProceeding: false,
                };
            },

            computed: {
                allRates() {
                    let rates = [];

                    if (! this.methods) {
                        return rates;
                    }

                    for (let key in this.methods) {
                        (this.methods[key].rates || []).forEach(rate => rates.push(rate));
                    }

                    return rates;
                },

                provinceRate() {
                    return this.allRates.find(rate => rate.carrier === 'zone_rate') || null;
                },

                collectionRates() {
                    return this.allRates.filter(rate => rate.carrier === 'collection_point');
                },
            },

            watch: {
                methods: {
                    immediate: true,

                    handler(value) {
                        if (value && ! this.selectedMethod && this.provinceRate) {
                            this.selectedMethod = this.provinceRate.method;
                        }
                    },
                },
            },

            methods: {
                /**
                 * Apply the chosen method (province delivery or a collection
                 * point) and refresh the totals, without advancing the step.
                 */
                select(method) {
                    if (this.isApplying || this.selectedMethod === method) {
                        return;
                    }

                    this.isApplying = true;

                    this.$axios.post("{{ route('shop.checkout.onepage.shipping_methods.store') }}", {
                            shipping_method: method,
                        })
                        .then(response => {
                            this.isApplying = false;

                            if (response.data.redirect_url) {
                                window.location.href = response.data.redirect_url;

                                return;
                            }

                            this.selectedMethod = method;

                            this.$emit('refresh');
                        })
                        .catch(error => {
                            this.isApplying = false;

                            if (error.response?.data?.redirect_url) {
                                window.location.href = error.response.data.redirect_url;
                            }
                        });
                },

                /**
                 * Persist the selected method and move to the payment step.
                 */
                proceed() {
                    let method = this.selectedMethod || (this.provinceRate ? this.provinceRate.method : null);

                    if (! method) {
                        return;
                    }

                    this.isProceeding = true;

                    this.$emit('processing', 'payment');

                    this.$axios.post("{{ route('shop.checkout.onepage.shipping_methods.store') }}", {
                            shipping_method: method,
                        })
                        .then(response => {
                            this.isProceeding = false;

                            if (response.data.redirect_url) {
                                window.location.href = response.data.redirect_url;
                            } else {
                                this.$emit('processed', response.data.payment_methods);
                            }
                        })
                        .catch(error => {
                            this.isProceeding = false;

                            this.$emit('processing', 'shipping');

                            if (error.response?.data?.redirect_url) {
                                window.location.href = error.response.data.redirect_url;
                            }
                        });
                },
            },
        });
    </script>
@endPushOnce
