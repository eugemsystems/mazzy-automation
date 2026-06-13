<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.profile.index.title')
    </x-slot>

    <!-- Breadcrumbs -->
    @if ((core()->getConfigData('general.general.breadcrumbs.shop')))
        @section('breadcrumbs')
            <x-shop::breadcrumbs name="profile" />
        @endSection
    @endif

    <div class="max-md:hidden">
        <x-shop::layouts.account.navigation />
    </div>

    <div class="flex-auto min-w-0 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm max-md:mx-0 max-md:rounded-none max-md:border-x-0 max-md:shadow-none">
        <!-- Page Header -->
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4 max-sm:px-4">
            <div class="flex items-center gap-2">
                <a class="flex md:hidden" href="{{ route('shop.customers.account.index') }}">
                    <span class="text-2xl icon-arrow-left rtl:icon-arrow-right"></span>
                </a>
                <h2 class="text-base font-semibold text-slate-900">
                    @lang('shop::app.customers.account.profile.index.title')
                </h2>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.edit_button.before') !!}

            <a
                href="{{ route('shop.customers.account.profile.edit') }}"
                class="secondary-button border-slate-200 px-4 py-2 text-sm font-normal"
            >
                @lang('shop::app.customers.account.profile.index.edit')
            </a>

            {!! view_render_event('bagisto.shop.customers.account.profile.edit_button.after') !!}
        </div>

        <div class="p-6 max-sm:p-4">

        <!-- Profile Information Card -->
        <div class="rounded-2xl border border-slate-200 overflow-hidden">
            {!! view_render_event('bagisto.shop.customers.account.profile.first_name.before') !!}

            <div class="grid grid-cols-[2fr_3fr] px-6 py-2.5 border-b border-slate-100 hover:bg-slate-50/50 max-md:px-4">
                <p class="text-sm font-medium text-slate-500">
                    @lang('shop::app.customers.account.profile.index.first-name')
                </p>
                <p class="text-sm font-medium text-slate-900" v-pre>
                    {{ $customer->first_name }}
                </p>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.first_name.after') !!}
            {!! view_render_event('bagisto.shop.customers.account.profile.last_name.before') !!}

            <div class="grid grid-cols-[2fr_3fr] px-6 py-2.5 border-b border-slate-100 hover:bg-slate-50/50 max-md:px-4">
                <p class="text-sm font-medium text-slate-500">
                    @lang('shop::app.customers.account.profile.index.last-name')
                </p>
                <p class="text-sm font-medium text-slate-900" v-pre>
                    {{ $customer->last_name }}
                </p>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.last_name.after') !!}
            {!! view_render_event('bagisto.shop.customers.account.profile.gender.before') !!}

            <div class="grid grid-cols-[2fr_3fr] px-6 py-2.5 border-b border-slate-100 hover:bg-slate-50/50 max-md:px-4">
                <p class="text-sm font-medium text-slate-500">
                    @lang('shop::app.customers.account.profile.index.gender')
                </p>
                <p class="text-sm font-medium text-slate-900" v-pre>
                    {{ $customer->gender ?? '-' }}
                </p>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.gender.after') !!}
            {!! view_render_event('bagisto.shop.customers.account.profile.date_of_birth.before') !!}

            <div class="grid grid-cols-[2fr_3fr] px-6 py-2.5 border-b border-slate-100 hover:bg-slate-50/50 max-md:px-4">
                <p class="text-sm font-medium text-slate-500">
                    @lang('shop::app.customers.account.profile.index.dob')
                </p>
                <p class="text-sm font-medium text-slate-900" v-pre>
                    {{ $customer->date_of_birth ?? '-' }}
                </p>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.date_of_birth.after') !!}
            {!! view_render_event('bagisto.shop.customers.account.profile.email.before') !!}

            <div class="grid grid-cols-[2fr_3fr] px-6 py-2.5 hover:bg-slate-50/50 max-md:px-4">
                <p class="text-sm font-medium text-slate-500">
                    @lang('shop::app.customers.account.profile.index.email')
                </p>
                <p class="text-sm font-medium text-slate-900" v-pre>
                    {{ $customer->email }}
                </p>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.email.after') !!}
        </div>

        {!! view_render_event('bagisto.shop.customers.account.profile.delete.before') !!}

        <!-- Profile Delete -->
        <div class="mt-6">
            <x-shop::form action="{{ route('shop.customers.account.profile.destroy') }}">
                <x-shop::modal>
                    <x-slot:toggle>
                        <button type="button" class="w-full rounded-xl border border-red-200 bg-red-50 px-5 py-2.5 text-sm font-medium text-red-600 transition-colors hover:bg-red-100 max-sm:py-2">
                            @lang('shop::app.customers.account.profile.index.delete-profile')
                        </button>
                    </x-slot>

                    <x-slot:header>
                        <h2 class="text-xl font-semibold max-md:text-base">
                            @lang('shop::app.customers.account.profile.index.enter-password')
                        </h2>
                    </x-slot>

                    <x-slot:content>
                        <x-shop::form.control-group class="!mb-0">
                            <x-shop::form.control-group.control
                                type="password"
                                name="password"
                                rules="required"
                                placeholder="Enter your password"
                            />
                            <x-shop::form.control-group.error
                                class="text-left"
                                control-name="password"
                            />
                        </x-shop::form.control-group>
                    </x-slot>

                    <x-slot:footer>
                        <button
                            type="submit"
                            class="rounded-lg bg-red-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-600"
                        >
                            @lang('shop::app.customers.account.profile.index.delete')
                        </button>
                    </x-slot>
                </x-shop::modal>
            </x-shop::form>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.profile.delete.after') !!}
        </div>{{-- end p-6 --}}
    </div>
</x-shop::layouts.account>
