@php
    $customer = auth()->guard('customer')->user();
@endphp

<div class="panel-side journal-scroll sticky top-6 grid max-h-[calc(100vh-6rem)] min-w-[260px] max-w-[280px] grid-cols-[1fr] gap-2 overflow-y-auto overflow-x-hidden max-xl:min-w-[240px] max-md:max-w-full max-md:sticky max-md:top-0">
    <!-- Account Profile Hero Section -->
    <div class="flex items-center gap-3.5 rounded-2xl bg-gradient-to-br from-[#332a5e] to-[#1f1940] px-5 py-5 shadow-sm max-md:py-4">
        <div class="shrink-0">
            <img
                src="{{ $customer->image_url ?? bagisto_asset('images/user-placeholder.png') }}"
                class="h-12 w-12 rounded-full object-cover ring-2 ring-white/25"
                alt="Profile Image"
            >
        </div>

        <div
            class="min-w-0 flex-1"
            v-pre
        >
            <p class="truncate text-sm font-semibold text-white">
                {{ $customer->first_name }} {{ $customer->last_name }}
            </p>

            <p class="truncate text-xs text-white/60">
                {{ $customer->email }}
            </p>
        </div>
    </div>

    <!-- Account Navigation Menus -->
    @foreach (menu()->getItems('customer') as $menuItem)
        @if ($menuItem->haveChildren())
            <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
                <div class="px-4 pb-1 pt-3.5">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">
                        {{ $menuItem->getName() }}
                    </p>
                </div>

                <div class="p-1.5">
                    @foreach ($menuItem->getChildren() as $subMenuItem)
                        <a href="{{ $subMenuItem->getUrl() }}" class="group block">
                            <div class="flex items-center justify-between gap-2 rounded-xl px-3 py-2.5 transition-colors {{ $subMenuItem->isActive() ? 'bg-[#332a5e]/5' : 'hover:bg-slate-50' }}">
                                <span class="flex items-center gap-2.5 text-sm font-medium {{ $subMenuItem->isActive() ? 'text-[#332a5e]' : 'text-slate-600 group-hover:text-slate-900' }}">
                                    <span class="{{ $subMenuItem->getIcon() }} text-base {{ $subMenuItem->isActive() ? 'text-[#332a5e]' : 'text-slate-400 group-hover:text-slate-600' }}"></span>
                                    {{ $subMenuItem->getName() }}
                                </span>
                                <span class="icon-arrow-right rtl:icon-arrow-left text-sm {{ $subMenuItem->isActive() ? 'text-[#332a5e]' : 'text-slate-300' }}"></span>
                            </div>
                        </a>
                    @endforeach
                </div>
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
            class="flex w-full items-center gap-2.5 rounded-2xl border border-slate-100 bg-white px-4 py-3 text-sm font-semibold text-red-500 shadow-sm transition-colors hover:border-red-200 hover:bg-red-50"
        >
            <span class="icon-logout text-base"></span>
            @lang('shop::app.components.layouts.header.desktop.bottom.logout')
        </a>
    @endauth
</div>