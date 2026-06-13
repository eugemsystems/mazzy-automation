<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="@lang('shop::app.checkout.cart.index.cart')"/>

    <meta name="keywords" content="@lang('shop::app.checkout.cart.index.cart')"/>
@endPush

<x-shop::layouts
    :has-header="true"
    :has-feature="false"
    :has-footer="true"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.checkout.cart.index.cart')
    </x-slot>

    {!! view_render_event('bagisto.shop.checkout.cart.header.before') !!}

    <div class="border-b border-slate-200 bg-white">
        <div class="container px-[60px] py-6 max-1180:px-4">
            <nav class="mb-1.5 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('shop.home.index') }}" class="transition-colors hover:text-[#332a5e]">Home</a>
                <span class="icon-arrow-right rtl:icon-arrow-left text-sm text-slate-300"></span>
                <a href="{{ route('shop.home.store') }}" class="transition-colors hover:text-[#332a5e]">Shop</a>
                <span class="icon-arrow-right rtl:icon-arrow-left text-sm text-slate-300"></span>
                <span class="text-[#332a5e]">Cart</span>
            </nav>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Shopping Cart</h1>
        </div>
    </div>

    {!! view_render_event('bagisto.shop.checkout.cart.header.after') !!}

    <div class="bg-[#f5f6fb] py-8 max-sm:py-5">
        <div class="container px-[60px] max-1180:px-4 max-sm:px-3">

            {!! view_render_event('bagisto.shop.checkout.cart.breadcrumbs.before') !!}
            {!! view_render_event('bagisto.shop.checkout.cart.breadcrumbs.after') !!}

            @php
                $errors = \Webkul\Checkout\Facades\Cart::getErrors();
            @endphp

            @if (! empty($errors) && $errors['error_code'] === 'MINIMUM_ORDER_AMOUNT')
                <div class="mb-5 flex items-center gap-2.5 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                    <span class="icon-error shrink-0 text-base text-amber-500"></span>
                    {{ $errors['message'] }}: {{ $errors['amount'] }}
                </div>
            @endif

            <v-cart ref="vCart">
                <x-shop::shimmer.checkout.cart :count="3" />
            </v-cart>
        </div>
    </div>

    @if (core()->getConfigData('sales.checkout.shopping_cart.cross_sell'))
        {!! view_render_event('bagisto.shop.checkout.cart.cross_sell_carousel.before') !!}

        <!-- Cross-sell Product Carousal -->
        <x-shop::products.carousel
            :title="trans('shop::app.checkout.cart.index.cross-sell.title')"
            :src="route('shop.api.checkout.cart.cross-sell.index')"
        >
        </x-shop::products.carousel>

        {!! view_render_event('bagisto.shop.checkout.cart.cross_sell_carousel.after') !!}
    @endif

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-cart-template"
        >
            <div>
                <template v-if="isLoading">
                    <x-shop::shimmer.checkout.cart :count="3" />
                </template>

                <template v-else>
                    <!-- Filled cart: side-by-side columns -->
                    <div class="flex items-start gap-7 max-1060:flex-col" v-if="cart?.items?.length">

                        <!-- ── Left column: table ── -->
                        <div class="flex-1 min-w-0">

                            {!! view_render_event('bagisto.shop.checkout.cart.cart_mass_actions.before') !!}

                            <!-- Toolbar above table -->
                            <div class="mb-3 flex items-center justify-between">
                                <label class="flex cursor-pointer select-none items-center gap-2 text-xs font-medium text-slate-500" for="select-all">
                                    <input type="checkbox" id="select-all" class="h-4 w-4 cursor-pointer rounded border-slate-300 accent-[#332a5e]" v-model="allSelected" @change="selectAll">
                                    Select all
                                </label>

                                <div class="flex items-center gap-4" v-if="selectedItemsCount">
                                    <button class="text-xs font-semibold text-red-500 hover:text-red-700 transition-colors" @click="removeSelectedItems">
                                        Remove selected
                                    </button>
                                    @if (auth()->guard()->check())
                                    <button class="text-xs font-semibold text-[#332a5e] hover:underline transition-colors" @click="moveToWishlistSelectedItems">
                                        Move to wishlist
                                    </button>
                                    @endif
                                </div>
                            </div>

                            {!! view_render_event('bagisto.shop.checkout.cart.cart_mass_actions.after') !!}

                            <!-- White table card -->
                            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">

                                <!-- Column headers (desktop only) -->
                                <div class="hidden grid-cols-[auto_1fr_auto_auto_auto] items-center gap-4 border-b border-slate-100 bg-[#f5f6fb] px-5 py-2.5 max-md:hidden md:grid">
                                    <span></span>
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Product</span>
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Qty</span>
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 text-right">Total</span>
                                    <span></span>
                                </div>

                                {!! view_render_event('bagisto.shop.checkout.cart.item.listing.before') !!}

                                <!-- Rows -->
                                <div
                                    class="grid grid-cols-[auto_auto_1fr_auto_auto_auto] items-center gap-x-4 gap-y-0 border-b border-slate-100 px-5 py-4 last:border-b-0 max-md:grid-cols-[auto_auto_1fr_auto] max-sm:px-3 max-sm:py-3"
                                    v-for="item in cart?.items"
                                    :key="item.id"
                                >
                                    <!-- Checkbox -->
                                    <div>
                                        <input type="checkbox" :id="'item_' + item.id" class="h-4 w-4 cursor-pointer rounded border-slate-300 accent-[#332a5e]" v-model="item.selected" @change="updateAllSelected">
                                    </div>

                                    {!! view_render_event('bagisto.shop.checkout.cart.item_image.before') !!}

                                    <!-- Image -->
                                    <a :href="'{{ route('shop.product_or_category.index', ':slug') }}'.replace(':slug', item.product_url_key)">
                                        <x-shop::media.images.lazy
                                            class="h-16 w-16 rounded-xl object-cover border border-slate-100 max-sm:h-12 max-sm:w-12"
                                            ::src="item.base_image.small_image_url"
                                            ::alt="item.name"
                                            width="64" height="64"
                                            ::key="item.id" ::index="item.id"
                                        />
                                    </a>

                                    {!! view_render_event('bagisto.shop.checkout.cart.item_image.after') !!}

                                    <!-- Name + options -->
                                    <div class="min-w-0">
                                        {!! view_render_event('bagisto.shop.checkout.cart.item_name.before') !!}

                                        <a :href="'{{ route('shop.product_or_category.index', ':slug') }}'.replace(':slug', item.product_url_key)">
                                            <p class="truncate text-sm font-semibold text-slate-800 hover:text-[#332a5e] transition-colors max-w-[280px]">@{{ item.name }}</p>
                                        </a>

                                        {!! view_render_event('bagisto.shop.checkout.cart.item_name.after') !!}
                                        {!! view_render_event('bagisto.shop.checkout.cart.item_details.before') !!}

                                        <div class="mt-0.5 select-none" v-if="item.options.length">
                                            <button class="flex items-center gap-0.5 text-[11px] text-slate-400 hover:text-slate-600" @click="item.option_show = !item.option_show">
                                                Details
                                                <span class="text-sm" :class="item.option_show ? 'icon-arrow-up' : 'icon-arrow-down'"></span>
                                            </button>
                                            <div class="mt-1" v-show="item.option_show">
                                                <template v-for="attribute in item.options">
                                                    <p class="text-[11px] text-slate-500">
                                                        <span class="font-medium">@{{ attribute.attribute_name }}:</span>
                                                        <template v-if="attribute?.attribute_type === 'file'">
                                                            <a :href="attribute.file_url" class="text-[#332a5e] underline" target="_blank" :download="attribute.file_name">@{{ attribute.file_name }}</a>
                                                        </template>
                                                        <template v-else>@{{ attribute.option_label }}</template>
                                                    </p>
                                                </template>
                                            </div>
                                        </div>

                                        {!! view_render_event('bagisto.shop.checkout.cart.item_details.after') !!}

                                        <!-- Unit price (mobile fallback) -->
                                        {!! view_render_event('bagisto.shop.checkout.cart.formatted_total.before') !!}

                                        <div class="mt-1 md:hidden">
                                            <template v-if="displayTax.prices == 'including_tax'">
                                                <span class="text-xs font-bold text-[#332a5e]">@{{ item.formatted_total_incl_tax }}</span>
                                            </template>
                                            <template v-else>
                                                <span class="text-xs font-bold text-[#332a5e]">@{{ item.formatted_total }}</span>
                                            </template>
                                        </div>

                                        {!! view_render_event('bagisto.shop.checkout.cart.formatted_total.after') !!}
                                    </div>

                                    {!! view_render_event('bagisto.shop.checkout.cart.quantity_changer.before') !!}

                                    <!-- Qty changer -->
                                    <x-shop::quantity-changer
                                        v-if="item.can_change_qty"
                                        ::key="'qty-' + item.id + '-' + refreshKey"
                                        name="quantity"
                                        ::value="item?.quantity"
                                        @change="setItemQuantity(item.id, $event)"
                                    />

                                    {!! view_render_event('bagisto.shop.checkout.cart.quantity_changer.after') !!}

                                    <!-- Total (desktop) -->
                                    <div class="text-right max-md:hidden">
                                        {!! view_render_event('bagisto.shop.checkout.cart.total.before') !!}

                                        <template v-if="displayTax.prices == 'including_tax'">
                                            <p class="text-sm font-bold text-[#332a5e]">@{{ item.formatted_total_incl_tax }}</p>
                                        </template>
                                        <template v-else-if="displayTax.prices == 'both'">
                                            <p class="text-sm font-bold text-[#332a5e]">@{{ item.formatted_total_incl_tax }}</p>
                                            <p class="text-[11px] text-slate-400">excl. @{{ item.formatted_total }}</p>
                                        </template>
                                        <template v-else>
                                            <p class="text-sm font-bold text-[#332a5e]">@{{ item.formatted_total }}</p>
                                        </template>

                                        {!! view_render_event('bagisto.shop.checkout.cart.total.after') !!}
                                    </div>

                                    {!! view_render_event('bagisto.shop.checkout.cart.remove_button.before') !!}

                                    <!-- Delete -->
                                    <button
                                        class="flex h-7 w-7 items-center justify-center rounded-lg text-slate-300 hover:bg-red-50 hover:text-red-500 transition-colors"
                                        @click="removeItem(item.id)"
                                        title="Remove"
                                    >
                                        <span class="icon-bin text-base"></span>
                                    </button>

                                    {!! view_render_event('bagisto.shop.checkout.cart.remove_button.after') !!}
                                </div>

                                {!! view_render_event('bagisto.shop.checkout.cart.item.listing.after') !!}
                            </div>

                            {!! view_render_event('bagisto.shop.checkout.cart.controls.before') !!}

                            <!-- Footer actions -->
                            <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                                {!! view_render_event('bagisto.shop.checkout.cart.continue_shopping.before') !!}

                                <a class="secondary-button" href="{{ route('shop.home.index') }}">
                                    <span class="icon-arrow-left text-sm"></span>
                                    @lang('shop::app.checkout.cart.index.continue-shopping')
                                </a>

                                {!! view_render_event('bagisto.shop.checkout.cart.continue_shopping.after') !!}
                                {!! view_render_event('bagisto.shop.checkout.cart.update_cart.before') !!}

                                <x-shop::button
                                    class="secondary-button"
                                    :title="trans('shop::app.checkout.cart.index.update-cart')"
                                    ::loading="isStoring"
                                    ::disabled="isStoring"
                                    @click="update()"
                                />

                                {!! view_render_event('bagisto.shop.checkout.cart.update_cart.after') !!}
                            </div>

                            {!! view_render_event('bagisto.shop.checkout.cart.controls.after') !!}
                        </div>

                        {!! view_render_event('bagisto.shop.checkout.cart.summary.before') !!}

                        @include('shop::checkout.cart.summary')

                        {!! view_render_event('bagisto.shop.checkout.cart.summary.after') !!}
                    </div>

                    <!-- Empty cart -->
                    <div class="flex flex-col items-center justify-center rounded-2xl border border-slate-200 bg-white py-20 text-center shadow-sm" v-else>
                        <span class="icon-cart mb-4 text-5xl text-slate-200"></span>
                        <p class="mb-1 text-base font-semibold text-slate-700">Your cart is empty</p>
                        <p class="mb-6 text-sm text-slate-400">Browse our store and discover something you love.</p>
                        <a class="primary-button" href="{{ route('shop.home.store') }}">Continue Shopping</a>
                    </div>
                </template>
            </div>
        </script>

        <script type="module">
            app.component("v-cart", {
                template: '#v-cart-template',

                data() {
                    return  {
                        refreshKey: 0,

                        cart: [],

                        allSelected: false,

                        applied: {
                            quantity: {},
                        },

                        displayTax: {
                            prices: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_prices') }}",

                            subtotal: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_subtotal') }}",

                            shipping: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_shipping_amount') }}",
                        },

                        isLoading: true,

                        isStoring: false,
                    };
                },

                mounted() {
                    this.getCart();
                },

                computed: {
                    selectedItemsCount() {
                        return this.cart.items.filter(item => item.selected).length;
                    },
                },

                methods: {
                    getCart() {
                        this.$axios.get('{{ route('shop.api.checkout.cart.index') }}')
                            .then(response => {
                                this.cart = response.data.data;

                                this.isLoading = false;

                                if (response.data.message) {
                                    this.$emitter.emit('add-flash', { type: 'info', message: response.data.message });
                                }
                            })
                            .catch(error => {});
                    },

                    setCart(cart) {
                        this.cart = cart;
                    },

                    selectAll() {
                        for (let item of this.cart.items) {
                            item.selected = this.allSelected;
                        }
                    },

                    updateAllSelected() {
                        this.allSelected = this.cart.items.every(item => item.selected);
                    },

                    update() {
                        this.isStoring = true;

                        this.$axios.put('{{ route('shop.api.checkout.cart.update') }}', { qty: this.applied.quantity })
                            .then(response => {
                                if (response.data.data?.items !== undefined) {
                                    this.cart = response.data.data;

                                    this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                                } else {
                                    /**
                                     * On failure the endpoint returns `{ data: { message } }`
                                     * — the server-thrown reason is inside `data`, not at
                                     * the top level. Read from `data.message` first so the
                                     * flash actually shows (e.g. "inventory-warning").
                                     */
                                    this.$emitter.emit('add-flash', {
                                        type: 'warning',
                                        message: response.data.data?.message || response.data.message,
                                    });
                                }

                                this.isStoring = false;

                                /**
                                 * Bump the key to force the quantity-changers to
                                 * remount from the server's current values. On a
                                 * rejected update the `value` prop stays the same,
                                 * so the component's internal watch never fires
                                 * and the locally-incremented count would stick
                                 * on screen otherwise.
                                 */
                                this.applied.quantity = {};
                                this.refreshKey++;
                            })
                            .catch(error => {
                                this.isStoring = false;

                                this.applied.quantity = {};
                                this.refreshKey++;
                            });
                    },

                    setItemQuantity(itemId, quantity) {
                        this.applied.quantity[itemId] = quantity;
                    },

                    removeItem(itemId) {
                        this.$emitter.emit('open-confirm-modal', {
                            agree: () => {
                                this.$axios.post('{{ route('shop.api.checkout.cart.destroy') }}', {
                                        '_method': 'DELETE',
                                        'cart_item_id': itemId,
                                    })
                                    .then(response => {
                                        this.cart = response.data.data;

                                        this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                    })
                                    .catch(error => {});
                            }
                        });
                    },

                    removeSelectedItems() {
                        this.$emitter.emit('open-confirm-modal', {
                            agree: () => {
                                const selectedItemsIds = this.cart.items.flatMap(item => item.selected ? item.id : []);

                                this.$axios.post('{{ route('shop.api.checkout.cart.destroy_selected') }}', {
                                        '_method': 'DELETE',
                                        'ids': selectedItemsIds,
                                    })
                                    .then(response => {
                                        this.cart = response.data.data;

                                        this.$emitter.emit('update-mini-cart', response.data.data );

                                        this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                    })
                                    .catch(error => {});
                            }
                        });
                    },

                    moveToWishlistSelectedItems() {
                        this.$emitter.emit('open-confirm-modal', {
                            agree: () => {
                                const selectedItemsIds = this.cart.items.flatMap(item => item.selected ? item.id : []);

                                const selectedItemsQty = this.cart.items.filter(item => item.selected).map(item => this.applied.quantity[item.id] ?? item.quantity);

                                this.$axios.post('{{ route('shop.api.checkout.cart.move_to_wishlist') }}', {
                                        'ids': selectedItemsIds,
                                        'qty': selectedItemsQty
                                    })
                                    .then(response => {
                                        this.cart = response.data.data;

                                        this.$emitter.emit('update-mini-cart', response.data.data );

                                        this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                    })
                                    .catch(error => {});
                            }
                        });
                    },
                }
            });
        </script>
    @endpushOnce
</x-shop::layouts>
