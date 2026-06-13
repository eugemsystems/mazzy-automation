<v-product-card
    {{ $attributes }}
    :product="product"
>
</v-product-card>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-product-card-template"
    >
        <!-- ═══ GRID CARD ═══ -->
        <div
            class="group flex flex-col w-full bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 overflow-hidden"
            v-if="mode != 'list'"
        >
            <!-- Image -->
            <div class="relative overflow-hidden bg-[#f5f6fb]">
                {!! view_render_event('bagisto.shop.components.products.card.image.before') !!}

                <a
                    :href="'{{ route('shop.product_or_category.index', ':slug') }}'.replace(':slug', product.url_key)"
                    :aria-label="product.name"
                    class="block"
                >
                    <x-shop::media.images.lazy
                        class="after:content-[' '] relative bg-[#f5f6fb] after:block after:pb-[100%] transition-transform duration-500 group-hover:scale-105"
                        ::src="product.base_image.medium_image_url"
                        ::srcset="`${product.base_image.small_image_url} 150w, ${product.base_image.medium_image_url} 300w,`"
                        sizes="(max-width: 768px) 150px, 300px"
                        ::key="product.id"
                        ::index="product.id"
                        width="291"
                        height="291"
                        ::alt="product.name"
                    />
                </a>

                {!! view_render_event('bagisto.shop.components.products.card.image.after') !!}

                <!-- Sale / New badge -->
                <div class="absolute top-2.5 ltr:left-2.5 rtl:right-2.5 z-10 flex flex-col gap-1">
                    <span class="inline-block bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide" v-if="product.on_sale">
                        @lang('shop::app.components.products.card.sale')
                    </span>
                    <span class="inline-block bg-[#332a5e] text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide" v-else-if="product.is_new">
                        @lang('shop::app.components.products.card.new')
                    </span>
                </div>

                <!-- Wishlist icon -->
                @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))
                    {!! view_render_event('bagisto.shop.components.products.card.wishlist_option.before') !!}
                    <span
                        class="absolute top-2.5 ltr:right-2.5 rtl:left-2.5 z-10 flex h-8 w-8 items-center justify-center rounded-full bg-white shadow-sm text-base cursor-pointer opacity-0 group-hover:opacity-100 max-lg:opacity-100 transition-opacity"
                        role="button"
                        aria-label="@lang('shop::app.components.products.card.add-to-wishlist')"
                        tabindex="0"
                        :class="product.is_wishlist ? 'icon-heart-fill text-red-500' : 'icon-heart text-gray-400'"
                        @click="addToWishlist()"
                    ></span>
                    {!! view_render_event('bagisto.shop.components.products.card.wishlist_option.after') !!}
                @endif

                <!-- Ratings overlay -->
                {!! view_render_event('bagisto.shop.components.products.card.average_ratings.before') !!}
                @if (core()->getConfigData('catalog.products.review.summary') == 'star_counts')
                    <x-shop::products.ratings
                        class="absolute bottom-2 items-center !border-white bg-white/90 !px-2 !py-0.5 text-xs ltr:left-2 rtl:right-2"
                        ::average="product.ratings.average"
                        ::total="product.ratings.total"
                        ::rating="false"
                        v-if="product.ratings.total"
                    />
                @else
                    <x-shop::products.ratings
                        class="absolute bottom-2 items-center !border-white bg-white/90 !px-2 !py-0.5 text-xs ltr:left-2 rtl:right-2"
                        ::average="product.ratings.average"
                        ::total="product.reviews.total"
                        ::rating="false"
                        v-if="product.reviews.total"
                    />
                @endif
                {!! view_render_event('bagisto.shop.components.products.card.average_ratings.after') !!}
            </div>

            <!-- Info -->
            <div class="flex flex-col flex-1 p-3.5 gap-1.5">
                {!! view_render_event('bagisto.shop.components.products.card.name.before') !!}
                <a
                    :href="'{{ route('shop.product_or_category.index', ':slug') }}'.replace(':slug', product.url_key)"
                    class="block text-sm font-semibold text-gray-900 leading-snug line-clamp-2 hover:text-[#332a5e] transition-colors"
                    style="min-height:2.6rem"
                >@{{ product.name }}</a>
                {!! view_render_event('bagisto.shop.components.products.card.name.after') !!}

                {!! view_render_event('bagisto.shop.components.products.card.price.before') !!}
                <div class="flex flex-wrap items-center gap-x-1.5 text-base font-bold text-[#332a5e] max-sm:text-sm" v-html="product.price_html"></div>
                {!! view_render_event('bagisto.shop.components.products.card.price.after') !!}

                <!-- Actions row — always visible -->
                <div class="mt-auto pt-3 flex items-center gap-2">
                    @if (core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                        {!! view_render_event('bagisto.shop.components.products.card.add_to_cart.before') !!}
                        <button
                            class="flex-1 bg-[#332a5e] text-white text-xs font-semibold py-2.5 px-3 rounded-lg hover:bg-[#FF9923] transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="! product.is_saleable || isAddingToCart"
                            @click="addToCart()"
                        >@lang('shop::app.components.products.card.add-to-cart')</button>
                        {!! view_render_event('bagisto.shop.components.products.card.add_to_cart.after') !!}
                    @endif

                    @if (core()->getConfigData('catalog.products.settings.compare_option'))
                        {!! view_render_event('bagisto.shop.components.products.card.compare_option.before') !!}
                        <span
                            class="icon-compare flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-gray-200 text-gray-400 hover:border-[#332a5e] hover:text-[#332a5e] cursor-pointer transition-all text-base"
                            role="button"
                            aria-label="@lang('shop::app.components.products.card.add-to-compare')"
                            tabindex="0"
                            @click="addToCompare(product.id)"
                        ></span>
                        {!! view_render_event('bagisto.shop.components.products.card.compare_option.after') !!}
                    @endif
                </div>
            </div>
        </div>

        <!-- ═══ LIST CARD ═══ -->
        <div
            class="group flex gap-0 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden max-sm:flex-col"
            v-else
        >
            <!-- Image -->
            <div class="relative shrink-0 w-[200px] max-sm:w-full overflow-hidden bg-[#f5f6fb]">
                {!! view_render_event('bagisto.shop.components.products.card.image.before') !!}
                <a :href="'{{ route('shop.product_or_category.index', ':slug') }}'.replace(':slug', product.url_key)" class="block">
                    <x-shop::media.images.lazy
                        class="after:content-[' '] relative bg-[#f5f6fb] after:block after:pb-[100%] transition-transform duration-500 group-hover:scale-105"
                        ::src="product.base_image.medium_image_url"
                        ::key="product.id"
                        ::index="product.id"
                        width="200"
                        height="200"
                        ::alt="product.name"
                    />
                </a>
                {!! view_render_event('bagisto.shop.components.products.card.image.after') !!}

                <div class="absolute top-2.5 ltr:left-2.5 rtl:right-2.5 flex flex-col gap-1">
                    <span class="inline-block bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase" v-if="product.on_sale">@lang('shop::app.components.products.card.sale')</span>
                    <span class="inline-block bg-[#332a5e] text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase" v-else-if="product.is_new">@lang('shop::app.components.products.card.new')</span>
                </div>
            </div>

            <!-- Info -->
            <div class="flex flex-col gap-2.5 flex-1 p-5 max-sm:p-4">
                {!! view_render_event('bagisto.shop.components.products.card.name.before') !!}
                <a
                    :href="'{{ route('shop.product_or_category.index', ':slug') }}'.replace(':slug', product.url_key)"
                    class="text-base font-semibold text-gray-900 leading-snug hover:text-[#332a5e] transition-colors"
                >@{{ product.name }}</a>
                {!! view_render_event('bagisto.shop.components.products.card.name.after') !!}

                {!! view_render_event('bagisto.shop.components.products.card.price.before') !!}
                <div class="flex flex-wrap items-center gap-x-2 text-xl font-bold text-[#332a5e]" v-html="product.price_html"></div>
                {!! view_render_event('bagisto.shop.components.products.card.price.after') !!}

                {!! view_render_event('bagisto.shop.components.products.card.average_ratings.before') !!}
                <template v-if="product.ratings.total">
                    @if (core()->getConfigData('catalog.products.review.summary') == 'star_counts')
                        <x-shop::products.ratings ::average="product.ratings.average" ::total="product.ratings.total" ::rating="false" />
                    @else
                        <x-shop::products.ratings ::average="product.ratings.average" ::total="product.reviews.total" ::rating="false" />
                    @endif
                </template>
                {!! view_render_event('bagisto.shop.components.products.card.average_ratings.after') !!}

                <div class="mt-auto pt-1 flex items-center gap-3">
                    @if (core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                        {!! view_render_event('bagisto.shop.components.products.card.add_to_cart.before') !!}
                        <button
                            class="bg-[#332a5e] text-white text-sm font-semibold py-2.5 px-6 rounded-lg hover:bg-[#FF9923] transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="! product.is_saleable || isAddingToCart"
                            @click="addToCart()"
                        >@lang('shop::app.components.products.card.add-to-cart')</button>
                        {!! view_render_event('bagisto.shop.components.products.card.add_to_cart.after') !!}
                    @endif

                    @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))
                        {!! view_render_event('bagisto.shop.components.products.card.wishlist_option.before') !!}
                        <span
                            class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 text-base cursor-pointer hover:border-red-400 hover:text-red-400 transition-all"
                            role="button"
                            aria-label="@lang('shop::app.components.products.card.add-to-wishlist')"
                            tabindex="0"
                            :class="product.is_wishlist ? 'icon-heart-fill text-red-500 border-red-300' : 'icon-heart text-gray-400'"
                            @click="addToWishlist()"
                        ></span>
                        {!! view_render_event('bagisto.shop.components.products.card.wishlist_option.after') !!}
                    @endif

                    @if (core()->getConfigData('catalog.products.settings.compare_option'))
                        {!! view_render_event('bagisto.shop.components.products.card.compare_option.before') !!}
                        <span
                            class="icon-compare flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 text-gray-400 hover:border-[#332a5e] hover:text-[#332a5e] cursor-pointer transition-all text-base"
                            role="button"
                            aria-label="@lang('shop::app.components.products.card.add-to-compare')"
                            tabindex="0"
                            @click="addToCompare(product.id)"
                        ></span>
                        {!! view_render_event('bagisto.shop.components.products.card.compare_option.after') !!}
                    @endif
                </div>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-product-card', {
            template: '#v-product-card-template',

            props: ['mode', 'product'],

            data() {
                return {
                    isCustomer: '{{ auth()->guard('customer')->check() }}',

                    isAddingToCart: false,
                }
            },

            methods: {
                addToWishlist() {
                    if (this.isCustomer) {
                        this.$axios.post(`{{ route('shop.api.customers.account.wishlist.store') }}`, {
                                product_id: this.product.id
                            })
                            .then(response => {
                                this.product.is_wishlist = ! this.product.is_wishlist;

                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.data.message });
                            })
                            .catch(error => {});
                        } else {
                            window.location.href = "{{ route('shop.customer.session.index')}}";
                        }
                },

                addToCompare(productId) {
                    /**
                     * This will handle for customers.
                     */
                    if (this.isCustomer) {
                        this.$axios.post('{{ route("shop.api.compare.store") }}', {
                                'product_id': productId
                            })
                            .then(response => {
                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.data.message });
                            })
                            .catch(error => {
                                if ([400, 422].includes(error.response.status)) {
                                    this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.data.message });

                                    return;
                                }

                                this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message});
                            });

                        return;
                    }

                    /**
                     * This will handle for guests.
                     */
                    let items = this.getStorageValue() ?? [];

                    if (items.length) {
                        if (! items.includes(productId)) {
                            items.push(productId);

                            localStorage.setItem('compare_items', JSON.stringify(items));

                            this.$emitter.emit('add-flash', { type: 'success', message: "@lang('shop::app.components.products.card.add-to-compare-success')" });
                        } else {
                            this.$emitter.emit('add-flash', { type: 'warning', message: "@lang('shop::app.components.products.card.already-in-compare')" });
                        }
                    } else {
                        localStorage.setItem('compare_items', JSON.stringify([productId]));

                        this.$emitter.emit('add-flash', { type: 'success', message: "@lang('shop::app.components.products.card.add-to-compare-success')" });

                    }
                },

                getStorageValue(key) {
                    let value = localStorage.getItem('compare_items');

                    if (! value) {
                        return [];
                    }

                    return JSON.parse(value);
                },

                addToCart() {
                    this.isAddingToCart = true;

                    this.$axios.post('{{ route("shop.api.checkout.cart.store") }}', {
                            'quantity': 1,
                            'product_id': this.product.id,
                        })
                        .then(response => {
                            if (response.data.message) {
                                this.$emitter.emit('update-mini-cart', response.data.data );

                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                            } else {
                                this.$emitter.emit('add-flash', { type: 'warning', message: response.data.data.message });
                            }

                            this.isAddingToCart = false;
                        })
                        .catch(error => {
                            this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });

                            if (error.response.data.redirect_uri) {
                                window.location.href = error.response.data.redirect_uri;
                            }

                            this.isAddingToCart = false;
                        });
                },
            },
        });
    </script>
@endpushOnce
