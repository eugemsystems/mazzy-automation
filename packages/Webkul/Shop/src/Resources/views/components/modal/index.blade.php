@props([
    'isActive' => false,
])

<v-modal
    is-active="{{ $isActive }}"
    {{ $attributes }}
>
    @isset($toggle)
        <template v-slot:toggle>
            {{ $toggle }}
        </template>
    @endisset

    @isset($header)
        <template v-slot:header="{ toggle, isOpen }">
            <div {{ $header->attributes->merge(['class' => 'flex items-center justify-between gap-5 border-b border-slate-100 bg-white px-6 py-4 text-base font-semibold text-slate-900 max-sm:px-4']) }}>
                {{ $header }}

                <span
                    class="icon-cancel flex h-8 w-8 shrink-0 cursor-pointer items-center justify-center rounded-lg text-xl text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                    @click="toggle"
                >
                </span>
            </div>
        </template>
    @endisset

    @isset($content)
        <template v-slot:content>
            <div {{ $content->attributes->merge(['class' => 'bg-white px-6 py-5 text-sm text-slate-600 max-sm:px-4']) }}>
                {{ $content }}
            </div>
        </template>
    @endisset

    @isset($footer)
        <template v-slot:footer>
            <div {{ $footer->attributes->merge(['class' => 'flex items-center justify-end gap-3 border-t border-slate-100 bg-white px-6 py-4 max-sm:px-4']) }}>
                {{ $footer }}
            </div>
        </template>
    @endisset
</v-modal>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-modal-template"
    >
        <div>
            <div @click="toggle">
                <slot name="toggle">
                </slot>
            </div>

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
                    class="fixed inset-0 z-10 bg-slate-900/50 backdrop-blur-sm transition-opacity"
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
                    class="fixed inset-0 z-10 transform overflow-y-auto transition" v-show="isOpen"
                >
                    <div class="flex min-h-full items-end justify-center p-4 sm:items-center sm:p-0">
                        <div class="absolute left-1/2 top-1/2 z-[999] w-full max-w-[595px] -translate-x-1/2 -translate-y-1/2 overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-100 max-md:w-[90%]">
                            <!-- Header Slot-->
                            <slot
                                name="header"
                                :toggle="toggle"
                                :isOpen="isOpen"
                            >
                            </slot>

                            <!-- Content Slot-->
                            <slot name="content"></slot>

                            <!-- Footer Slot-->
                            <slot name="footer"></slot>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </script>

    <script type="module">
        app.component('v-modal', {
            template: '#v-modal-template',

            props: ['isActive'],

            data() {
                return {
                    isOpen: this.isActive,
                };
            },

            methods: {
                toggle() {
                    this.isOpen = ! this.isOpen;

                    if (this.isOpen) {
                        const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;

                        document.body.style.overflow = 'hidden';

                        document.body.style.paddingRight = `${scrollbarWidth}px`;
                    } else {
                        document.body.style.overflow ='auto';

                        document.body.style.paddingRight = '';
                    }

                    this.$emit('toggle', { isActive: this.isOpen });
                },

                open() {
                    this.isOpen = true;

                    const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;

                    document.body.style.overflow = 'hidden';

                    document.body.style.paddingRight = `${scrollbarWidth}px`;

                    this.$emit('open', { isActive: this.isOpen });
                },

                close() {
                    this.isOpen = false;

                    document.body.style.overflow = 'auto';

                    document.body.style.paddingRight = '';

                    this.$emit('close', { isActive: this.isOpen });
                }
            }
        });
    </script>
@endPushOnce
