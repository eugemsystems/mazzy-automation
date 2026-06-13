<v-modal-confirm ref="confirmModal"></v-modal-confirm>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-modal-confirm-template"
    >
        <div>
            <transition
                tag="div"
                name="modal-overlay"
                enter-class="duration-300 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-class="duration-200 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    class="fixed inset-0 z-20 bg-slate-900/50 backdrop-blur-sm transition-opacity"
                    v-show="isOpen"
                ></div>
            </transition>

            <transition
                tag="div"
                name="modal-content"
                enter-class="duration-300 ease-out"
                enter-from-class="translate-y-4 opacity-0 md:translate-y-0 md:scale-95"
                enter-to-class="translate-y-0 opacity-100 md:scale-100"
                leave-class="duration-200 ease-in"
                leave-from-class="translate-y-0 opacity-100 md:scale-100"
                leave-to-class="translate-y-4 opacity-0 md:translate-y-0 md:scale-95"
            >
                <div
                    class="fixed inset-0 z-20 transform overflow-y-auto transition" v-show="isOpen"
                >
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div class="absolute left-1/2 top-1/2 z-[999] w-full max-w-[440px] -translate-x-1/2 -translate-y-1/2 overflow-hidden rounded-2xl bg-white p-6 text-left shadow-2xl ring-1 ring-slate-100 max-md:w-[90%] max-sm:p-5">
                            <div class="flex gap-4">
                                <div class="shrink-0">
                                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-red-50 text-red-500">
                                        <i class="icon-error text-2xl"></i>
                                    </span>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <div class="text-base font-semibold text-slate-900">
                                        @{{ title }}
                                    </div>

                                    <div class="pb-5 pt-1 text-left text-sm leading-relaxed text-slate-500">
                                        @{{ message }}
                                    </div>

                                    <div class="flex justify-end gap-3">
                                        <button
                                            type="button"
                                            class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                                            @click="disagree"
                                        >
                                            @{{ options.btnDisagree }}
                                        </button>

                                        <button
                                            type="button"
                                            class="rounded-lg bg-red-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-600"
                                            @click="agree"
                                        >
                                            @{{ options.btnAgree }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </script>

    <script type="module">
        app.component('v-modal-confirm', {
            template: '#v-modal-confirm-template',

            data() {
                return {
                    isOpen: false,

                    title: '',

                    message: '',

                    options: {
                        btnDisagree: '',
                        btnAgree: '',
                    },

                    agreeCallback: null,

                    disagreeCallback: null,
                };
            },

            created() {
                this.registerGlobalEvents();
            },

            methods: {
                open({
                    title = "@lang('shop::app.components.modal.confirm.title')",
                    message = "@lang('shop::app.components.modal.confirm.message')",
                    options = {
                        btnDisagree: "@lang('shop::app.components.modal.confirm.disagree-btn')",
                        btnAgree: "@lang('shop::app.components.modal.confirm.agree-btn')",
                    },
                    agree = () => {},
                    disagree = () => {},
                }) {
                    this.isOpen = true;

                    const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;

                    document.body.style.overflow = 'hidden';

                    document.body.style.paddingRight = `${scrollbarWidth}px`;

                    this.title = title;

                    this.message = message;

                    this.options = options;

                    this.agreeCallback = agree;

                    this.disagreeCallback = disagree;
                },

                disagree() {
                    this.isOpen = false;

                    document.body.style.overflow = 'auto';

                    document.body.style.paddingRight = '';

                    this.disagreeCallback();
                },

                agree() {
                    this.isOpen = false;

                    document.body.style.overflow = 'auto';

                    document.body.style.paddingRight = '';

                    this.agreeCallback();
                },

                registerGlobalEvents() {
                    this.$emitter.on('open-confirm-modal', this.open);
                },
            }
        });
    </script>
@endPushOnce
