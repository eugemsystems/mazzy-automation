<!-- Mini Cart Vue Component -->
<v-mini-cart>
    <span
        class="icon-cart cursor-pointer text-2xl"
        role="button"
        aria-label="@lang('shop::app.checkout.cart.mini-cart.shopping-cart')"
    ></span>
</v-mini-cart>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-mini-cart-template"
    >
        {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.before') !!}

        @if (core()->getConfigData('sales.checkout.mini_cart.display_mini_cart'))
            <x-shop::drawer>
                <!-- Drawer Toggler -->
                <x-slot:toggle>
                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.toggle.before') !!}

                    <span class="relative">
                        <span
                            class="icon-cart cursor-pointer text-2xl"
                            role="button"
                            aria-label="@lang('shop::app.checkout.cart.mini-cart.shopping-cart')"
                            tabindex="0"
                            @click="getCart"
                        ></span>

                        @if (core()->getConfigData('sales.checkout.my_cart.summary') == 'display_item_quantity')
                            <span
                                class="absolute -top-4 rounded-[44px] bg-[#332a5e] px-2 py-1.5 text-xs font-semibold leading-[9px] text-white ltr:left-5 rtl:right-5 max-md:ltr:left-4 max-md:rtl:right-4"
                                v-if="cart?.items_qty"
                            >
                                @{{ cart.items_qty }}
                            </span>
                        @else
                            <span
                                class="absolute -top-4 rounded-[44px] bg-[#332a5e] px-2 py-1.5 text-xs font-semibold leading-[9px] text-white ltr:left-5 rtl:right-5 max-md:px-2 max-md:py-1.5 max-md:ltr:left-4 max-md:rtl:right-4"
                                v-if="cart?.items_count"
                            >
                                @{{ cart.items_count }}
                            </span>
                        @endif
                    </span>

                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.toggle.after') !!}
                </x-slot>

                <!-- Drawer Header -->
                <x-slot:header>
                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.header.before') !!}

                    <div class="flex items-center justify-between">
                        <p class="text-base font-semibold text-slate-900">
                            @lang('shop::app.checkout.cart.mini-cart.shopping-cart')
                        </p>
                    </div>

                    <p class="mt-0.5 text-xs text-slate-500">
                        {{ core()->getConfigData('sales.checkout.mini_cart.offer_info')}}
                    </p>

                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.header.after') !!}
                </x-slot>

                <!-- Drawer Content -->
                <x-slot:content>
                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.before') !!}

                    <!-- Cart Item Listing -->
                    <div
                        class="mt-3 grid gap-2.5"
                        v-if="cart?.items?.length"
                    >
                        <div
                            class="relative flex gap-3.5 rounded-2xl border border-slate-100 bg-white p-3 shadow-sm transition hover:border-slate-200"
                            v-for="item in cart?.items"
                        >
                            <!-- Cart Item Image -->
                            {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.image.before') !!}

                            <div class="shrink-0">
                                <a :href="'{{ route('shop.product_or_category.index', ':slug') }}'.replace(':slug', item.product_url_key)">
                                    <img
                                        :src="item.base_image.small_image_url"
                                        class="h-20 w-20 rounded-xl bg-slate-50 object-cover max-md:h-16 max-md:w-16"
                                    />
                                </a>
                            </div>

                            {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.image.after') !!}

                        <!-- Cart Item Information -->
                        <div class="grid flex-1 place-content-start justify-stretch gap-y-1">
                            <div class="flex justify-between gap-2 max-md:gap-0 max-sm:flex-wrap">

                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.name.before') !!}

                                    <a
                                    class="max-w-4/5 max-md:w-full"
                                    :href="'{{ route('shop.product_or_category.index', ':slug') }}'.replace(':slug', item.product_url_key)"
                                >
                                        <p class="text-sm font-semibold leading-snug text-slate-800">
                                            @{{ item.name }}
                                        </p>
                                    </a>

                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.name.after') !!}

                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.price.before') !!}

                                    <template v-if="displayTax.prices == 'including_tax'">
                                        <p class="whitespace-nowrap text-sm font-bold text-[#332a5e]">
                                            @{{ item.formatted_price_incl_tax }}
                                        </p>
                                    </template>

                                    <template v-else-if="displayTax.prices == 'both'">
                                        <p class="flex flex-col whitespace-nowrap text-sm font-bold text-[#332a5e]">
                                            @{{ item.formatted_price_incl_tax }}

                                            <span class="text-xs font-normal text-slate-400">
                                                @lang('shop::app.checkout.cart.mini-cart.excl-tax')

                                                <span class="font-medium text-slate-600">@{{ item.formatted_price }}</span>
                                            </span>
                                        </p>
                                    </template>

                                    <template v-else>
                                        <p class="whitespace-nowrap text-sm font-bold text-[#332a5e]">
                                            @{{ item.formatted_price }}
                                        </p>
                                    </template>

                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.price.after') !!}
                                </div>

                                <!-- Cart Item Options Container -->
                                <div
                                    class="grid select-none gap-x-2.5 gap-y-1.5 max-sm:gap-y-0.5"
                                    v-if="item.options.length"
                                >

                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.product_details.before') !!}

                                    <!-- Details Toggler -->
                                    <div class="">
                                        <p
                                            class="flex cursor-pointer items-center gap-x-1 text-xs text-slate-400 hover:text-slate-600"
                                            @click="item.option_show = ! item.option_show"
                                        >
                                            @lang('shop::app.checkout.cart.mini-cart.see-details')

                                            <span
                                                class="text-sm"
                                                :class="{'icon-arrow-up': item.option_show, 'icon-arrow-down': ! item.option_show}"
                                            ></span>
                                        </p>
                                    </div>

                                    <!-- Option Details -->
                                    <div
                                        class="grid gap-2"
                                        v-show="item.option_show"
                                    >
                                        <template v-for="attribute in item.options">
                                            <div class="max-md:grid max-md:gap-0.5">
                                                <p class="text-sm font-medium text-slate-500 max-md:font-normal max-sm:text-xs">
                                                    @{{ attribute.attribute_name + ':' }}
                                                </p>

                                                <p class="text-sm max-sm:text-xs">
                                                    <template v-if="attribute?.attribute_type === 'file'">
                                                        <a
                                                            :href="attribute.file_url"
                                                            class="text-[#332a5e] underline"
                                                            target="_blank"
                                                            :download="attribute.file_name"
                                                        >
                                                            @{{ attribute.file_name }}
                                                        </a>
                                                    </template>

                                                    <template v-else>
                                                        @{{ attribute.option_label }}
                                                    </template>
                                                </p>
                                            </div>
                                        </template>
                                    </div>

                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.product_details.after') !!}
                                </div>

                                <div class="mt-1 flex items-center gap-2">
                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.quantity_changer.before') !!}

                                <!-- Cart Item Quantity Changer -->
                                <x-shop::quantity-changer
                                    v-if="item.can_change_qty"
                                    ::key="'qty-' + item.id + '-' + refreshKey"
                                    name="quantity"
                                    ::value="item?.quantity"
                                    @change="updateItem($event, item)"
                                />

                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.quantity_changer.after') !!}

                                {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.remove_button.before') !!}

                                <!-- Cart Item Remove Button -->
                                <button
                                    type="button"
                                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-400 transition hover:border-red-200 hover:bg-red-50 hover:text-red-500"
                                    aria-label="@lang('shop::app.checkout.cart.mini-cart.remove')"
                                    @click="removeItem(item.id)"
                                >
                                    <span class="icon-bin text-base"></span>
                                </button>

                                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.remove_button.after') !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty Cart Section -->
                    <div
                        class="mt-32 pb-8 max-md:mt-32"
                        v-else
                    >
                        <div class="b-0 grid place-items-center gap-y-5 max-md:gap-y-0">
                            <img
                                class="max-md:h-[100px] max-md:w-[100px]"
                                src="{{ bagisto_asset('images/thank-you.png') }}"
                                loading="lazy"
                                decoding="async"
                            >

                            <p
                                class="text-xl max-md:text-sm"
                                role="heading"
                            >
                                @lang('shop::app.checkout.cart.mini-cart.empty-cart')
                            </p>
                        </div>
                    </div>

                    {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.content.after') !!}
                </x-slot>

            <!-- Drawer Footer -->
            <x-slot:footer>
                <div
                    v-if="cart?.items?.length"
                    class="border-t border-slate-100 p-4"
                >
                    <!-- Gradient checkout panel -->
                    <div class="rounded-2xl bg-gradient-to-br from-[#332a5e] to-[#1f1940] p-4 shadow-lg shadow-[#332a5e]/25">
                        <div
                            class="mb-4 flex items-end justify-between"
                            :class="{'!justify-center': isLoading}"
                        >
                            {!! view_render_event('bagisto.shop.checkout.mini-cart.subtotal.before') !!}

                            <template v-if="! isLoading">
                                <p class="text-xs font-medium uppercase tracking-widest text-white/60">
                                    @lang('shop::app.checkout.cart.mini-cart.subtotal')
                                </p>

                            <template v-if="displayTax.subtotal == 'including_tax'">
                                <p class="text-2xl font-extrabold text-white">
                                    @{{ cart.formatted_sub_total_incl_tax }}
                                </p>
                            </template>

                            <template v-else-if="displayTax.subtotal == 'both'">
                                <p class="flex flex-col items-end text-2xl font-extrabold text-white">
                                    @{{ cart.formatted_sub_total_incl_tax }}

                                    <span class="text-xs font-normal text-white/60">
                                        @lang('shop::app.checkout.cart.mini-cart.excl-tax')

                                        <span class="font-medium text-white/80">@{{ cart.formatted_sub_total }}</span>
                                    </span>
                                </p>
                            </template>

                            <template v-else>
                                <p class="text-2xl font-extrabold text-white">
                                    @{{ cart.formatted_sub_total }}
                                </p>
                            </template>
                        </template>

                            <template v-else>
                                <!-- Spinner -->
                                <svg
                                    class="h-7 w-7 animate-spin text-white"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    aria-hidden="true"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    ></circle>

                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    ></path>
                                </svg>
                            </template>

                            {!! view_render_event('bagisto.shop.checkout.mini-cart.subtotal.after') !!}
                        </div>

                        {!! view_render_event('bagisto.shop.checkout.mini-cart.action.before') !!}
                        {!! view_render_event('bagisto.shop.checkout.mini-cart.continue_to_checkout.before') !!}

                        <!-- Checkout CTA -->
                        <a
                            href="{{ route('shop.checkout.onepage.index') }}"
                            class="flex w-full cursor-pointer items-center justify-center gap-2 rounded-xl bg-white px-6 py-3.5 text-sm font-bold text-[#332a5e] shadow-sm transition hover:bg-white/90"
                        >
                            @lang('shop::app.checkout.cart.mini-cart.continue-to-checkout')
                            <span class="icon-arrow-right rtl:icon-arrow-left text-base"></span>
                        </a>

                        {!! view_render_event('bagisto.shop.checkout.mini-cart.continue_to_checkout.after') !!}
                    </div>

                    <!-- View full cart -->
                    <a
                        href="{{ route('shop.checkout.cart.index') }}"
                        class="mt-2.5 block w-full rounded-xl border border-slate-200 bg-white px-6 py-2.5 text-center text-sm font-semibold text-slate-600 transition hover:border-[#332a5e] hover:text-[#332a5e]"
                    >
                        @lang('shop::app.checkout.cart.mini-cart.view-cart')
                    </a>

                    {!! view_render_event('bagisto.shop.checkout.mini-cart.action.after') !!}
                </div>
                </x-slot>
            </x-shop::drawer>

        @else
            <a href="{{ route('shop.checkout.onepage.index') }}">
                {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.toggle.before') !!}

                    <span class="relative">
                        <span
                            class="icon-cart cursor-pointer text-2xl"
                            role="button"
                            aria-label="@lang('shop::app.checkout.cart.mini-cart.shopping-cart')"
                            tabindex="0"
                        ></span>

                        <span
                            class="absolute -top-4 rounded-[44px] bg-[#332a5e] px-2 py-1.5 text-xs font-semibold leading-[9px] text-white ltr:left-5 rtl:right-5 max-md:px-2 max-md:py-1.5 max-md:ltr:left-4 max-md:rtl:right-4"
                            v-if="cart?.items_qty"
                        >
                            @{{ cart.items_qty }}
                        </span>
                    </span>

                {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.toggle.after') !!}
            </a>
        @endif

        {!! view_render_event('bagisto.shop.checkout.mini-cart.drawer.after') !!}
    </script>

    <script type="module">
        app.component("v-mini-cart", {
            template: '#v-mini-cart-template',

            data() {
                return  {
                    refreshKey: 0,

                    cart: null,

                    isLoading:false,

                    displayTax: {
                        prices: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_prices') }}",
                        subtotal: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_subtotal') }}",
                    },
                };
            },

            mounted() {
                if (!this.cart) {
                    this.getCart();
                }

                /**
                 * Action.
                 */
                this.$emitter.on('update-mini-cart', (cart) => {
                    this.cart = cart;
                });
            },

            methods: {
                getCart() {
                    this.$axios.get('{{ route('shop.api.checkout.cart.index') }}')
                        .then(response => {
                            this.cart = response.data.data;
                        })
                        .catch(error => {});
                },

                updateItem(quantity, item) {
                    this.isLoading = true;

                    let qty = {};

                    qty[item.id] = quantity;

                    this.$axios.put('{{ route('shop.api.checkout.cart.update') }}', { qty })
                        .then(response => {
                            this.isLoading = false;

                            /**
                             * The update endpoint returns `{ data: CartResource, message }`
                             * on success and only `{ message }` on failure (e.g.
                             * inventory-warning). Only treat the payload as a cart when
                             * it has an `items` field — otherwise surface the server
                             * message as a warning flash.
                             */
                            const payload = response.data.data;

                            if (payload && payload.items !== undefined) {
                                this.cart = payload;
                            } else {
                                this.$emitter.emit('add-flash', {
                                    type: 'warning',
                                    message: payload?.message || response.data.message,
                                });
                            }

                            /**
                             * Bump the key so the quantity-changer remounts from the
                             * current server value even when the update was rejected
                             * (in which case `value` didn't change and the component's
                             * `value` watcher wouldn't fire).
                             */
                            this.refreshKey++;
                        })
                        .catch(error => {
                            this.isLoading = false;

                            this.$emitter.emit('add-flash', {
                                type: 'error',
                                message: error.response?.data?.message || error.message,
                            });

                            this.refreshKey++;
                        });
                },

                removeItem(itemId) {
                    this.$emitter.emit('open-confirm-modal', {
                        agree: () => {
                            this.isLoading = true;

                            this.$axios.post('{{ route('shop.api.checkout.cart.destroy') }}', {
                                '_method': 'DELETE',
                                'cart_item_id': itemId,
                            })
                            .then(response => {
                                this.cart = response.data.data;

                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                this.isLoading = false;
                            })
                            .catch(error => {
                                this.$emitter.emit('add-flash', { type: 'error', message: response.data.message });

                                this.isLoading = false;
                            });
                        }
                    });
                },
            },
        });
    </script>
@endpushOnce
