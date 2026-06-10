@php
    $customer = auth()->guard('customer')->user();
@endphp

<div class="panel-side journal-scroll sticky top-6 grid max-h-[calc(100vh-6rem)] min-w-[260px] max-w-[280px] grid-cols-[1fr] gap-2 overflow-y-auto overflow-x-hidden max-xl:min-w-[240px] max-md:max-w-full max-md:sticky max-md:top-0">
    <!-- Account Profile Hero Section -->
    <div class="flex items-center gap-3 rounded-2xl bg-gradient-to-br from-zinc-900 to-zinc-700 px-5 py-5 max-md:py-4">
        <div class="shrink-0">
            <img
                src="{{ $customer->image_url ?? bagisto_asset('images/user-placeholder.png') }}"
                class="h-12 w-12 rounded-full border-2 border-white/30 object-cover"
                alt="Profile Image"
            >
        </div>

        <div
            class="min-w-0 flex-1"
            v-pre
        >
            <p class="truncate text-base font-semibold text-white">
                {{ $customer->first_name }} {{ $customer->last_name }}
            </p>

            <p class="truncate text-xs text-zinc-400">
                {{ $customer->email }}
            </p>
        </div>
    </div>

    <!-- Account Navigation Menus -->
    @foreach (menu()->getItems('customer') as $menuItem)
        @if ($menuItem->haveChildren())
            <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm">
                <div class="border-b border-zinc-100 px-4 py-2.5">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">
                        {{ $menuItem->getName() }}
                    </p>
                </div>

                @foreach ($menuItem->getChildren() as $subMenuItem)
                    <a href="{{ $subMenuItem->getUrl() }}" class="group block border-b border-zinc-100 last:border-0">
                        <div class="flex items-center justify-between px-4 py-2.5 transition-colors hover:bg-zinc-50 {{ $subMenuItem->isActive() ? 'bg-navyBlue/5 border-l-[3px] border-l-navyBlue' : 'border-l-[3px] border-l-transparent' }}">
                            <span class="flex items-center gap-2.5 text-sm font-medium {{ $subMenuItem->isActive() ? 'text-navyBlue' : 'text-zinc-600 group-hover:text-zinc-900' }}">
                                <span class="{{ $subMenuItem->getIcon() }} text-base {{ $subMenuItem->isActive() ? 'text-navyBlue' : 'text-zinc-400 group-hover:text-zinc-600' }}"></span>
                                {{ $subMenuItem->getName() }}
                            </span>
                            <span class="icon-arrow-right rtl:icon-arrow-left text-sm {{ $subMenuItem->isActive() ? 'text-navyBlue' : 'text-zinc-300' }}"></span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    @endforeach

    <!-- Logout -->
    @auth('customer')
        <x-shop::form
            method="DELETE"
            action="{{ route('shop.customer.session.destroy') }}"
            id="customerLogoutNav"
        />

        <a
            href="{{ route('shop.customer.session.destroy') }}"
            onclick="event.preventDefault(); document.getElementById('customerLogoutNav').submit();"
            class="flex w-full items-center gap-2.5 rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-red-500 shadow-sm transition-colors hover:bg-red-50 hover:border-red-200"
        >
            <span class="icon-logout text-base"></span>
            @lang('shop::app.components.layouts.header.desktop.bottom.logout')
        </a>
    @endauth
</div>