@push('meta')
    <meta name="title" content="Shop - Mazzy Automations Smart Automation Products" />
    <meta name="description" content="Browse our full range of smart home and industrial automation devices." />
@endPush

@push('styles')
<style>
    /* ===== LAYOUT ===== */
    .mz-shop-layout {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 28px;
        align-items: start;
    }
    @media (max-width: 991px) {
        .mz-shop-layout { grid-template-columns: 1fr; }
        .mz-shop-sidebar { display: none; }
    }

    /* ===== PRODUCT GRID ===== */
    .mz-prod-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    @media (max-width: 991px) { .mz-prod-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px)  { .mz-prod-grid { grid-template-columns: 1fr; } }

    /* ===== PRODUCT CARDS ===== */
    .mz-product {
        background: #fff; border: 1px solid #e8eaed; border-radius: 10px;
        overflow: hidden; transition: box-shadow .25s, transform .25s;
        height: 100%; display: flex; flex-direction: column;
    }
    .mz-product:hover { box-shadow: 0 8px 28px rgba(16,49,120,.14); transform: translateY(-3px); }
    .mz-product .thumbnail-wrapper { position: relative; overflow: hidden; background: #f7f8fa; }
    .mz-product .thumbnail-wrapper a { display: block; }
    .mz-product .thumbnail-wrapper img { width: 100%; height: 220px; object-fit: cover; transition: transform .4s; display: block; }
    .mz-product:hover .thumbnail-wrapper img { transform: scale(1.06); }
    .mz-product .product-label { position: absolute; top: 10px; left: 10px; z-index: 2; }
    .mz-product .onsale    { background: #e74c3c; color: #fff; font-size: 11px; font-weight: 700; padding: 3px 9px; border-radius: 3px; text-transform: uppercase; }
    .mz-product .badge-new { background: #332a5e; color: #fff; font-size: 11px; font-weight: 700; padding: 3px 9px; border-radius: 3px; }
    .mz-product .product-group-button {
        position: absolute; bottom: -50px; left: 0; right: 0;
        display: flex; align-items: center; justify-content: center; gap: 6px;
        padding: 10px; background: rgba(255,255,255,.92); transition: bottom .3s; z-index: 3;
    }
    .mz-product:hover .product-group-button { bottom: 0; }
    .mz-product .product-group-button button,
    .mz-product .product-group-button a {
        display: inline-flex; align-items: center; justify-content: center;
        width: 36px; height: 36px; border-radius: 50%;
        border: 1px solid #e0e4ee; background: #fff; color: #332a5e;
        font-size: 14px; cursor: pointer; transition: all .2s; text-decoration: none;
    }
    .mz-product .product-group-button button:hover,
    .mz-product .product-group-button a:hover { background: #FF9923; border-color: #FF9923; color: #fff; }
    .mz-product .meta-wrapper   { padding: 14px 16px 6px; flex: 1; }
    .mz-product .product-name   { font-size: 14px; font-weight: 600; color: #1a1a2e; margin: 0 0 8px; line-height: 1.4; }
    .mz-product .product-name a { color: inherit; text-decoration: none; }
    .mz-product .product-name a:hover { color: #332a5e; }
    .mz-product .price     { display: block; font-size: 15px; font-weight: 700; color: #332a5e; margin-bottom: 6px; }
    .mz-product .price del { color: #aaa; font-weight: 400; font-size: 13px; margin-right: 5px; }
    .mz-product .price ins { text-decoration: none; }
    .mz-product .meta-wrapper-2 { padding: 10px 16px 16px; }
    .mz-product .mz-atc-btn {
        display: block; width: 100%; padding: 10px 16px;
        background: #332a5e; color: #fff; border: none; border-radius: 6px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        text-align: center; text-decoration: none; transition: background .2s; font-family: inherit;
    }
    .mz-product .mz-atc-btn:hover    { background: #FF9923; }
    .mz-product .mz-atc-btn:disabled { opacity: .6; cursor: not-allowed; }

    /* ===== SORT BAR ===== */
    .mz-sortbar {
        background: #fff; border: 1px solid #e8eaed; border-radius: 8px;
        padding: 12px 18px; margin-bottom: 20px;
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;
    }
    .mz-result-count { color: #64748b; font-size: 13.5px; }
    .mz-ordering { display: flex; align-items: center; gap: 8px; font-size: 13px; }
    .mz-ordering label { color: #64748b; white-space: nowrap; }
    .mz-ordering select {
        border: 1.5px solid #e2e8f0; border-radius: 6px; padding: 6px 12px;
        font-size: 13px; color: #1e293b; background: #fff; cursor: pointer;
        min-width: 190px; font-family: inherit;
    }

    /* ===== SIDEBAR ===== */
    .mz-cat-sidebar { background: #fff; border: 1px solid #e8eaed; border-radius: 10px; overflow: hidden; margin-bottom: 16px; }
    .mz-cat-sidebar .mz-cat-title {
        background: #332a5e; color: #fff; font-size: 13px; font-weight: 700;
        padding: 13px 18px; letter-spacing: .5px; text-transform: uppercase;
        display: flex; align-items: center; gap: 8px;
    }
    .mz-cat-sidebar ul { list-style: none; margin: 0; padding: 6px 0; }
    .mz-cat-sidebar li a {
        display: flex; align-items: center; justify-content: space-between;
        padding: 9px 18px; font-size: 13.5px; color: #334155; text-decoration: none;
        transition: all .15s; border-left: 3px solid transparent;
    }
    .mz-cat-sidebar li a:hover { background: #f8fafc; color: #332a5e; border-left-color: #332a5e; }
    .mz-cat-sidebar li.active a { color: #332a5e; font-weight: 600; background: #f0f4ff; border-left-color: #332a5e; }

    /* Sidebar search */
    .mz-sidebar-search {
        display: flex; border: 1.5px solid #e2e8f0; border-radius: 8px; overflow: hidden;
        background: #fff; transition: border-color .2s;
    }
    .mz-sidebar-search:focus-within { border-color: #332a5e; }
    .mz-sidebar-search input {
        flex: 1; border: none; outline: none; padding: 9px 14px;
        font-size: 13px; font-family: inherit; background: transparent; color: #1e293b;
    }
    .mz-sidebar-search button {
        background: #332a5e; border: none; color: #fff; padding: 9px 14px;
        cursor: pointer; font-size: 13px; transition: background .2s; font-family: inherit;
    }
    .mz-sidebar-search button:hover { background: #FF9923; }

    /* ===== MISC ===== */
    .mz-section-title { font-size: 19px; font-weight: 700; color: #1e293b; border-bottom: 3px solid #332a5e; display: inline-block; padding-bottom: 4px; margin-bottom: 20px; }
    .mz-skeleton { background: linear-gradient(90deg,#f0f2f5 25%,#e4e7ec 50%,#f0f2f5 75%); background-size: 400% 100%; animation: mz-shimmer 1.4s ease-in-out infinite; border-radius: 8px; }
    @keyframes mz-shimmer { 0%{background-position:100% 50%} 100%{background-position:0% 50%} }
    .mz-loadmore {
        display: inline-block; padding: 11px 44px; border: 2px solid #332a5e;
        color: #332a5e; border-radius: 6px; font-size: 14px; font-weight: 600;
        cursor: pointer; background: #fff; transition: all .2s; font-family: inherit;
    }
    .mz-loadmore:hover    { background: #332a5e; color: #fff; }
    .mz-loadmore:disabled { opacity: .6; cursor: not-allowed; }
    .mz-empty { text-align: center; padding: 60px 20px; }
    .mz-empty i { font-size: 52px; color: #cbd5e1; display: block; margin-bottom: 14px; }
    .mz-empty h4 { color: #64748b; font-size: 16px; margin: 0 0 16px; }

    /* Trust strip */
    .mz-trust-strip { background: #332a5e; padding: 18px 0; }
    .mz-trust-grid  { display: grid; grid-template-columns: repeat(3,1fr); }
    .mz-trust-item  { display: flex; align-items: center; justify-content: center; gap: 12px; color: #fff; font-size: 13.5px; font-weight: 600; padding: 4px 0; }
    .mz-trust-item + .mz-trust-item { border-left: 1px solid rgba(255,255,255,.15); }
    .mz-trust-item i { font-size: 22px; opacity: .85; }
    .mz-trust-item p { margin: 0; font-size: 12px; font-weight: 400; opacity: .8; }
</style>
@endpush

<x-shop::layouts>
    <x-slot:title>Shop - Mazzy Automations</x-slot>

    {{-- Store breadcrumb --}}
    <div class="mz-breadcrumb-banner">
        <div class="mz-bb-inner">
            <h1>Shop</h1>
            <nav>
                <a href="{{ route('shop.home.index') }}">Home</a>
                <span class="sep">/</span>
                <span class="current">Shop</span>
            </nav>
        </div>
    </div>



    {{-- ===== SHOP BODY ===== --}}
    <section style="padding: 50px 0 70px; background: #f7f8fc;">
        <div class="container">

            {{-- Loading placeholder shown before Vue mounts --}}
            <v-mazzy-store>
                <div class="mz-shop-layout">
                    <div class="mz-shop-sidebar">
                        <div class="mz-skeleton" style="height:400px;"></div>
                    </div>
                    <div class="mz-prod-grid">
                        <div class="mz-skeleton" style="height:320px;"></div>
                        <div class="mz-skeleton" style="height:320px;"></div>
                        <div class="mz-skeleton" style="height:320px;"></div>
                        <div class="mz-skeleton" style="height:320px;"></div>
                        <div class="mz-skeleton" style="height:320px;"></div>
                        <div class="mz-skeleton" style="height:320px;"></div>
                    </div>
                </div>
            </v-mazzy-store>

        </div>
    </section>

    @pushOnce('scripts')

    {{-- Vue 3 template for v-mazzy-store --}}
    <script type="text/x-template" id="v-mazzy-store-template">
        <div class="mz-shop-layout">

            {{-- ===== SIDEBAR ===== --}}
            <div class="mz-shop-sidebar">
                <div class="mz-cat-sidebar">
                    <div class="mz-cat-title"><i class="fas fa-th-large" style="margin-right:8px;"></i> All Categories</div>
                    <ul>
                        <li :class="{ active: !activeCategory }">
                            <a href="#" @click.prevent="filterByCategory(null)">All Products</a>
                        </li>
                        <template v-if="catsLoading">
                            <li v-for="n in 8" :key="'cs'+n">
                                <a href="#"><span class="mz-skeleton" style="display:inline-block; width:70%; height:14px; vertical-align:middle;"></span></a>
                            </li>
                        </template>
                        <li v-for="cat in rootCategories" :key="cat.id" :class="{ active: activeCategory === cat.id }">
                            <a :href="cat.slug ? '/store/' + cat.slug : '#'" @click.prevent="filterByCategory(cat.id)">
                                @{{ cat.name }}
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Sidebar search --}}
                <div style="margin-top:16px;">
                    <form @submit.prevent="submitSearch">
                        <div class="mz-sidebar-search">
                            <input type="text" v-model="searchQuery" placeholder="Search products…">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ===== MAIN CONTENT ===== --}}
            <div>

                {{-- Category heading --}}
                <div style="margin-bottom:16px;">
                    <h2 class="mz-section-title" v-if="activeCategoryName">@{{ activeCategoryName }}</h2>
                    <h2 class="mz-section-title" v-else>All Products</h2>
                </div>

                {{-- Sort Bar --}}
                <div class="mz-sortbar">
                    <span class="mz-result-count" v-if="!isLoading">
                        Showing @{{ products.length }}<template v-if="total > products.length"> of @{{ total }}</template> product<template v-if="total !== 1">s</template>
                    </span>
                    <span class="mz-result-count" v-else>Loading&hellip;</span>
                    <div class="mz-ordering">
                        <label style="white-space:nowrap; color:#64748b; margin-right:8px;">Sort by:</label>
                        <select v-model="sort" @change="reload">
                            <option value="latest">Latest</option>
                            <option value="price-asc">Price: Low to High</option>
                            <option value="price-desc">Price: High to Low</option>
                            <option value="name-asc">Name: A–Z</option>
                            <option value="name-desc">Name: Z–A</option>
                        </select>
                    </div>
                </div>

                {{-- Skeleton loading --}}
                <template v-if="isLoading">
                    <div class="mz-prod-grid">
                        <div class="mz-product" style="transform:none; box-shadow:none;" v-for="n in 9" :key="'sk'+n">
                            <div class="mz-skeleton" style="height:220px;"></div>
                            <div style="padding:14px 16px;">
                                <div class="mz-skeleton" style="height:14px; margin-bottom:10px; width:80%;"></div>
                                <div class="mz-skeleton" style="height:12px; width:45%;"></div>
                            </div>
                            <div style="padding:10px 16px 16px;">
                                <div class="mz-skeleton" style="height:38px;"></div>
                            </div>
                        </div>
                    </div>
                </template>

                {{-- Product Grid --}}
                <template v-else-if="products.length">
                    <div class="mz-prod-grid">
                        <div class="mz-product" v-for="(product, idx) in products" :key="product.id">
                            <div class="thumbnail-wrapper">
                                <a :href="productUrl(product)">
                                    <img
                                        :src="product.base_image && product.base_image.medium_image_url ? product.base_image.medium_image_url : defaultImage"
                                        :alt="product.name"
                                        loading="lazy"
                                    >
                                </a>
                                <div class="product-label" v-if="product.on_sale || product.is_new">
                                    <span class="onsale"    v-if="product.on_sale">Sale!</span>
                                    <span class="badge-new" v-else-if="product.is_new">New!</span>
                                </div>
                                <div class="product-group-button">
                                    <button :style="product.is_wishlist ? 'color:#e74c3c' : ''" title="Wishlist" @click="addToWishlist(product)">
                                        <i :class="product.is_wishlist ? 'fas fa-heart' : 'far fa-heart'"></i>
                                    </button>
                                    <button title="Compare" @click="addToCompare(product)">
                                        <i class="far fa-exchange-alt"></i>
                                    </button>
                                    <a :href="productUrl(product)" title="View Product">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="meta-wrapper">
                                <h3 class="product-name">
                                    <a :href="productUrl(product)">@{{ product.name }}</a>
                                </h3>
                                <span class="price" v-html="product.price_html"></span>
                            </div>
                            <div class="meta-wrapper-2">
                                <button class="mz-atc-btn" @click="addToCart(product)" :disabled="addingToCart === product.id">
                                    <span v-if="addingToCart === product.id"><i class="far fa-spinner fa-spin" style="margin-right:4px;"></i> Adding&hellip;</span>
                                    <span v-else-if="!product.is_saleable">Select Options</span>
                                    <span v-else><i class="far fa-cart-plus" style="margin-right:4px;"></i> Add to Cart</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Load More --}}
                    <div style="text-align:center; margin-top:40px;" v-if="nextPage">
                        <button class="mz-loadmore" @click="loadMore" :disabled="loadingMore">
                            <span v-if="loadingMore"><i class="far fa-spinner fa-spin" style="margin-right:6px;"></i>Loading&hellip;</span>
                            <span v-else>Load More Products</span>
                        </button>
                    </div>
                </template>

                {{-- Empty state --}}
                <template v-else>
                    <div class="mz-empty">
                        <i class="far fa-search"></i>
                        <h4>No products found</h4>
                        <button class="mz-loadmore" @click="filterByCategory(null)">View All Products</button>
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
                    /* Show only top-level categories (exclude the root "All" category with no parent) */
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
