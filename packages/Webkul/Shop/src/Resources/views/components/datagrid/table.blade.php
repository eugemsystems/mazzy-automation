@props(['isMultiRow' => false])

<v-datagrid-table
    :is-loading="isLoading"
    :available="available"
    :applied="applied"
    @selectAll="selectAll"
    @sort="sort"
    @actionSuccess="get"
    @changePage="changePage"
>
    {{ $slot }}
</v-datagrid-table>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-datagrid-table-template"
    >
        <div class="w-full overflow-x-auto rounded-xl border max-md:rounded-none max-md:border-0">
            <table class="w-full border-collapse bg-white" style="min-width: 600px">
                <slot
                    name="header"
                    :is-loading="isLoading"
                    :available="available"
                    :applied="applied"
                    :select-all="selectAll"
                    :sort="sort"
                    :perform-action="performAction"
                >
                    <template v-if="isLoading">
                        <x-shop::shimmer.datagrid.table.head :isMultiRow="$isMultiRow" />
                    </template>

                    <template v-else>
                        <thead>
                            <tr class="border-b border-zinc-200 bg-zinc-50">
                                <!-- Mass Actions -->
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500 w-10" v-if="available.massActions.length">
                                    <label for="mass_action_select_all_records">
                                        <input
                                            type="checkbox"
                                            name="mass_action_select_all_records"
                                            id="mass_action_select_all_records"
                                            class="peer hidden"
                                            :checked="['all', 'partial'].includes(applied.massActions.meta.mode)"
                                            @change="selectAll"
                                        >
                                        <span
                                            class="icon-uncheck cursor-pointer rounded-md text-2xl"
                                            :class="[applied.massActions.meta.mode === 'all' ? 'peer-checked:icon-check-box' : (applied.massActions.meta.mode === 'partial' ? 'peer-checked:icon-checkbox-partial' : '')]"
                                        ></span>
                                    </label>
                                </th>

                                <!-- Columns -->
                                <template v-for="column in available.columns">
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500 whitespace-nowrap"
                                        :class="{'cursor-pointer select-none hover:text-zinc-800': column.sortable}"
                                        @click="sort(column)"
                                        v-if="column.visibility"
                                    >
                                        <span class="flex items-center gap-1">
                                            @{{ column.label }}
                                            <i
                                                class="align-text-bottom text-base text-gray-800"
                                                :class="[applied.sort.order === 'asc' ? 'icon-arrow-down': 'icon-arrow-up']"
                                                v-if="column.index == applied.sort.column"
                                            ></i>
                                        </span>
                                    </th>
                                </template>

                                <!-- Actions -->
                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-zinc-500" v-if="available.actions.length">
                                    @lang('shop::app.components.datagrid.table.actions')
                                </th>
                            </tr>
                        </thead>
                    </template>
                </slot>

                <slot
                    name="body"
                    :is-loading="isLoading"
                    :available="available"
                    :applied="applied"
                    :select-all="selectAll"
                    :sort="sort"
                    :perform-action="performAction"
                >
                    <template v-if="isLoading">
                        <x-shop::shimmer.datagrid.table.body :isMultiRow="$isMultiRow" />
                    </template>

                    <template v-else>
                        <tbody>
                            <template v-if="available.records.length">
                                <tr
                                    class="border-b border-zinc-100 bg-white transition-colors hover:bg-zinc-50/50"
                                    v-for="record in available.records"
                                >
                                    <!-- Mass Actions -->
                                    <td class="px-4 py-3" v-if="available.massActions.length">
                                        <label :for="`mass_action_select_record_${record[available.meta.primary_column]}`">
                                            <input
                                                type="checkbox"
                                                :name="`mass_action_select_record_${record[available.meta.primary_column]}`"
                                                :value="record[available.meta.primary_column]"
                                                :id="`mass_action_select_record_${record[available.meta.primary_column]}`"
                                                class="peer hidden"
                                                v-model="applied.massActions.indices"
                                            >
                                            <span class="icon-uncheck peer-checked:icon-check-box cursor-pointer rounded-md text-2xl"></span>
                                        </label>
                                    </td>

                                    <!-- Columns -->
                                    <template v-for="column in available.columns">
                                        <td
                                            class="px-4 py-3 text-sm text-zinc-700 whitespace-nowrap"
                                            v-html="record[column.index]"
                                            v-if="column.visibility"
                                        ></td>
                                    </template>

                                    <!-- Actions -->
                                    <td class="px-4 py-3 text-right" v-if="available.actions.length">
                                        <span
                                            class="inline-flex cursor-pointer rounded-md p-1.5 text-2xl transition-all hover:bg-gray-100"
                                            :class="action.icon"
                                            v-for="action in record.actions"
                                            @click="performAction(action)"
                                        >
                                            @{{ ! action.icon ? action.title : '' }}
                                        </span>
                                    </td>
                                </tr>
                            </template>

                            <template v-else>
                                <tr>
                                    <td colspan="99" class="px-5 py-8 text-center text-sm text-zinc-500">
                                        @lang('shop::app.components.datagrid.table.no-records-available')
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </template>
                </slot>

                <slot
                    name="footer"
                    :available="available"
                    :applied="applied"
                    :change-page="changePage"
                >
                    <template v-if="isLoading">
                        <x-shop::shimmer.datagrid.table.footer />
                    </template>

                    <template v-else>
                        <!-- Information Panel -->
                        <tfoot v-if="$parent.available.records.length">
                            <tr>
                                <td colspan="99" class="border-t border-zinc-100">
                                    <div class="flex items-center justify-between px-5 py-3">
                                        <p class="text-xs text-zinc-500">
                                            @{{ "@lang('shop::app.components.datagrid.table.showing')".replace(':firstItem', $parent.available.meta.from) }}
                                            @{{ "@lang('shop::app.components.datagrid.table.to')".replace(':lastItem', $parent.available.meta.to) }}
                                            @{{ "@lang('shop::app.components.datagrid.table.of')".replace(':total', $parent.available.meta.total) }}
                                        </p>

                                        <div class="inline-flex items-center rounded-lg border border-zinc-200 overflow-hidden text-sm">
                                            <button
                                                type="button"
                                                class="flex h-8 w-8 items-center justify-center text-zinc-500 hover:bg-zinc-50 border-r border-zinc-200 transition-colors"
                                                @click="changePage('previous')"
                                            >
                                                <span class="icon-arrow-left rtl:icon-arrow-right text-lg"></span>
                                            </button>

                                            <span class="px-3 py-1 text-xs font-medium text-zinc-700 min-w-[60px] text-center">
                                                @{{ $parent.available.meta.current_page }} / @{{ $parent.available.meta.last_page }}
                                            </span>

                                            <button
                                                type="button"
                                                class="flex h-8 w-8 items-center justify-center text-zinc-500 hover:bg-zinc-50 border-l border-zinc-200 transition-colors"
                                                @click="changePage('next')"
                                            >
                                                <span class="icon-arrow-right rtl:icon-arrow-left text-lg"></span>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </template>
                </slot>
            </table>
        </div>
    </script>

    <script type="module">
        app.component('v-datagrid-table', {
            template: '#v-datagrid-table-template',

            props: ['isLoading', 'available', 'applied'],

            emits: ['selectAll', 'sort', 'actionSuccess', 'changePage'],

            computed: {
                gridsCount() {
                    let count = this.available.columns.filter((column) => column.visibility).length;

                    if (this.available.actions.length) {
                        ++count;
                    }

                    if (this.available.massActions.length) {
                        ++count;
                    }

                    return count;
                },
            },

            methods: {
                /**
                 * Change Page.
                 *
                 * The reason for choosing the numeric approach over the URL approach is to prevent any conflicts with our existing
                 * URLs. If we were to use the URL approach, it would introduce additional arguments in the `get` method, necessitating
                 * the addition of a `url` prop. Instead, by using the numeric approach, we can let Axios handle all the query parameters
                 * using the `applied` prop. This allows for a cleaner and more straightforward implementation.
                 *
                 * @param {string|integer} directionOrPageNumber
                 * @returns {void}
                 */
                 changePage(directionOrPageNumber) {
                    let newPage;

                    if (typeof directionOrPageNumber === 'string') {
                        if (directionOrPageNumber === 'previous') {
                            newPage = this.available.meta.current_page - 1;
                        } else if (directionOrPageNumber === 'next') {
                            newPage = this.available.meta.current_page + 1;
                        } else {
                            console.warn('Invalid Direction Provided : ' + directionOrPageNumber);

                            return;
                        }
                    }  else if (typeof directionOrPageNumber === 'number') {
                        newPage = directionOrPageNumber;
                    } else {
                        console.warn('Invalid Input Provided: ' + directionOrPageNumber);

                        return;
                    }

                    /**
                     * Check if the `newPage` is within the valid range.
                     */
                    if (newPage >= 1 && newPage <= this.available.meta.last_page) {
                        this.$emit('changePage', newPage);
                    } else {
                        console.warn('Invalid Page Provided: ' + newPage);
                    }
                },

                /**
                 * Select all records in the datagrid.
                 *
                 * @returns {void}
                 */
                selectAll() {
                    this.$emit('selectAll');
                },

                /**
                 * Perform a sorting operation on the specified column.
                 *
                 * @param {object} column
                 * @returns {void}
                 */
                sort(column) {
                    this.$emit('sort', column);
                },

                /**
                 * Perform the specified action.
                 *
                 * @param {object} action
                 * @returns {void}
                 */
                performAction(action) {
                    const method = action.method.toLowerCase();

                    switch (method) {
                        case 'get':
                            window.location.href = action.url;

                            break;

                        case 'post':
                        case 'put':
                        case 'patch':
                        case 'delete':
                            this.$emitter.emit('open-confirm-modal', {
                                agree: () => {
                                    this.$axios[method](action.url)
                                        .then(response => {
                                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                            this.$emit('actionSuccess', response.data);
                                        })
                                        .catch((error) => {
                                            this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });

                                            this.$emit('actionError', error.response.data);
                                        });
                                }
                            });

                            break;

                        default:
                            console.error('Method not supported.');

                            break;
                    }
                },
            },
        });
    </script>
@endpushOnce
