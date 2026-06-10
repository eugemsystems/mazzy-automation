<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.orders.title')
    </x-slot>

    <!-- Breadcrumbs -->
    @if ((core()->getConfigData('general.general.breadcrumbs.shop')))
        @section('breadcrumbs')
            <x-shop::breadcrumbs name="orders" />
        @endSection
    @endif

    <div class="max-md:hidden">
        <x-shop::layouts.account.navigation />
    </div>

    <div class="flex-auto min-w-0 overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm max-md:mx-0 max-md:rounded-none max-md:border-x-0 max-md:shadow-none">
        <div class="flex items-center justify-between border-b border-zinc-100 px-6 py-4 max-sm:px-4">
            <div class="flex items-center gap-2">
                <a class="flex md:hidden" href="{{ route('shop.customers.account.index') }}">
                    <span class="icon-arrow-left rtl:icon-arrow-right text-2xl"></span>
                </a>
                <h2 class="text-base font-semibold text-zinc-900">
                    @lang('shop::app.customers.account.orders.title')
                </h2>
            </div>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.orders.list.before') !!}

        <!-- For Desktop View -->
        <div class="max-md:hidden">
            <x-shop::datagrid :src="route('shop.customers.account.orders.index')" />
        </div>

        <!-- For Mobile View -->
        <div class="md:hidden">
            <x-shop::datagrid :src="route('shop.customers.account.orders.index')">
                <!-- Datagrid Header -->
                <template #header="{
                    isLoading,
                    available,
                    applied,
                    selectAll,
                    sort,
                    performAction
                }">
                    <div class="hidden"></div>
                </template>

                <template #body="{
                    isLoading,
                    available,
                    applied,
                    selectAll,
                    sort,
                    performAction
                }">
                    <template v-if="isLoading">
                        <x-shop::shimmer.datagrid.table.body />
                    </template>
    
                    <template v-else>
                        <template v-for="record in available.records">
                            <div class="w-full p-4 border rounded-md transition-all hover:bg-gray-50 [&>*]:border-0 mb-4 last:mb-0">
                                <a :href="record.actions[0].url">
                                    <div class="flex justify-between">
                                        <div class="text-sm font-semibold">
                                            @lang('shop::app.customers.account.orders.order-id'): #@{{ record.id }}
    
                                            <p class="text-xs font-normal text-neutral-500">
                                                @{{ record.created_at }}
                                            </p>
                                        </div>
    
                                        <p v-html="record.status"></p>
                                    </div>
        
                                    <div class="mt-2.5 text-xs font-normal text-neutral-500">
                                        @lang('shop::app.customers.account.orders.subtotal')
    
                                        <p class="text-xl font-semibold text-black">
                                            @{{ record.grand_total }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </template>
                    </template>
                </template>
            </x-shop::datagrid>
        </div>
    
        {!! view_render_event('bagisto.shop.customers.account.orders.list.after') !!}

    </div>
</x-shop::layouts.account>
