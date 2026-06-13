<v-datagrid-search
    :is-loading="isLoading"
    :available="available"
    :applied="applied"
    @search="search"
>
    {{ $slot }}
</v-datagrid-search>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-datagrid-search-template"
    >
        <slot
            name="search"
            :available="available"
            :applied="applied"
            :search="search"
            :get-searched-values="getSearchedValues"
        >
            <template v-if="isLoading">
                <x-shop::shimmer.datagrid.toolbar.search />
            </template>

            <template v-else>
                <div class="flex w-full items-center gap-x-3">
                    <!-- Search Panel -->
                    <div class="relative w-full max-w-[320px] max-md:max-w-[250px]">
                        <span class="icon-search pointer-events-none absolute top-1/2 -translate-y-1/2 text-base text-slate-400 ltr:left-3 rtl:right-3"></span>

                        <input
                            type="text"
                            name="search"
                            :value="getSearchedValues('all')"
                            class="h-auto w-full rounded-lg border border-slate-200 bg-white py-2.5 text-sm text-slate-700 shadow-sm transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#332a5e] focus:outline-none focus:ring-4 focus:ring-[#332a5e]/10 ltr:pl-9 ltr:pr-3 rtl:pr-9 rtl:pl-3"
                            placeholder="@lang('shop::app.components.datagrid.toolbar.search.title')"
                            autocomplete="off"
                            @keyup.enter="search"
                        >
                    </div>

                    <!-- Information Panel -->
                    <div class="max-md:hidden">
                        <p class="whitespace-nowrap text-sm text-slate-500">
                            @{{ "@lang('shop::app.components.datagrid.toolbar.results')".replace(':total', available.meta.total) }}
                        </p>
                    </div>
                </div>
            </template>
        </slot>
    </script>

    <script type="module">
        app.component('v-datagrid-search', {
            template: '#v-datagrid-search-template',

            props: ['isLoading', 'available', 'applied'],

            emits: ['search'],

            data() {
                return {
                    filters: {
                        columns: [],
                    },
                };
            },

            mounted() {
                this.filters.columns = this.applied.filters.columns.filter((column) => column.index === 'all');
            },

            methods: {
                /**
                 * Perform a search operation based on the input value.
                 *
                 * @param {Event} $event
                 * @returns {void}
                 */
                search($event) {
                    let requestedValue = $event.target.value;

                    let appliedColumn = this.filters.columns.find(column => column.index === 'all');

                    if (! requestedValue) {
                        appliedColumn.value = [];

                        this.$emit('search', this.filters);

                        return;
                    }

                    if (appliedColumn) {
                        appliedColumn.value = [requestedValue];
                    } else {
                        this.filters.columns.push({
                            index: 'all',
                            value: [requestedValue]
                        });
                    }

                    this.$emit('search', this.filters);
                },

                /**
                 * Get the searched values for a specific column.
                 *
                 * @param {string} columnIndex
                 * @returns {Array}
                 */
                getSearchedValues(columnIndex) {
                    let appliedColumn = this.filters.columns.find(column => column.index === 'all');

                    return appliedColumn?.value ?? [];
                },
            },
        });
    </script>
@endPushOnce
