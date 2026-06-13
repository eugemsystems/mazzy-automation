{!! view_render_event('bagisto.shop.checkout.onepage.shipping_methods.before') !!}

<v-shipping-methods
    :methods="shippingMethods"
    @processing="stepForward"
    @processed="stepProcessed"
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
                        <div class="grid gap-3 sm:grid-cols-2">
                            <template v-for="method in methods">
                                {!! view_render_event('bagisto.shop.checkout.onepage.shipping_method.before') !!}

                                <div
                                    class="relative select-none"
                                    v-for="rate in method.rates"
                                >
                                    <input
                                        type="radio"
                                        name="shipping_method"
                                        :id="rate.method"
                                        :value="rate.method"
                                        class="peer hidden"
                                        @change="store(rate.method)"
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

                                {!! view_render_event('bagisto.shop.checkout.onepage.shipping_method.after') !!}
                            </template>
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

            emits: ['processing', 'processed'],

            methods: {
                store(selectedMethod) {
                    this.$emit('processing', 'payment');

                    this.$axios.post("{{ route('shop.checkout.onepage.shipping_methods.store') }}", {    
                            shipping_method: selectedMethod,
                        })
                        .then(response => {
                            if (response.data.redirect_url) {
                                window.location.href = response.data.redirect_url;
                            } else {
                                this.$emit('processed', response.data.payment_methods);
                            }
                        })
                        .catch(error => {
                            this.$emit('processing', 'shipping');

                            if (error.response.data.redirect_url) {
                                window.location.href = error.response.data.redirect_url;
                            }
                        });
                },
            },
        });
    </script>
@endPushOnce
