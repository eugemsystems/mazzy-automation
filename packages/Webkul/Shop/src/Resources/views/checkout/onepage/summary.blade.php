<!-- Cart Summary Card -->
<div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
    <!-- Header -->
    <div class="border-b border-slate-100 px-5 py-4">
        <p class="text-sm font-semibold uppercase tracking-widest text-slate-400">
            @lang('shop::app.checkout.onepage.summary.cart-summary')
        </p>
    </div>

    <!-- Cart Items -->
    <div class="flex max-h-[320px] flex-col gap-3 overflow-y-auto px-5 py-4">
        <div
            class="flex gap-3"
            v-for="item in cart.items"
        >
            {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_image.before') !!}

            <img
                class="h-14 w-14 shrink-0 rounded-xl border border-slate-100 bg-slate-50 object-cover"
                :src="item.base_image.small_image_url"
                :alt="item.name"
                width="110"
                height="110"
            />

            {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_image.after') !!}

            <div class="min-w-0 flex-1">
                {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_name.before') !!}

                <p class="line-clamp-2 text-sm font-semibold leading-snug text-slate-800">
                    @{{ item.name }}
                </p>

                {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_name.after') !!}

                <p class="mt-1 flex flex-col text-sm font-medium text-slate-600">
                    <template v-if="displayTax.prices == 'including_tax'">
                        @lang('shop::app.checkout.onepage.summary.price_and_qty', ['price' => '@{{ item.formatted_price_incl_tax }}', 'qty' => '@{{ item.quantity }}'])
                    </template>

                    <template v-else-if="displayTax.prices == 'both'">
                        @lang('shop::app.checkout.onepage.summary.price_and_qty', ['price' => '@{{ item.formatted_price_incl_tax }}', 'qty' => '@{{ item.quantity }}'])

                        <span class="text-xs font-normal text-slate-400">
                            @lang('shop::app.checkout.onepage.summary.excl-tax')

                            <span class="font-medium text-slate-600">@{{ item.formatted_total }}</span>
                        </span>
                    </template>

                    <template v-else>
                        @lang('shop::app.checkout.onepage.summary.price_and_qty', ['price' => '@{{ item.formatted_price }}', 'qty' => '@{{ item.quantity }}'])
                    </template>
                </p>
            </div>
        </div>
    </div>

    <!-- Cart Totals -->
    <div class="flex flex-col gap-2.5 border-t border-slate-100 px-5 py-4">
        <!-- Sub Total -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.sub_total.before') !!}

        <template v-if="displayTax.subtotal == 'including_tax'">
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-500">@lang('shop::app.checkout.onepage.summary.sub-total')</p>
                <p class="text-sm font-medium text-slate-800">@{{ cart.formatted_sub_total_incl_tax }}</p>
            </div>
        </template>

        <template v-else-if="displayTax.subtotal == 'both'">
            <div class="flex items-start justify-between">
                <p class="text-sm text-slate-500">@lang('shop::app.checkout.onepage.summary.sub-total')</p>
                <div class="text-right">
                    <p class="text-sm font-medium text-slate-800">@{{ cart.formatted_sub_total }}</p>
                    <p class="text-xs italic text-slate-400">@lang('shop::app.checkout.onepage.summary.incl-tax') @{{ cart.formatted_sub_total_incl_tax }}</p>
                </div>
            </div>
        </template>

        <template v-else>
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-500">@lang('shop::app.checkout.onepage.summary.sub-total')</p>
                <p class="text-sm font-medium text-slate-800">@{{ cart.formatted_sub_total }}</p>
            </div>
        </template>

        {!! view_render_event('bagisto.shop.checkout.onepage.summary.sub_total.after') !!}

        <!-- Discount -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.discount_amount.before') !!}

        <template v-if="cart.discount_amount && parseFloat(cart.discount_amount) > 0">
            <!-- Single Source: Simple line. -->
            <div
                class="flex items-center justify-between"
                v-if="parseFloat(cart.items_discount_amount || 0) <= 0 || parseFloat(cart.shipping_discount_amount || 0) <= 0"
            >
                <p class="text-sm text-emerald-600">@lang('shop::app.checkout.onepage.summary.discount-amount')</p>
                <p class="text-sm font-medium text-emerald-600">- @{{ cart.formatted_discount_amount }}</p>
            </div>

            <!-- Multi Source: Expandable breakdown. -->
            <div class="flex flex-col gap-1.5 rounded-lg bg-emerald-50 px-3 py-2.5" v-else>
                <div
                    class="flex cursor-pointer items-center justify-between"
                    @click="cart.show_discount_breakdown = ! cart.show_discount_breakdown"
                >
                    <p class="text-sm text-emerald-600">@lang('shop::app.checkout.onepage.summary.discount-amount')</p>
                    <p class="flex items-center gap-1 text-sm font-medium text-emerald-600">
                        - @{{ cart.formatted_discount_amount }}
                        <span class="text-base" :class="{'icon-arrow-up': cart.show_discount_breakdown, 'icon-arrow-down': ! cart.show_discount_breakdown}"></span>
                    </p>
                </div>

                <div class="flex flex-col gap-1" v-show="cart.show_discount_breakdown">
                    <div class="flex justify-between">
                        <p class="text-xs text-slate-500">@lang('shop::app.checkout.onepage.summary.items-discount')</p>
                        <p class="text-xs font-medium text-slate-500">- @{{ cart.formatted_items_discount_amount }}</p>
                    </div>

                    <div class="flex justify-between">
                        <p class="text-xs text-slate-500">@lang('shop::app.checkout.onepage.summary.shipping-discount')</p>
                        <p class="text-xs font-medium text-slate-500">- @{{ cart.formatted_shipping_discount_amount }}</p>
                    </div>
                </div>
            </div>
        </template>

        {!! view_render_event('bagisto.shop.checkout.onepage.summary.discount_amount.after') !!}

        <!-- Apply Coupon -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.coupon.before') !!}

        @include('shop::checkout.coupon')

        {!! view_render_event('bagisto.shop.checkout.onepage.summary.coupon.after') !!}

        <!-- Shipping Rates -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.before') !!}

        <template v-if="displayTax.shipping == 'including_tax'">
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-500">@lang('shop::app.checkout.onepage.summary.delivery-charges')</p>
                <p class="text-sm font-medium text-slate-800">+ @{{ cart.formatted_shipping_amount_incl_tax }}</p>
            </div>
        </template>

        <template v-else-if="displayTax.shipping == 'both'">
            <div class="flex items-start justify-between">
                <p class="text-sm text-slate-500">@lang('shop::app.checkout.onepage.summary.delivery-charges')</p>
                <div class="text-right">
                    <p class="text-sm font-medium text-slate-800">+ @{{ cart.formatted_shipping_amount }}</p>
                    <p class="text-xs italic text-slate-400">@lang('shop::app.checkout.onepage.summary.incl-tax') @{{ cart.formatted_shipping_amount_incl_tax }}</p>
                </div>
            </div>
        </template>

        <template v-else>
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-500">@lang('shop::app.checkout.onepage.summary.delivery-charges')</p>
                <p class="text-sm font-medium text-slate-800">+ @{{ cart.formatted_shipping_amount }}</p>
            </div>
        </template>

        {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.after') !!}

        <!-- Taxes -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.tax.before') !!}

        <div class="flex items-center justify-between" v-if="! cart.tax_total">
            <p class="text-sm text-slate-500">@lang('shop::app.checkout.onepage.summary.tax')</p>
            <p class="text-sm font-medium text-slate-800">+ @{{ cart.formatted_tax_total }}</p>
        </div>

        <div class="flex flex-col gap-1.5" v-else>
            <div class="flex cursor-pointer items-center justify-between" @click="cart.show_taxes = ! cart.show_taxes">
                <p class="text-sm text-slate-500">@lang('shop::app.checkout.onepage.summary.tax')</p>
                <p class="flex items-center gap-1 text-sm font-medium text-slate-800">
                    <template v-if="displayTax.subtotal === 'including_tax'">
                        @{{ cart.formatted_tax_total }}
                        <span class="text-xs font-normal italic text-slate-400">(@lang('shop::app.checkout.onepage.summary.included'))</span>
                    </template>

                    <template v-else>+ @{{ cart.formatted_tax_total }}</template>

                    <span class="text-base" :class="{'icon-arrow-up': cart.show_taxes, 'icon-arrow-down': ! cart.show_taxes}"></span>
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

        {!! view_render_event('bagisto.shop.checkout.onepage.summary.tax.after') !!}
    </div>

    <!-- Gradient Grand Total -->
    <div class="p-3">
        <div class="rounded-2xl bg-gradient-to-br from-[#332a5e] to-[#1f1940] p-4 shadow-lg shadow-[#332a5e]/25">
            {!! view_render_event('bagisto.shop.checkout.onepage.summary.grand_total.before') !!}

            <div class="flex items-end justify-between">
                <p class="text-xs font-medium uppercase tracking-widest text-white/60">@lang('shop::app.checkout.onepage.summary.grand-total')</p>
                <p class="text-2xl font-extrabold text-white">@{{ cart.formatted_grand_total }}</p>
            </div>

            {!! view_render_event('bagisto.shop.checkout.onepage.summary.grand_total.after') !!}
        </div>
    </div>
</div>
