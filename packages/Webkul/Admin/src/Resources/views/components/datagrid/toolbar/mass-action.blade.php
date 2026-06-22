<v-datagrid-mass-action
    :available="available"
    :applied="applied"
>
    {{ $slot }}
</v-datagrid-mass-action>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-datagrid-mass-action-template"
    >
        <!-- Input-type mass action modal — teleported to <body> to escape stacking contexts -->
        <Teleport to="body">
            <div
                v-if="inputModal.open"
                style="position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.55);"
                @click.self="inputModal.open = false"
            >
                <div style="background:#fff;border-radius:12px;padding:28px 32px;width:100%;max-width:420px;box-shadow:0 20px 60px rgba(0,0,0,0.25);position:relative;">
                    <!-- Close button -->
                    <button
                        type="button"
                        style="position:absolute;top:14px;right:16px;background:none;border:none;font-size:20px;cursor:pointer;color:#6b7280;line-height:1;"
                        @click="inputModal.open = false"
                    >&times;</button>

                    <h3 style="margin:0 0 6px;font-size:17px;font-weight:700;color:#1f2937;">
                        @{{ inputModal.action?.title }}
                    </h3>
                    <p style="margin:0 0 20px;font-size:13px;color:#6b7280;">Enter the value to apply to all selected products.</p>

                    <label style="display:block;margin-bottom:6px;font-size:13px;font-weight:600;color:#374151;">
                        @{{ inputModal.action?.input_label }}
                    </label>
                    <input
                        type="number"
                        style="display:block;width:100%;box-sizing:border-box;padding:10px 14px;font-size:15px;border:1.5px solid #d1d5db;border-radius:8px;outline:none;color:#111827;margin-bottom:24px;"
                        v-model="inputModal.value"
                        min="0"
                        step="0.01"
                        placeholder="0.00"
                        ref="inputModalField"
                        @keyup.enter="applyInputAction"
                        @focus="$event.target.style.borderColor='#6366f1'"
                        @blur="$event.target.style.borderColor='#d1d5db'"
                    >

                    <div style="display:flex;justify-content:flex-end;gap:10px;">
                        <button
                            type="button"
                            style="padding:9px 20px;font-size:13px;font-weight:600;border:1.5px solid #d1d5db;border-radius:8px;background:#fff;color:#374151;cursor:pointer;"
                            @click="inputModal.open = false"
                        >
                            Cancel
                        </button>
                        <button
                            type="button"
                            style="padding:9px 20px;font-size:13px;font-weight:600;border:none;border-radius:8px;background:#4f46e5;color:#fff;cursor:pointer;"
                            @click="applyInputAction"
                        >
                            @lang('admin::app.components.datagrid.toolbar.mass-actions.submit')
                        </button>
                    </div>
                </div>
            </div>
        </Teleport>

        <slot
            name="mass-action"
            :available="available"
            :applied="applied"
            :mass-actions="massActions"
            :validate-mass-action="validateMassAction"
            :perform-mass-action="performMassAction"
        >
            <div class="flex w-full items-center gap-x-1">
                <x-admin::dropdown>
                    <x-slot:toggle>
                        <button
                            type="button"
                            class="inline-flex w-full max-w-max cursor-pointer appearance-none items-center justify-between gap-x-2 rounded-md border bg-white px-2.5 py-1.5 text-center leading-6 text-gray-600 transition-all marker:shadow hover:border-gray-400 focus:border-gray-400 focus:ring-black dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                        >
                            <span>
                                @lang('admin::app.components.datagrid.toolbar.mass-actions.select-action')
                            </span>

                            <span class="icon-sort-down text-2xl"></span>
                        </button>
                    </x-slot>

                    <x-slot:menu class="!p-0 shadow-[0_5px_20px_rgba(0,0,0,0.15)] dark:border-gray-800">
                        <template v-for="massAction in available.massActions">
                            <li
                                class="group/item relative overflow-visible"
                                v-if="massAction?.options?.length"
                            >
                                <a
                                    class="whitespace-no-wrap flex cursor-not-allowed justify-between gap-1.5 rounded-t px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-950"
                                    href="javascript:void(0);"
                                >
                                    <i
                                        class="text-2xl"
                                        :class="massAction.icon"
                                        v-if="massAction?.icon"
                                    >
                                    </i>

                                    <span>
                                        @{{ massAction.title }}
                                    </span>

                                    <i class="icon-arrow-left rtl:icon-arrow-right -mt-px text-xl"></i>
                                </a>

                                <ul class="absolute top-0 z-10 hidden w-max min-w-[150px] rounded border bg-white shadow-[0_5px_20px_rgba(0,0,0,0.15)] group-hover/item:block dark:border-gray-800 dark:bg-gray-900 ltr:left-full rtl:right-full">
                                    <li v-for="option in massAction.options">
                                        <a
                                            class="whitespace-no-wrap block rounded-t px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-950"
                                            href="javascript:void(0);"
                                            @click="performMassAction(massAction, option)"
                                        >
                                            @{{ option.label }}
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li v-else-if="massAction?.type === 'input'">
                                <a
                                    class="whitespace-no-wrap flex gap-1.5 rounded-b px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-950"
                                    href="javascript:void(0);"
                                    @click="openInputModal(massAction)"
                                >
                                    <i
                                        class="text-2xl"
                                        :class="massAction.icon"
                                        v-if="massAction?.icon"
                                    >
                                    </i>

                                    @{{ massAction.title }}
                                </a>
                            </li>

                            <li v-else>
                                <a
                                    class="whitespace-no-wrap flex gap-1.5 rounded-b px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-950"
                                    href="javascript:void(0);"
                                    @click="performMassAction(massAction)"
                                >
                                    <i
                                        class="text-2xl"
                                        :class="massAction.icon"
                                        v-if="massAction?.icon"
                                    >
                                    </i>

                                    @{{ massAction.title }}
                                </a>
                            </li>
                        </template>
                    </x-slot>
                </x-admin::dropdown>

                <div class="ltr:pl-2.5 rtl:pr-2.5">
                    <p class="text-sm font-light text-gray-800 dark:text-white">
                        @{{ "@lang('admin::app.components.datagrid.toolbar.length-of')".replace(':length', massActions.indices.length) }}

                        @{{ "@lang('admin::app.components.datagrid.toolbar.selected')".replace(':total', available.meta.total) }}
                    </p>
                </div>
            </div>
        </slot>
    </script>

    <script type="module">
        app.component('v-datagrid-mass-action', {
            template: '#v-datagrid-mass-action-template',

            props: ['available', 'applied'],

            data() {
                return {
                    massActions: {
                        meta: {
                            mode: 'none',

                            action: null,
                        },

                        indices: [],

                        value: null,
                    },

                    inputModal: {
                        open: false,
                        action: null,
                        value: '',
                    },
                };
            },

            mounted() {
                this.massActions = this.applied.massActions;
            },

            methods: {
                /**
                 * Open the floating input modal for input-type mass actions.
                 */
                openInputModal(action) {
                    if (! this.massActions.indices.length) {
                        this.$emitter.emit('add-flash', { type: 'warning', message: "@lang('admin::app.components.datagrid.index.no-records-selected')" });

                        return;
                    }

                    this.inputModal.action = action;
                    this.inputModal.value = '';
                    this.inputModal.open = true;

                    this.$nextTick(() => {
                        if (this.$refs.inputModalField) {
                            this.$refs.inputModalField.focus();
                        }
                    });
                },

                /**
                 * Submit the input modal value as a mass action.
                 */
                applyInputAction() {
                    const raw = this.inputModal.value;

                    if (raw === '' || isNaN(parseFloat(raw))) {
                        this.$emitter.emit('add-flash', { type: 'warning', message: 'Please enter a valid value.' });

                        return;
                    }

                    const action = this.inputModal.action;

                    this.inputModal.open = false;

                    this.$emitter.emit('open-confirm-modal', {
                        agree: () => {
                            this.$axios.post(action.url, {
                                    indices: this.massActions.indices,
                                    value: parseFloat(raw),
                                })
                                .then((response) => {
                                    this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                    this.$parent.get();
                                })
                                .catch((error) => {
                                    this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });

                                    this.$parent.get();
                                });

                            this.massActions.indices = [];
                        },
                    });
                },

                /**
                 * Validate mass action.
                 *
                 * @param {object} filters
                 * @returns {void}
                 */
                validateMassAction() {
                    if (! this.massActions.indices.length) {
                        this.$emitter.emit('add-flash', { type: 'warning', message: "@lang('admin::app.components.datagrid.index.no-records-selected')" });

                        return false;
                    }

                    if (! this.massActions.meta.action) {
                        this.$emitter.emit('add-flash', { type: 'warning', message: "@lang('admin::app.components.datagrid.index.must-select-a-mass-action')" });

                        return false;
                    }

                    if (
                        this.massActions.meta.action?.options?.length &&
                        this.massActions.value === null
                    ) {
                        this.$emitter.emit('add-flash', { type: 'warning', message: "@lang('admin::app.components.datagrid.index.must-select-a-mass-action-option')" });

                        return false;
                    }

                    return true;
                },

                /**
                 * Perform mass action.
                 *
                 * @param {object} currentAction
                 * @param {object} currentOption
                 * @returns {void}
                 */
                performMassAction(currentAction, currentOption = null) {
                    this.massActions.meta.action = currentAction;

                    if (currentOption) {
                        this.massActions.value = currentOption.value;
                    }

                    if (! this.validateMassAction()) {
                        return;
                    }

                    const { action } = this.massActions.meta;

                    const method = action.method.toLowerCase();

                    this.$emitter.emit('open-confirm-modal', {
                        agree: () => {
                            switch (method) {
                                case 'post':
                                case 'put':
                                case 'patch':
                                    this.$axios[method](action.url, {
                                            indices: this.massActions.indices,
                                            value: this.massActions.value,
                                        })
                                        .then((response) => {
                                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                            this.$parent.get();
                                        })
                                        .catch((error) => {
                                            this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });

                                            this.$parent.get();
                                        });

                                    break;

                                case 'delete':
                                    this.$axios[method](action.url, {
                                            indices: this.massActions.indices
                                        })
                                        .then(response => {
                                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                            /**
                                             * Need to check reason why this.$emit('massActionSuccess') not emitting.
                                             */
                                            this.$parent.get();
                                        })
                                        .catch((error) => {
                                            this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });

                                            /**
                                             * Need to check reason why this.$emit('massActionSuccess') not emitting.
                                             */
                                            this.$parent.get();
                                        });

                                    break;

                                default:
                                    console.error('Method not supported.');

                                    break;
                            }

                            this.massActions.indices  = [];
                        },
                    });
                },
            },
        });
    </script>
@endPushOnce
