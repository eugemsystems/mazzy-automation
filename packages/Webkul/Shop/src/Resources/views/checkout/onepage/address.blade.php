{!! view_render_event('bagisto.shop.checkout.onepage.address.before') !!}

<!-- Accordion Blade Component -->
<x-shop::accordion class="mb-4 overflow-hidden rounded-2xl border border-slate-100 bg-white !border-b shadow-sm">
    <!-- Accordion Header Component Slot -->
    <x-slot:header class="!px-5 !py-4">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-semibold text-slate-900">
                @lang('shop::app.checkout.onepage.address.title')
            </h2>
        </div>
    </x-slot>

    <!-- Accordion Content Component Slot -->
    <x-slot:content class="!px-5 !pb-5 !pt-0">
        <!-- If the customer is guest -->
        <template v-if="cart.is_guest">
            @include('shop::checkout.onepage.address.guest')
        </template>

        <!-- If the customer is logged in -->
        <template v-else>
            @include('shop::checkout.onepage.address.customer')
        </template>
    </x-slot:content>
</x-shop::accordion>

{!! view_render_event('bagisto.shop.checkout.onepage.address.after') !!}