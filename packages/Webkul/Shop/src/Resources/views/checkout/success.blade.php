<x-shop::layouts
	:has-header="true"
	:has-feature="false"
	:has-footer="true"
>
    <!-- Page Title -->
    <x-slot:title>
		@lang('shop::app.checkout.success.thanks')
    </x-slot>

    <div style="background:#332a5e; padding:28px 0 22px;">
        <div class="container">
            <h1 style="color:#fff; font-size:22px; font-weight:700; margin:0 0 6px;">Order Confirmed</h1>
            <nav style="font-size:13px;">
                <a href="{{ route('shop.home.index') }}" style="color:rgba(255,255,255,.7); text-decoration:none;">Home</a>
                <span style="color:rgba(255,255,255,.4); margin:0 8px;">/</span>
                <span style="color:#FF9923;">Order Confirmed</span>
            </nav>
        </div>
    </div>

	<!-- Page content -->
	<div class="container" style="padding: 60px 0 80px;">
		<div class="grid place-items-center gap-y-5 max-md:gap-y-2.5">
			{{ view_render_event('bagisto.shop.checkout.success.image.before', ['order' => $order]) }}

			<img
				class="max-md:h-[100px] max-md:w-[100px]"
				src="{{ bagisto_asset('images/thank-you.png') }}"
				alt="@lang('shop::app.checkout.success.thanks')"
				title="@lang('shop::app.checkout.success.thanks')"
                loading="lazy"
                decoding="async"
			>

			{{ view_render_event('bagisto.shop.checkout.success.image.after', ['order' => $order]) }}

			<p class="text-xl max-md:text-sm">
				@if (auth()->guard('customer')->user())
					@lang('shop::app.checkout.success.order-id-info', [
						'order_id' => '<a class="text-blue-700" href="'.route('shop.customers.account.orders.view', $order->id).'">'.$order->increment_id.'</a>'
					])
				@else
					@lang('shop::app.checkout.success.order-id-info', ['order_id' => $order->increment_id])
				@endif
			</p>

			<p class="font-medium md:text-2xl">
				@lang('shop::app.checkout.success.thanks')
			</p>

			<p class="text-xl text-slate-500 max-md:text-center max-md:text-xs">
				@if (! empty($order->checkout_message))
					{!! nl2br($order->checkout_message) !!}
				@else
					@lang('shop::app.checkout.success.info')
				@endif
			</p>

			{{ view_render_event('bagisto.shop.checkout.success.continue-shopping.before', ['order' => $order]) }}

			<div style="display:flex; gap:12px; flex-wrap:wrap; justify-content:center; margin-top:12px;">
                <a href="{{ route('shop.home.store') }}" style="display:inline-flex; align-items:center; gap:8px; background:#332a5e; color:#fff; padding:12px 28px; border-radius:8px; text-decoration:none; font-size:14px; font-weight:600; transition:background .2s;" onmouseover="this.style.background='#FF9923'" onmouseout="this.style.background='#332a5e'">
                    <i class="fas fa-shopping-bag"></i>@lang('shop::app.checkout.cart.index.continue-shopping')
                </a>
                @if (auth()->guard('customer')->user())
                    <a href="{{ route('shop.customers.account.orders.index') }}" style="display:inline-flex; align-items:center; gap:8px; background:#fff; color:#332a5e; border:2px solid #332a5e; padding:10px 28px; border-radius:8px; text-decoration:none; font-size:14px; font-weight:600; transition:all .2s;" onmouseover="this.style.background='#332a5e'; this.style.color='#fff'" onmouseout="this.style.background='#fff'; this.style.color='#332a5e'">
                        <i class="fas fa-list"></i>View My Orders
                    </a>
                @endif
            </div>

			{{ view_render_event('bagisto.shop.checkout.success.continue-shopping.after', ['order' => $order]) }}
		</div>
	</div>
</x-shop::layouts>
