<div class="w-[360px] shrink-0 max-1060:w-full">
    <div class="sticky top-4 rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        {!! view_render_event('bagisto.shop.checkout.cart.summary.title.before') !!}

        <!-- Header -->
        <div class="border-b border-slate-100 px-5 py-4">
            <p class="text-sm font-semibold uppercase tracking-widest text-slate-400">
                @lang('shop::app.checkout.cart.summary.cart-summary')
            </p>
        </div>

        {!! view_render_event('bagisto.shop.checkout.cart.summary.title.after') !!}

        <!-- Line items -->
        <div class="flex flex-col gap-3 px-5 pt-4">
            <!-- Estimate shipping -->
            @if (core()->getConfigData('sales.checkout.shopping_cart.estimate_shipping'))
                <template v-if="cart.have_stockable_items">
                    @include('shop::checkout.cart.summary.estimate-shipping')
                </template>
            @endif

            <!-- Sub Total -->
            {!! view_render_event('bagisto.shop.checkout.cart.summary.sub_total.before') !!}

            <template v-if="displayTax.subtotal == 'including_tax'">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-500">@lang('shop::app.checkout.cart.summary.sub-total')</p>
                    <p class="text-sm font-medium text-slate-800">@{{ cart.formatted_sub_total_incl_tax }}</p>
                </div>
            </template>

            <template v-else-if="displayTax.subtotal == 'both'">
                <div class="flex items-start justify-between">
                    <p class="text-sm text-slate-500">@lang('shop::app.checkout.cart.summary.sub-total')</p>
                    <div class="text-right">
                        <p class="text-sm font-medium text-slate-800">@{{ cart.formatted_sub_total }}</p>
                        <p class="text-xs text-slate-400 italic">@lang('shop::app.checkout.cart.summary.incl-tax') @{{ cart.formatted_sub_total_incl_tax }}</p>
                    </div>
                </div>
            </template>

            <template v-else>
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-500">@lang('shop::app.checkout.cart.summary.sub-total')</p>
                    <p class="text-sm font-medium text-slate-800">@{{ cart.formatted_sub_total }}</p>
                </div>
            </template>

            {!! view_render_event('bagisto.shop.checkout.cart.summary.sub_total.after') !!}

            <!-- Discount -->
            {!! view_render_event('bagisto.shop.checkout.cart.summary.discount_amount.before') !!}

            <template v-if="cart.discount_amount && parseFloat(cart.discount_amount) > 0">
                <div
                    class="flex items-center justify-between"
                    v-if="parseFloat(cart.items_discount_amount || 0) <= 0 || parseFloat(cart.shipping_discount_amount || 0) <= 0"
                >
                    <p class="text-sm text-emerald-600">@lang('shop::app.checkout.cart.summary.discount-amount')</p>
                    <p class="text-sm font-medium text-emerald-600">- @{{ cart.formatted_discount_amount }}</p>
                </div>

                <div class="flex flex-col gap-1.5 rounded-lg bg-emerald-50 px-3 py-2.5" v-else>
                    <div class="flex cursor-pointer items-center justify-between" @click="cart.show_discount_breakdown = !cart.show_discount_breakdown">
                        <p class="text-sm text-emerald-600">@lang('shop::app.checkout.cart.summary.discount-amount')</p>
                        <p class="flex items-center gap-1 text-sm font-medium text-emerald-600">
                            - @{{ cart.formatted_discount_amount }}
                            <span class="text-base" :class="cart.show_discount_breakdown ? 'icon-arrow-up' : 'icon-arrow-down'"></span>
                        </p>
                    </div>
                    <div class="flex flex-col gap-1" v-show="cart.show_discount_breakdown">
                        <div class="flex justify-between">
                            <p class="text-xs text-slate-500">@lang('shop::app.checkout.cart.summary.items-discount')</p>
                            <p class="text-xs font-medium text-slate-500">- @{{ cart.formatted_items_discount_amount }}</p>
                        </div>
                        <div class="flex justify-between">
                            <p class="text-xs text-slate-500">@lang('shop::app.checkout.cart.summary.shipping-discount')</p>
                            <p class="text-xs font-medium text-slate-500">- @{{ cart.formatted_shipping_discount_amount }}</p>
                        </div>
                    </div>
                </div>
            </template>

            {!! view_render_event('bagisto.shop.checkout.cart.summary.discount_amount.after') !!}

            <!-- Coupon -->
            {!! view_render_event('bagisto.shop.checkout.cart.summary.coupon.before') !!}
            @include('shop::checkout.coupon')
            {!! view_render_event('bagisto.shop.checkout.cart.summary.coupon.after') !!}

            <!-- Delivery charges -->
            {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.before') !!}

            <template v-if="displayTax.shipping == 'including_tax'">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-500">@lang('shop::app.checkout.cart.summary.delivery-charges')</p>
                    <p class="text-sm font-medium text-slate-800">+ @{{ cart.formatted_shipping_amount_incl_tax }}</p>
                </div>
            </template>

            <template v-else-if="displayTax.shipping == 'both'">
                <div class="flex items-start justify-between">
                    <p class="text-sm text-slate-500">@lang('shop::app.checkout.cart.summary.delivery-charges')</p>
                    <div class="text-right">
                        <p class="text-sm font-medium text-slate-800">+ @{{ cart.formatted_shipping_amount }}</p>
                        <p class="text-xs italic text-slate-400">@lang('shop::app.checkout.cart.summary.incl-tax') @{{ cart.formatted_shipping_amount_incl_tax }}</p>
                    </div>
                </div>
            </template>

            <template v-else>
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-500">@lang('shop::app.checkout.cart.summary.delivery-charges')</p>
                    <p class="text-sm font-medium text-slate-800">+ @{{ cart.formatted_shipping_amount }}</p>
                </div>
            </template>

            {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.after') !!}

            <!-- Tax -->
            {!! view_render_event('bagisto.shop.checkout.cart.summary.tax.before') !!}

            <div class="flex items-center justify-between" v-if="!cart.tax_total">
                <p class="text-sm text-slate-500">@lang('shop::app.checkout.cart.summary.tax')</p>
                <p class="text-sm font-medium text-slate-800">+ @{{ cart.formatted_tax_total }}</p>
            </div>

            <div class="flex flex-col gap-1.5" v-else>
                <div class="flex cursor-pointer items-center justify-between" @click="cart.show_taxes = !cart.show_taxes">
                    <p class="text-sm text-slate-500">@lang('shop::app.checkout.cart.summary.tax')</p>
                    <p class="flex items-center gap-1 text-sm font-medium text-slate-800">
                        <template v-if="displayTax.subtotal === 'including_tax'">
                            @{{ cart.formatted_tax_total }}
                            <span class="text-xs font-normal italic text-slate-400">(@lang('shop::app.checkout.cart.summary.included'))</span>
                        </template>
                        <template v-else>+ @{{ cart.formatted_tax_total }}</template>
                        <span class="text-base" :class="cart.show_taxes ? 'icon-arrow-up' : 'icon-arrow-down'"></span>
                    </p>
                </div>
                <div class="flex flex-col gap-1" v-show="cart.show_taxes">
                    <div class="flex justify-between" v-for="(amount, index) in cart.applied_taxes">
                        <p class="text-xs text-slate-400">@{{ index }}</p>
                        <p class="text-xs font-medium text-slate-400">
                            <template v-if="displayTax.subtotal === 'including_tax'">@{{ amount }}</template>
                            <template v-else>+ @{{ amount }}</template>
                        </p>
                    </div>
                </div>
            </div>

            {!! view_render_event('bagisto.shop.checkout.cart.summary.tax.after') !!}
        </div>

        <!-- Gradient total + CTA panel -->
        <div class="p-3 pt-4">
            <div class="rounded-2xl bg-gradient-to-br from-[#332a5e] to-[#1f1940] p-4 shadow-lg shadow-[#332a5e]/25">
                {!! view_render_event('bagisto.shop.checkout.cart.summary.grand_total.before') !!}

                <div class="mb-4 flex items-end justify-between">
                    <p class="text-xs font-medium uppercase tracking-widest text-white/60">@lang('shop::app.checkout.cart.summary.grand-total')</p>
                    <p class="text-2xl font-extrabold text-white">@{{ cart.formatted_grand_total }}</p>
                </div>

                {!! view_render_event('bagisto.shop.checkout.cart.summary.grand_total.after') !!}
                {!! view_render_event('bagisto.shop.checkout.cart.summary.proceed_to_checkout.before') !!}

                <a
                    href="{{ route('shop.checkout.onepage.index') }}"
                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-white py-3.5 text-sm font-bold text-[#332a5e] shadow-sm transition hover:bg-white/90"
                >
                    @lang('shop::app.checkout.cart.summary.proceed-to-checkout')
                    <span class="icon-arrow-right rtl:icon-arrow-left text-base"></span>
                </a>

                {!! view_render_event('bagisto.shop.checkout.cart.summary.proceed_to_checkout.after') !!}
            </div>
        </div>
    </div>
</div>
