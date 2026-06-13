{!! view_render_event('bagisto.shop.checkout.onepage.payment_methods.before') !!}

<v-payment-methods
    :methods="paymentMethods"
    @processing="stepForward"
    @processed="stepProcessed"
>
    <x-shop::shimmer.checkout.onepage.payment-method />
</v-payment-methods>

{!! view_render_event('bagisto.shop.checkout.onepage.payment_methods.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-payment-methods-template"
    >
        <div class="mb-7 max-md:last:!mb-0">
            <template v-if="! methods">
                <!-- Payment Method shimmer Effect -->
                <x-shop::shimmer.checkout.onepage.payment-method />
            </template>
    
            <template v-else>
                {!! view_render_event('bagisto.shop.checkout.onepage.payment_method.accordion.before') !!}

                <!-- Accordion Blade Component -->
                <x-shop::accordion class="mb-4 overflow-hidden rounded-2xl border border-slate-100 bg-white !border-b shadow-sm">
                    <!-- Accordion Blade Component Header -->
                    <x-slot:header class="!px-5 !py-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-base font-semibold text-slate-900">
                                @lang('shop::app.checkout.onepage.payment.payment-method')
                            </h2>
                        </div>
                    </x-slot>

                    <!-- Accordion Blade Component Content -->
                    <x-slot:content class="!px-5 !pb-5 !pt-0">
                        <div class="grid gap-3 sm:grid-cols-2">
                            <div
                                class="relative cursor-pointer"
                                v-for="(payment, index) in methods"
                            >
                                {!! view_render_event('bagisto.shop.checkout.payment-method.before') !!}

                                <input
                                    type="radio"
                                    name="payment[method]"
                                    :value="payment.payment"
                                    :id="payment.method"
                                    class="peer hidden"
                                    @change="store(payment)"
                                >

                                <label
                                    :for="payment.method"
                                    class="flex h-full cursor-pointer items-center gap-3.5 rounded-xl border border-slate-200 bg-white p-4 transition hover:border-slate-300 peer-checked:border-[#332a5e] peer-checked:bg-[#332a5e]/5 peer-checked:ring-1 peer-checked:ring-[#332a5e] ltr:pr-10 rtl:pl-10"
                                >
                                    {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.image.before') !!}

                                    <img
                                        class="h-10 w-10 shrink-0 rounded-lg object-contain"
                                        :src="payment.image"
                                        width="55"
                                        height="55"
                                        :alt="payment.method_title"
                                        :title="payment.method_title"
                                    />

                                    {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.image.after') !!}

                                    <div class="min-w-0 flex-1">
                                        {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.title.before') !!}

                                        <p class="text-sm font-semibold text-slate-800">
                                            @{{ payment.method_title }}
                                        </p>

                                        {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.title.after') !!}

                                        {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.description.before') !!}

                                        <p class="mt-0.5 text-xs text-slate-500">
                                            @{{ payment.description }}
                                        </p>

                                        {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.description.after') !!}

                                    </div>
                                </label>

                                <label
                                    :for="payment.method"
                                    class="icon-radio-unselect peer-checked:icon-radio-select pointer-events-none absolute top-4 text-xl text-slate-300 peer-checked:text-[#332a5e] ltr:right-4 rtl:left-4"
                                >
                                </label>

                                {!! view_render_event('bagisto.shop.checkout.payment-method.after') !!}

                                <!-- Todo implement the additionalDetails -->
                                {{-- \Webkul\Payment\Payment::getAdditionalDetails($payment['method'] --}}
                            </div>
                        </div>
                    </x-slot>
                </x-shop::accordion>

                {!! view_render_event('bagisto.shop.checkout.onepage.payment_method.accordion.after') !!}
            </template>
        </div>
    </script>

    <script type="module">
        app.component('v-payment-methods', {
            template: '#v-payment-methods-template',

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
                    this.$emit('processing', 'review');

                    this.$axios.post("{{ route('shop.checkout.onepage.payment_methods.store') }}", {
                            payment: selectedMethod
                        })
                        .then(response => {
                            this.$emit('processed', response.data.cart);

                            // Used in mobile view. 
                            if (window.innerWidth <= 768) {
                                window.scrollTo({
                                    top: document.body.scrollHeight,
                                    behavior: 'smooth'
                                });
                            }
                        })
                        .catch(error => {
                            this.$emit('processing', 'payment');

                            if (error.response.data.redirect_url) {
                                window.location.href = error.response.data.redirect_url;
                            }
                        });
                },
            },
        });
    </script>
@endPushOnce
