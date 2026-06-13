@props(['position' => 'left'])

<v-tabs
    position="{{ $position }}"
    {{ $attributes }}
>
    <x-shop::shimmer.tabs />
</v-tabs>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-tabs-template"
    >
        <div>
            <div
                class="flex"
                :style="positionStyles"
            >
                <div class="inline-flex flex-wrap gap-1 rounded-xl border border-slate-100 bg-slate-50 p-1">
                    <div
                        role="button"
                        tabindex="0"
                        v-for="tab in tabs"
                        class="cursor-pointer whitespace-nowrap rounded-lg px-4 py-2 text-sm font-semibold transition-all"
                        :class="tab.isActive
                            ? 'bg-white text-[#332a5e] shadow-sm'
                            : 'text-slate-500 hover:text-slate-900'"
                        :id="tab.$attrs.id + '-button'"
                        @click="change(tab)"
                    >
                        @{{ tab.title }}
                    </div>
                </div>
            </div>

            <div>
                {{ $slot }}
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-tabs', {
            template: '#v-tabs-template',

            props: ['position'],

            data() {
                return {
                    tabs: []
                }
            },

            computed: {
                positionStyles() {
                    return [
                        `justify-content: ${this.position}`
                    ];
                },
            },

            methods: {
                change(selectedTab) {
                    this.tabs.forEach(tab => {
                        tab.isActive = (tab.title == selectedTab.title);
                    });
                },
            },
        });
    </script>
@endPushOnce
