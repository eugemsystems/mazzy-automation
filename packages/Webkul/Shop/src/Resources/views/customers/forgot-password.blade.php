<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="@lang('shop::app.customers.forgot-password.title')"/>

    <meta name="keywords" content="@lang('shop::app.customers.forgot-password.title')"/>
@endPush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.forgot-password.title')
    </x-slot>

    <div class="flex min-h-screen items-center justify-center bg-slate-50 px-4 py-12">
        <div class="w-full max-w-md">
        {!! view_render_event('bagisto.shop.customers.forget_password.logo.before') !!}

        <!-- Company Logo -->
        <div class="mb-8 flex justify-center">
            <a
                href="{{ route('shop.home.index') }}"
                aria-label="@lang('shop::app.customers.forgot-password.bagisto')"
            >
                <img
                    src="{{ core()->getCurrentChannel()->logo_url ?? asset('themes/shop/konta/img/logo-shop.png') }}"
                    alt="{{ config('app.name') }}"
                    width="131"
                    height="29"
                >
            </a>
        </div>

        {!! view_render_event('bagisto.shop.customers.forget_password.logo.after') !!}

        <!-- Form Container -->
        <div
            class="rounded-2xl border border-slate-100 bg-white p-8 shadow-sm max-sm:p-6"
        >
            <h1 class="text-2xl font-bold text-slate-900">
                @lang('shop::app.customers.forgot-password.title')
            </h1>

            <p class="mt-1.5 text-sm text-slate-500">
                @lang('shop::app.customers.forgot-password.forgot-password-text')
            </p>

            {!! view_render_event('bagisto.shop.customers.forget_password.before') !!}

            <div class="mt-7">
                <x-shop::form :action="route('shop.customers.forgot_password.store')">
                    {!! view_render_event('bagisto.shop.customers.forget_password_form_controls.before') !!}

                    <!-- Email -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.login-form.email')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="email"
                            name="email"
                            rules="required|email"
                            value=""
                            :label="trans('shop::app.customers.login-form.email')"
                            placeholder="email@example.com"
                            :aria-label="trans('shop::app.customers.login-form.email')"
                            aria-required="true"
                        />

                        <x-shop::form.control-group.error control-name="email" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.forget_password_form_controls.email.after') !!}

                    <!-- Captcha -->
                    @if (core()->getConfigData('customer.captcha.credentials.status'))
                        <x-shop::form.control-group class="mt-5">
                            {!! \Webkul\Customer\Facades\Captcha::render() !!}

                            <x-shop::form.control-group.error control-name="recaptcha_token" />
                        </x-shop::form.control-group>
                    @endif

                    <!-- Submit Button -->
                    <div class="mt-7">
                        <button
                            class="block w-full rounded-lg bg-[#332a5e] px-6 py-3 text-center text-sm font-semibold text-white transition hover:bg-[#332a5e]/90"
                            type="submit"
                        >
                            @lang('shop::app.customers.forgot-password.submit')
                        </button>
                    </div>

                    <p class="mt-6 text-center text-sm font-medium text-slate-500">
                        @lang('shop::app.customers.forgot-password.back')

                        <a
                            class="text-[#332a5e] hover:underline"
                            href="{{ route('shop.customer.session.index') }}"
                        >
                            @lang('shop::app.customers.forgot-password.sign-in-button')
                        </a>
                    </p>

                    {!! view_render_event('bagisto.shop.customers.forget_password_form_controls.after') !!}

                </x-shop::form>
            </div>

            {!! view_render_event('bagisto.shop.customers.forget_password.after') !!}

        </div>

        <p class="mt-8 text-center text-xs text-slate-400">
            @lang('shop::app.customers.forgot-password.footer', ['current_year'=> date('Y'), 'company_name' => config('app.name') ])
        </p>
        </div>
    </div>

    @push('scripts')
        {!! \Webkul\Customer\Facades\Captcha::renderJS() !!}
    @endpush
</x-shop::layouts>
