<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.downloadable-products.name')
    </x-slot>

    <!-- Breadcrumbs -->
    @if ((core()->getConfigData('general.general.breadcrumbs.shop')))
        @section('breadcrumbs')
            <x-shop::breadcrumbs name="downloadable-products" />
        @endSection
    @endif

    <div class="max-md:hidden">
        <x-shop::layouts.account.navigation />
    </div>

    <div class="flex-auto min-w-0 overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm max-md:mx-0 max-md:rounded-none max-md:border-x-0 max-md:shadow-none">
        <div class="flex items-center gap-2 border-b border-zinc-100 px-6 py-4 max-sm:px-4">
            <a class="flex md:hidden" href="{{ route('shop.customers.account.index') }}">
                <span class="icon-arrow-left rtl:icon-arrow-right text-2xl"></span>
            </a>
            <h2 class="text-base font-semibold text-zinc-900">
                @lang('shop::app.customers.account.downloadable-products.name')
            </h2>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.downloadable_products.list.before') !!}

        <!-- For Desktop View -->
        <div class="max-md:hidden">
            <x-shop::datagrid :src="route('shop.customers.account.downloadable_products.index')" />
        </div>

        <!-- For Mobile View -->
        <div class="hidden max-md:block">
            <x-shop::datagrid :src="route('shop.customers.account.downloadable_products.index')">
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
                        <div class="grid gap-4">
                            <template
                                v-for="record in available.records"
                                v-if="available.records.length"
                            >
                                <div class="grid w-full gap-2.5 rounded-md border p-4 transition-all">
                                    <div class="flex justify-between">
                                        <div class="text-sm font-semibold">
                                            <p>@lang('shop::app.customers.account.downloadable-products.orderId'): #@{{ record.increment_id }}</p>

                                            <p class="text-xs font-normal text-neutral-500">
                                                @{{ record.created_at }}
                                            </p>
                                        </div>

                                        <p v-html="record.status"></p>
                                    </div>
            
                                    <div class="text-xs font-normal">
                                        <p
                                            class="text-sm font-semibold text-blue-600"
                                            v-html="record.product_name"
                                        >
                                        </p>

                                        <p><span class="text-neutral-500">@lang('Remaining Downloads'):</span> <span class="font-medium">@{{ record.remaining_downloads }}</span></p>
                                    </div>
                                </div>
                            </template>

                            <template v-else>
                                @{{ available.records.length }} @lang('shop::app.customers.account.downloadable-products.records-found')
                            </template>
                        </div>
                    </template>
                </template>
            </x-shop::datagrid>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.downloadable_products.list.after') !!}

    </div>
</x-shop::layouts.account>