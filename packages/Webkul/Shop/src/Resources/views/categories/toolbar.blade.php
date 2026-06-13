{!! view_render_event('bagisto.shop.categories.view.toolbar.before') !!}

<v-toolbar @filter-applied='setFilters("toolbar", $event)'></v-toolbar>

{!! view_render_event('bagisto.shop.categories.view.toolbar.after') !!}

@inject('toolbar' , 'Webkul\Product\Helpers\Toolbar')

@pushOnce('scripts')
    <script
        type="text/x-template"
        id='v-toolbar-template'
    >
        <div>
            <!-- Desktop Toolbar -->
            <div class="flex justify-between items-center max-md:hidden bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-3 mb-5">
                {!! view_render_event('bagisto.shop.categories.toolbar.filter.before') !!}

                <!-- Product Sorting Filters -->
                <x-shop::dropdown
                    class="z-[1]"
                    position="bottom-left"
                >
                    <x-slot:toggle>
                        <!-- Dropdown Toggler -->
                        <button class="flex w-full max-w-[220px] cursor-pointer items-center justify-between gap-3 rounded-lg border border-[#332a5e]/20 bg-[#f5f6fb] px-4 py-2.5 text-sm font-medium text-gray-700 transition-all hover:border-[#332a5e]/50 max-md:w-[110px] max-md:border-0 max-md:pl-2.5 max-md:pr-2.5">
                            @{{ sortLabel ?? "@lang('shop::app.products.sort-by.title')" }}

                            <span
                                class="icon-arrow-down text-2xl"
                                role="presentation"
                            ></span>
                        </button>
                    </x-slot>

                    <!-- Dropdown Content -->
                    <x-slot:menu>
                        <x-shop::dropdown.menu.item
                            v-for="(sort, key) in filters.available.sort"
                            ::class="{'bg-gray-100': sort.value == filters.applied.sort}"
                            @click="apply('sort', sort.value)"
                        >
                            @{{ sort.title }}
                        </x-shop::dropdown.menu.item>
                    </x-slot>
                </x-shop::dropdown>

                {!! view_render_event('bagisto.shop.categories.toolbar.filter.after') !!}

                {!! view_render_event('bagisto.shop.categories.toolbar.pagination.before') !!}

                <!-- Product Pagination Limit -->
                <div class="flex items-center gap-4">
                    <!-- Product Pagination Limit -->
                    <x-shop::dropdown position="bottom-right">
                        <x-slot:toggle>
                            <!-- Dropdown Toggler -->
                            <button class="flex w-full max-w-[120px] cursor-pointer items-center justify-between gap-3 rounded-lg border border-[#332a5e]/20 bg-[#f5f6fb] px-4 py-2.5 text-sm font-medium text-gray-700 transition-all hover:border-[#332a5e]/50 max-md:w-[110px] max-md:border-0 max-md:pl-2.5 max-md:pr-2.5">
                                @{{ filters.applied.limit ?? "@lang('shop::app.categories.toolbar.show')" }}

                                <span
                                    class="icon-arrow-down text-2xl"
                                    role="presentation"
                                ></span>
                            </button>
                        </x-slot>

                        <!-- Dropdown Content -->
                        <x-slot:menu>
                            <x-shop::dropdown.menu.item
                                v-for="(limit, key) in filters.available.limit"
                                ::class="{'bg-gray-100': limit == filters.applied.limit}"
                                @click="apply('limit', limit)"
                            >
                                @{{ limit }}
                            </x-shop::dropdown.menu.item>
                        </x-slot>
                    </x-shop::dropdown>

                    <!-- Listing Mode Switcher -->
                    <div class="flex items-center gap-1 rounded-lg border border-[#332a5e]/20 bg-[#f5f6fb] p-1">
                        <span
                            class="cursor-pointer text-xl p-1.5 rounded-md transition-all"
                            role="button"
                            aria-label="@lang('shop::app.categories.toolbar.list')"
                            tabindex="0"
                            :class="(filters.applied.mode === 'list') ? 'icon-listing-fill bg-[#332a5e] text-white shadow-sm' : 'icon-listing text-gray-400 hover:text-[#332a5e]'"
                            @click="changeMode('list')"
                        >
                        </span>

                        <span
                            class="cursor-pointer text-xl p-1.5 rounded-md transition-all"
                            role="button"
                            aria-label="@lang('shop::app.categories.toolbar.grid')"
                            tabindex="0"
                            :class="(filters.applied.mode === 'grid') ? 'icon-grid-view-fill bg-[#332a5e] text-white shadow-sm' : 'icon-grid-view text-gray-400 hover:text-[#332a5e]'"
                            @click="changeMode('grid')"
                        >
                        </span>
                    </div>
                </div>

                {!! view_render_event('bagisto.shop.categories.toolbar.pagination.after') !!}
            </div>

            <!-- Mobile Toolbar -->
            <div class="md:hidden">
                <ul class="list-none m-0 p-0">
                    <li
                        class="px-4 py-3 text-sm border-b border-gray-100 last:border-0 cursor-pointer transition-colors"
                        :class="sort.value == filters.applied.sort ? 'bg-[#f5f6fb] text-[#332a5e] font-semibold' : 'text-gray-700'"
                        v-for="(sort, key) in filters.available.sort"
                        @click="apply('sort', sort.value)"
                    >
                        @{{ sort.title }}
                    </li>
                </ul>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-toolbar', {
            template: '#v-toolbar-template',

            data() {
                return {
                    filters: {
                        available: {
                            sort: @json($toolbar->getAvailableOrders()),

                            limit: @json($toolbar->getAvailableLimits()),

                            mode: @json($toolbar->getAvailableModes()),
                        },

                        default: {
                            sort: '{{ $toolbar->getOrder([])['value'] }}',

                            limit: '{{ $toolbar->getLimit([]) }}',

                            mode: '{{ $toolbar->getMode([]) }}',
                        },

                        applied: {
                            sort: '{{ $toolbar->getOrder($params ?? [])['value'] }}',

                            limit: '{{ $toolbar->getLimit($params ?? []) }}',

                            mode: '{{ $toolbar->getMode($params ?? []) }}',
                        }
                    }
                };
            },

            created() {
                let queryParams = new URLSearchParams(window.location.search);

                queryParams.forEach((value, filter) => {
                    if (['sort', 'limit', 'mode'].includes(filter)) {
                        this.filters.applied[filter] = value;
                    }
                });
            },

            mounted() {
                this.setFilters();
            },

            computed: {
                sortLabel() {
                    return this.filters.available.sort.find(sort => sort.value === this.filters.applied.sort).title;
                }
            },

            methods: {
                apply(type, value) {
                    this.filters.applied[type] = value;

                    this.setFilters();
                },

                changeMode(value = 'grid') {
                    this.filters.applied['mode'] = value;

                    this.setFilters();
                },

                setFilters() {
                    let filters = {};

                    for (let key in this.filters.applied) {
                        if (this.filters.applied[key] != this.filters.default[key]) {
                            filters[key] = this.filters.applied[key];
                        }
                    }

                    this.$emit('filter-applied', {
                        default: this.filters.default,
                        applied: filters,
                    });
                }
            },
        });
    </script>
@endPushOnce
