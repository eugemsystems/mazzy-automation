@push('meta')
    <meta name="title" content="Shop - Mazzy Automations Smart Automation Products" />
    <meta name="description" content="Browse our full range of smart home and industrial automation devices." />
@endPush

@push('styles')
<style>
    @keyframes mz-shimmer { 0%{background-position:100% 50%} 100%{background-position:0% 50%} }
    .mz-skeleton { background: linear-gradient(90deg,#f0f2f5 25%,#e4e7ec 50%,#f0f2f5 75%); background-size: 400% 100%; animation: mz-shimmer 1.4s ease-in-out infinite; border-radius: 8px; }
    .mz-price del { color: #aaa; font-weight: 400; font-size: 12px; margin-right: 4px; }
    .mz-price ins { text-decoration: none; }
</style>
@endpush

<x-shop::layouts>
    <x-slot:title>Shop - Mazzy Automations</x-slot>

    {{-- Breadcrumb --}}
    <div style="background:#332a5e; padding:28px 0 22px;">
        <div class="container">
            <h1 style="color:#fff; font-size:22px; font-weight:700; margin:0 0 6px;">Shop</h1>
            <nav style="font-size:13px;">
                <a href="{{ route('shop.home.index') }}" style="color:rgba(255,255,255,.7); text-decoration:none;">Home</a>
                <span style="color:rgba(255,255,255,.4); margin:0 8px;">/</span>
                <span style="color:#FF9923;">Shop</span>
            </nav>
        </div>
    </div>

    {{-- Shop Body --}}
    <section class="bg-[#f5f6fb] py-8 max-sm:py-5">
        <div class="container">
            <v-mazzy-store>
                {{-- Pre-mount skeleton --}}
                <div class="flex items-start gap-6 max-md:flex-col">
                    <div class="min-w-[240px] md:max-w-[240px] max-md:hidden">
                        <div class="mz-skeleton h-80 rounded-2xl"></div>
                    </div>
                    <div class="flex-1 grid grid-cols-3 gap-5 max-sm:grid-cols-2 max-sm:gap-3">
                        <div class="mz-skeleton h-72 rounded-xl"></div>
                        <div class="mz-skeleton h-72 rounded-xl"></div>
                        <div class="mz-skeleton h-72 rounded-xl"></div>
                        <div class="mz-skeleton h-72 rounded-xl"></div>
                        <div class="mz-skeleton h-72 rounded-xl"></div>
                        <div class="mz-skeleton h-72 rounded-xl"></div>
                    </div>
                </div>
            </v-mazzy-store>
        </div>
    </section>

    @pushOnce('scripts')

    <script type="text/x-template" id="v-mazzy-store-template">
        <div class="flex items-start gap-6 max-md:flex-col">

            {{-- ===== SIDEBAR ===== --}}
            <aside class="min-w-[240px] md:max-w-[240px] self-start max-md:w-full">

                {{-- Categories --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-4">
                    <div class="bg-[#332a5e] px-4 py-3">
                        <span class="text-[11px] font-bold uppercase tracking-widest text-white">Categories</span>
                    </div>
                    <ul class="list-none m-0 p-0 py-1.5">
                        <li>
                            <a
                                href="#"
                                @click.prevent="filterByCategory(null)"
                                class="flex items-center justify-between px-4 py-2.5 text-sm transition-colors hover:bg-[#f5f6fb] border-l-2"
                                :class="!activeCategory ? 'text-[#332a5e] font-semibold border-[#332a5e] bg-[#f5f6fb]' : 'text-gray-600 border-transparent'"
                            >
                                All Products
                            </a>
                        </li>
                        <template v-if="catsLoading">
                            <li v-for="n in 6" :key="'cs'+n" class="px-4 py-3">
                                <span class="mz-skeleton block h-3 w-3/4 rounded"></span>
                            </li>
                        </template>
                        <li v-for="cat in rootCategories" :key="cat.id">
                            <a
                                href="#"
                                @click.prevent="filterByCategory(cat.id)"
                                class="flex items-center justify-between px-4 py-2.5 text-sm transition-colors hover:bg-[#f5f6fb] border-l-2"
                                :class="activeCategory === cat.id ? 'text-[#332a5e] font-semibold border-[#332a5e] bg-[#f5f6fb]' : 'text-gray-600 border-transparent'"
                            >
                                @{{ cat.name }}
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Search --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-3">
                    <form @submit.prevent="submitSearch">
                        <div class="flex items-center rounded-lg border border-gray-200 overflow-hidden transition-colors focus-within:border-[#332a5e]">
                            <input
                                type="text"
                                v-model="searchQuery"
                                placeholder="Search products…"
                                class="flex-1 text-sm px-3 py-2.5 outline-none border-none bg-transparent text-gray-700 placeholder:text-gray-400"
                            >
                            <button type="submit" class="bg-[#332a5e] hover:bg-[#FF9923] text-white px-3.5 py-2.5 transition-colors flex-shrink-0">
                                <span class="icon-search text-base leading-none"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </aside>

            {{-- ===== MAIN CONTENT ===== --}}
            <div class="flex-1 min-w-0">

                {{-- Toolbar --}}
                <div class="flex items-center justify-between gap-4 bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-3 mb-5 max-sm:px-3 max-sm:py-2.5">
                    <div>
                        <h2 class="text-sm font-bold text-gray-900 m-0 leading-tight" v-if="activeCategoryName">@{{ activeCategoryName }}</h2>
                        <h2 class="text-sm font-bold text-gray-900 m-0 leading-tight" v-else>All Products</h2>
                        <p class="text-xs text-gray-400 m-0 mt-0.5" v-if="!isLoading">@{{ total }} product<template v-if="total !== 1">s</template></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-400 max-sm:hidden">Sort:</span>
                        <select
                            v-model="sort"
                            @change="reload"
                            class="text-sm border border-[#332a5e]/20 bg-[#f5f6fb] rounded-lg px-3 py-2 text-gray-700 cursor-pointer outline-none transition-colors focus:border-[#332a5e]"
                        >
                            <option value="latest">Latest</option>
                            <option value="price-asc">Price: Low → High</option>
                            <option value="price-desc">Price: High → Low</option>
                            <option value="name-asc">Name: A–Z</option>
                            <option value="name-desc">Name: Z–A</option>
                        </select>
                    </div>
                </div>

                {{-- Skeleton --}}
                <template v-if="isLoading">
                    <div class="grid grid-cols-3 gap-5 max-1060:grid-cols-2 max-sm:grid-cols-2 max-sm:gap-3">
                        <div v-for="n in 9" :key="'sk'+n" class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                            <div class="mz-skeleton aspect-square"></div>
                            <div class="p-3.5">
                                <div class="mz-skeleton h-3.5 w-4/5 rounded mb-2.5"></div>
                                <div class="mz-skeleton h-3 w-2/5 rounded mb-4"></div>
                                <div class="mz-skeleton h-9 w-full rounded-lg"></div>
                            </div>
                        </div>
                    </div>
                </template>

                {{-- Product Grid --}}
                <template v-else-if="products.length">
                    <div class="grid grid-cols-3 gap-5 max-1060:grid-cols-2 max-sm:grid-cols-2 max-sm:gap-3">
                        <div
                            class="group flex flex-col bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 overflow-hidden"
                            v-for="(product, idx) in products"
                            :key="product.id"
                        >
                            {{-- Image --}}
                            <div class="relative overflow-hidden bg-[#f5f6fb]">
                                <a :href="productUrl(product)" class="block aspect-square overflow-hidden">
                                    <img
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                        :src="product.base_image && product.base_image.medium_image_url ? product.base_image.medium_image_url : defaultImage"
                                        :alt="product.name"
                                        loading="lazy"
                                    >
                                </a>
                                {{-- Sale / New badges --}}
                                <div class="absolute top-2 left-2 flex flex-col gap-1" v-if="product.on_sale || product.is_new">
                                    <span v-if="product.on_sale" class="text-[10px] font-bold uppercase tracking-wide bg-red-500 text-white px-2 py-0.5 rounded-full leading-tight">Sale</span>
                                    <span v-else-if="product.is_new" class="text-[10px] font-bold uppercase tracking-wide bg-[#332a5e] text-white px-2 py-0.5 rounded-full leading-tight">New</span>
                                </div>
                                {{-- Wishlist button --}}
                                <button
                                    class="absolute top-2 right-2 w-8 h-8 bg-white rounded-full shadow-sm flex items-center justify-center opacity-0 group-hover:opacity-100 max-lg:opacity-100 transition-opacity hover:bg-red-50"
                                    :class="product.is_wishlist ? 'text-red-500' : 'text-gray-400'"
                                    @click="addToWishlist(product)"
                                    title="Wishlist"
                                >
                                    <span :class="product.is_wishlist ? 'icon-heart-fill' : 'icon-heart'" class="text-sm leading-none"></span>
                                </button>
                            </div>

                            {{-- Info --}}
                            <div class="flex flex-col flex-1 p-3.5 gap-1.5">
                                <a
                                    :href="productUrl(product)"
                                    class="block text-sm font-semibold text-gray-900 line-clamp-2 hover:text-[#332a5e] transition-colors leading-snug"
                                    style="min-height:2.6rem"
                                >@{{ product.name }}</a>

                                <div class="text-base font-bold text-[#332a5e] mz-price" v-html="product.price_html"></div>

                                <div class="mt-auto pt-2.5 flex items-center gap-2">
                                    <button
                                        class="flex-1 bg-[#332a5e] hover:bg-[#FF9923] text-white text-xs font-semibold py-2.5 px-3 rounded-lg transition-colors flex items-center justify-center gap-1.5 disabled:opacity-60 disabled:cursor-not-allowed"
                                        @click="addToCart(product)"
                                        :disabled="addingToCart === product.id"
                                    >
                                        <span v-if="addingToCart === product.id" class="icon-loader animate-spin text-sm leading-none"></span>
                                        <span v-else class="icon-cart text-sm leading-none"></span>
                                        <span v-if="addingToCart === product.id">Adding…</span>
                                        <span v-else-if="!product.is_saleable">Options</span>
                                        <span v-else>Add to Cart</span>
                                    </button>
                                    <button
                                        class="flex-shrink-0 w-9 h-9 border border-gray-200 hover:border-[#332a5e] hover:text-[#332a5e] rounded-lg flex items-center justify-center text-gray-400 transition-colors"
                                        @click="addToCompare(product)"
                                        title="Compare"
                                    >
                                        <span class="icon-compare text-sm leading-none"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Load More --}}
                    <div class="text-center mt-10" v-if="nextPage">
                        <button
                            class="inline-flex items-center gap-2 px-8 py-3 border-2 border-[#332a5e] text-[#332a5e] font-semibold text-sm rounded-lg hover:bg-[#332a5e] hover:text-white transition-colors disabled:opacity-60 disabled:cursor-not-allowed"
                            @click="loadMore"
                            :disabled="loadingMore"
                        >
                            <span v-if="loadingMore" class="icon-loader animate-spin text-base leading-none"></span>
                            <span>@{{ loadingMore ? 'Loading…' : 'Load More Products' }}</span>
                        </button>
                    </div>
                </template>

                {{-- Empty state --}}
                <template v-else>
                    <div class="text-center py-20">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-white border border-gray-100 shadow-sm flex items-center justify-center">
                            <span class="icon-search text-3xl text-gray-300 leading-none"></span>
                        </div>
                        <p class="text-gray-500 text-sm mb-5">No products found</p>
                        <button
                            class="px-6 py-2.5 border border-[#332a5e] text-[#332a5e] text-sm font-semibold rounded-lg hover:bg-[#332a5e] hover:text-white transition-colors"
                            @click="filterByCategory(null)"
                        >View All Products</button>
                    </div>
                </template>

            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-mazzy-store', {
            template: '#v-mazzy-store-template',

            data() {
                return {
                    isLoading:      true,
                    loadingMore:    false,
                    addingToCart:   null,
                    sort:           'latest',
                    searchQuery:    '',
                    products:       [],
                    total:          0,
                    nextPage:       null,
                    categories:     [],
                    catsLoading:    true,
                    activeCategory: null,
                    isCustomer:     {{ auth()->guard('customer')->check() ? 'true' : 'false' }},
                    defaultImage:   '{{ asset('themes/shop/konta/img/bg/breadcumb-bg.jpg') }}',
                };
            },

            computed: {
                rootCategories() {
                    return this.categories.filter(c => c.parent_id !== null && c.parent_id > 1);
                },
                activeCategoryName() {
                    if (!this.activeCategory) return null;
                    const cat = this.categories.find(c => c.id === this.activeCategory);
                    return cat ? cat.name : null;
                },
            },

            mounted() {
                this.loadCategories();
                this.getProducts();
            },

            methods: {
                productUrl(product) {
                    return '{{ url('/store') }}/' + product.url_key;
                },

                loadCategories() {
                    this.catsLoading = true;
                    this.$axios.get('{{ route('shop.api.categories.index') }}', {
                        params: { status: 1, limit: 100 }
                    })
                    .then(res => {
                        this.catsLoading = false;
                        this.categories  = res.data.data || [];
                    })
                    .catch(() => { this.catsLoading = false; });
                },

                reload() {
                    this.products  = [];
                    this.nextPage  = null;
                    this.getProducts();
                },

                filterByCategory(catId) {
                    this.activeCategory = catId;
                    this.reload();
                },

                submitSearch() {
                    this.reload();
                },

                getProducts() {
                    this.isLoading = true;
                    const params = { sort: this.sort, limit: 24 };
                    if (this.activeCategory) params.category_id = this.activeCategory;
                    if (this.searchQuery.trim()) params.query = this.searchQuery.trim();

                    this.$axios.get('{{ route('shop.api.products.index') }}', { params })
                    .then(res => {
                        this.isLoading = false;
                        this.products  = res.data.data || [];
                        this.total     = res.data.meta?.total ?? this.products.length;
                        this.nextPage  = res.data.links?.next ?? null;
                    })
                    .catch(() => { this.isLoading = false; });
                },

                loadMore() {
                    if (!this.nextPage) return;
                    this.loadingMore = true;
                    this.$axios.get(this.nextPage)
                    .then(res => {
                        this.loadingMore = false;
                        this.products    = [...this.products, ...(res.data.data || [])];
                        this.nextPage    = res.data.links?.next ?? null;
                    })
                    .catch(() => { this.loadingMore = false; });
                },

                addToCart(product) {
                    if (!product.is_saleable) {
                        window.location.href = this.productUrl(product);
                        return;
                    }
                    this.addingToCart = product.id;
                    this.$axios.post('{{ route('shop.api.checkout.cart.store') }}', {
                        quantity: 1, product_id: product.id,
                    })
                    .then(res => {
                        this.addingToCart = null;
                        if (res.data.message) {
                            this.$emitter.emit('update-mini-cart', res.data.data);
                            this.$emitter.emit('add-flash', { type: 'success', message: res.data.message });
                        } else {
                            this.$emitter.emit('add-flash', { type: 'warning', message: res.data.data?.message });
                        }
                    })
                    .catch(err => {
                        this.addingToCart = null;
                        const data = err.response?.data;
                        if (data?.redirect_uri) {
                            window.location.href = data.redirect_uri;
                        } else {
                            this.$emitter.emit('add-flash', { type: 'error', message: data?.message ?? 'Could not add to cart.' });
                        }
                    });
                },

                addToWishlist(product) {
                    if (!this.isCustomer) {
                        window.location.href = '{{ route('shop.customer.session.index') }}';
                        return;
                    }
                    this.$axios.post('{{ route('shop.api.customers.account.wishlist.store') }}', { product_id: product.id })
                    .then(res => {
                        product.is_wishlist = !product.is_wishlist;
                        this.$emitter.emit('add-flash', { type: 'success', message: res.data.data.message });
                    })
                    .catch(() => {});
                },

                addToCompare(product) {
                    if (this.isCustomer) {
                        this.$axios.post('{{ route('shop.api.compare.store') }}', { product_id: product.id })
                        .then(res => {
                            this.$emitter.emit('add-flash', { type: 'success', message: res.data.data.message });
                        })
                        .catch(() => {});
                    } else {
                        let items = JSON.parse(localStorage.getItem('compare_items') || '[]');
                        if (!items.includes(product.id)) {
                            items.push(product.id);
                            localStorage.setItem('compare_items', JSON.stringify(items));
                        }
                        this.$emitter.emit('add-flash', { type: 'success', message: 'Product added to compare list.' });
                    }
                },
            },
        });
    </script>
    @endPushOnce

</x-shop::layouts>
