<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.addresses.index.add-address')
    </x-slot>
    
    <!-- Breadcrumbs -->
    @if ((core()->getConfigData('general.general.breadcrumbs.shop')))
        @section('breadcrumbs')
            <x-shop::breadcrumbs name="addresses" />
        @endSection
    @endif

    <div class="max-md:hidden">
        <x-shop::layouts.account.navigation />
    </div>

    <div class="flex-auto min-w-0 overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm max-md:mx-0 max-md:rounded-none max-md:border-x-0 max-md:shadow-none">
        <div class="flex items-center justify-between border-b border-zinc-100 px-6 py-4 max-sm:px-4">
            <div class="flex items-center gap-2">
                <a class="flex md:hidden" href="{{ route('shop.customers.account.index') }}">
                    <span class="text-2xl icon-arrow-left rtl:icon-arrow-right"></span>
                </a>
                <h2 class="text-base font-semibold text-zinc-900">
                    @lang('shop::app.customers.account.addresses.index.title')
                </h2>
            </div>
            <a
                href="{{ route('shop.customers.account.addresses.create') }}"
                class="secondary-button border-zinc-200 px-4 py-2 text-sm font-normal"
            >
                @lang('shop::app.customers.account.addresses.index.add-address')
            </a>
        </div>

        <div class="p-6 max-sm:p-4">
        @if (! $addresses->isEmpty())
            {!! view_render_event('bagisto.shop.customers.account.addresses.list.before', ['addresses' => $addresses]) !!}

            <div class="grid grid-cols-2 gap-4 max-1060:grid-cols-[1fr]">
                @foreach ($addresses as $address)
                    <div class="rounded-xl border border-zinc-200 p-5 hover:border-zinc-300 transition-colors max-md:flex-wrap">
                        <div class="flex justify-between">
                            <p class="text-base font-medium" v-pre>
                                {{ $address->first_name }} {{ $address->last_name }}

                                @if ($address->company_name)
                                    ({{ $address->company_name }})
                                @endif
                            </p>

                            <div class="flex gap-4 max-sm:gap-2.5">
                                @if ($address->default_address)
                                    <div class="label-pending block h-fit w-max px-2.5 py-1 max-md:px-1.5">
                                        @lang('shop::app.customers.account.addresses.index.default-address') 
                                    </div>
                                @endif

                                <!-- Dropdown Actions -->
                                <x-shop::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
                                    <x-slot:toggle>
                                        <button 
                                            class="icon-more cursor-pointer rounded-md px-1.5 py-1 text-2xl text-zinc-500 transition-all hover:bg-gray-100 hover:text-black focus:bg-gray-100 focus:text-black max-md:p-0" 
                                            aria-label="More Options"
                                        >
                                        </button>
                                    </x-slot>

                                    <x-slot:menu class="!py-1 max-sm:!py-0">
                                        <x-shop::dropdown.menu.item>
                                            <a href="{{ route('shop.customers.account.addresses.edit', $address->id) }}">
                                                <p class="w-full">
                                                    @lang('shop::app.customers.account.addresses.index.edit')
                                                </p>
                                            </a>    
                                        </x-shop::dropdown.menu.item>

                                        <x-shop::dropdown.menu.item>
                                            <form
                                                method="POST"
                                                ref="addressDelete"
                                                action="{{ route('shop.customers.account.addresses.delete', $address->id) }}"
                                            >
                                                @method('DELETE')
                                                @csrf
                                            </form>

                                            <a 
                                                href="javascript:void(0);"                                                
                                                @click="$emitter.emit('open-confirm-modal', {
                                                    agree: () => {
                                                        $refs['addressDelete'].submit()
                                                    }
                                                })"
                                            >
                                                <p class="w-full">
                                                    @lang('shop::app.customers.account.addresses.index.delete')
                                                </p>
                                            </a>
                                        </x-shop::dropdown.menu.item>

                                        @if (! $address->default_address)
                                            <x-shop::dropdown.menu.item>
                                                <form
                                                    method="POST"
                                                    ref="setAsDefault"
                                                    action="{{ route('shop.customers.account.addresses.update.default', $address->id) }}"
                                                >
                                                    @method('PATCH')
                                                    @csrf

                                                </form>

                                                <a 
                                                    href="javascript:void(0);"                                                
                                                    @click="$emitter.emit('open-confirm-modal', {
                                                        agree: () => {
                                                            $refs['setAsDefault'].submit()
                                                        }
                                                    })"
                                                >
                                                    <button>
                                                        @lang('shop::app.customers.account.addresses.index.set-as-default')
                                                    </button>
                                                </a>
                                            </x-shop::dropdown.menu.item>
                                        @endif
                                    </x-slot>
                                </x-shop::dropdown>
                            </div>
                        </div>

                        <p class="mt-3 text-sm leading-relaxed text-gray-500" style="color: #71717a" v-pre>
                            {{ $address->address }},
                            {{ $address->city }},
                            {{ $address->state }}, {{ $address->country }},
                            {{ $address->postcode }}
                        </p>
                    </div>
                @endforeach
            </div>

            {!! view_render_event('bagisto.shop.customers.account.addresses.list.after', ['addresses' => $addresses]) !!}

        @else
            <div class="grid w-full place-content-center items-center justify-items-center py-20 text-center">
                <img
                    class="max-md:h-[80px] max-md:w-[80px]"
                    src="{{ bagisto_asset('images/no-address.png') }}"
                    alt="Empty Address"
                >
                <p class="mt-3 text-sm text-gray-500">
                    @lang('shop::app.customers.account.addresses.index.empty-address')
                </p>
            </div>
        @endif
        </div>
    </div>
</x-shop::layouts.account>
