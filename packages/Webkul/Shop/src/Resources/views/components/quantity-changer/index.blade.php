@props([
    'name'     => '',
    'value'    => 1,
    'minValue' => 1,
])

<v-quantity-changer
    {{ $attributes->merge(['class' => 'inline-flex items-center']) }}
    name="{{ $name }}"
    value="{{ $value }}"
    min-value="{{ $minValue }}"
>
</v-quantity-changer>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-quantity-changer-template"
    >
        <div class="inline-flex h-9 items-center overflow-hidden rounded-lg border border-slate-200 bg-white">
            <button
                type="button"
                class="flex h-full w-9 items-center justify-center text-lg font-medium leading-none text-slate-500 transition-colors hover:bg-[#332a5e]/5 hover:text-[#332a5e] disabled:opacity-30 disabled:hover:bg-white"
                aria-label="@lang('shop::app.components.quantity-changer.decrease-quantity')"
                :disabled="quantity <= minValue"
                @click="decrease"
            >
                −
            </button>

            <span class="flex h-full min-w-[2.25rem] select-none items-center justify-center border-x border-slate-200 px-1 text-sm font-bold text-slate-800">
                @{{ quantity }}
            </span>

            <button
                type="button"
                class="flex h-full w-9 items-center justify-center text-lg font-medium leading-none text-slate-500 transition-colors hover:bg-[#332a5e]/5 hover:text-[#332a5e]"
                aria-label="@lang('shop::app.components.quantity-changer.increase-quantity')"
                @click="increase"
            >
                +
            </button>

            <v-field
                type="hidden"
                :name="name"
                v-model="quantity"
            ></v-field>
        </div>
    </script>

    <script type="module">
        app.component("v-quantity-changer", {
            template: '#v-quantity-changer-template',

            props:['name', 'value', 'minValue'],

            data() {
                return  {
                    quantity: this.value,
                }
            },

            watch: {
                value() {
                    this.quantity = this.value;
                },
            },

            methods: {
                increase() {
                    this.$emit('change', ++this.quantity);
                },

                decrease() {
                    if (this.quantity > this.minValue) {
                        this.quantity -= 1;
                        this.$emit('change', this.quantity);
                    }
                },
            }
        });
    </script>
@endpushOnce
