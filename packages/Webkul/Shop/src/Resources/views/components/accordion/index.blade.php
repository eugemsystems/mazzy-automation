@props([
    'isActive' => true,
])

<div {{ $attributes->merge(['class' => 'border-b border-slate-100']) }}>
    <v-accordion
        {{ $attributes->except('class') }}
        is-active="{{ $isActive }}"
    >
        @isset($header)
            <template v-slot:header="{ toggle, isOpen }">
                <div
                    {{ $header->attributes->merge(['class' => 'flex cursor-pointer select-none items-center justify-between gap-3 py-4 text-sm font-semibold text-slate-800 transition hover:text-[#332a5e]']) }}
                    role="button"
                    tabindex="0"
                    @click="toggle"
                >
                    {{ $header }}

                    <span
                        v-bind:class="isOpen ? 'icon-arrow-up text-lg text-[#332a5e]' : 'icon-arrow-down text-lg text-slate-400'"
                        role="button"
                        aria-label="Toggle accordion"
                        tabindex="0"
                    ></span>
                </div>
            </template>
        @endisset

        @isset($content)
            <template v-slot:content="{ isOpen }">
                <div
                    {{ $content->attributes->merge(['class' => 'z-10 rounded-lg bg-white pb-4 pt-1 text-sm text-slate-600']) }}
                    v-show="isOpen"
                >
                    {{ $content }}
                </div>
            </template>
        @endisset
    </v-accordion>
</div>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-accordion-template"
    >
        <div>
            <slot
                name="header"
                :toggle="toggle"
                :isOpen="isOpen"
            >
                @lang('shop::app.components.accordion.default-content')
            </slot>

            <slot
                name="content"
                :isOpen="isOpen"
            >
                @lang('shop::app.components.accordion.default-content')
            </slot>
        </div>
    </script>

    <script type="module">
        app.component('v-accordion', {
            template: '#v-accordion-template',

            props: [
                'isActive',
            ],

            data() {
                return {
                    isOpen: this.isActive,
                };
            },

            methods: {
                toggle() {
                    this.isOpen = ! this.isOpen;

                    this.$emit('toggle', { isActive: this.isOpen });
                },
            },
        });
    </script>
@endPushOnce
