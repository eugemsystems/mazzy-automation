<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="@lang('shop::app.customers.login-form.page-title')"/>

    <meta name="keywords" content="@lang('shop::app.customers.login-form.page-title')"/>
@endPush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.login-form.page-title')
    </x-slot>

    <div class="flex min-h-screen items-center justify-center bg-slate-50 px-4 py-12">
        <div class="w-full max-w-md">
            {!! view_render_event('bagisto.shop.customers.login.logo.before') !!}

            <!-- Company Logo -->
            <div class="mb-8 flex justify-center">
                <a
                    href="{{ route('shop.home.index') }}"
                    aria-label="@lang('shop::app.customers.login-form.bagisto')"
                >
                    <img
                        src="{{ core()->getCurrentChannel()->logo_url ?? asset('themes/shop/konta/img/logo-shop.png') }}"
                        alt="{{ config('app.name') }}"
                        width="131"
                        height="29"
                    >
                </a>
            </div>

            {!! view_render_event('bagisto.shop.customers.login.logo.after') !!}

            <!-- Form Container -->
            <div class="rounded-2xl border border-slate-100 bg-white p-8 shadow-sm max-sm:p-6">
                <h1 class="text-2xl font-bold text-slate-900">
                    @lang('shop::app.customers.login-form.page-title')
                </h1>

                <p class="mt-1.5 text-sm text-slate-500">
                    @lang('shop::app.customers.login-form.form-login-text')
                </p>

                {!! view_render_event('bagisto.shop.customers.login.before') !!}

                <div class="mt-7">
                    <x-shop::form :action="route('shop.customer.session.create')">

                        {!! view_render_event('bagisto.shop.customers.login_form_controls.before') !!}

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

                        <!-- Password -->
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required">
                                @lang('shop::app.customers.login-form.password')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="password"
                                id="password"
                                name="password"
                                rules="required|min:6"
                                value=""
                                :label="trans('shop::app.customers.login-form.password')"
                                :placeholder="trans('shop::app.customers.login-form.password')"
                                :aria-label="trans('shop::app.customers.login-form.password')"
                                aria-required="true"
                            />

                            <x-shop::form.control-group.error control-name="password" />
                        </x-shop::form.control-group>

                        <div class="flex items-center justify-between">
                            <div class="flex select-none items-center gap-2">
                                <input
                                    type="checkbox"
                                    id="show-password"
                                    class="h-4 w-4 cursor-pointer rounded border-slate-300 accent-[#332a5e]"
                                    onchange="switchVisibility()"
                                />

                                <label
                                    class="cursor-pointer select-none text-sm text-slate-500"
                                    for="show-password"
                                >
                                    @lang('shop::app.customers.login-form.show-password')
                                </label>
                            </div>

                            <div class="block">
                                <a
                                    href="{{ route('shop.customers.forgot_password.create') }}"
                                    class="cursor-pointer text-sm font-medium text-[#332a5e] transition hover:underline"
                                >
                                    <span>
                                        @lang('shop::app.customers.login-form.forgot-pass')
                                    </span>
                                </a>
                            </div>
                        </div>

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
                                @lang('shop::app.customers.login-form.button-title')
                            </button>

                            {!! view_render_event('bagisto.shop.customers.login_form_controls.after') !!}
                        </div>
                    </x-shop::form>
                </div>

                {!! view_render_event('bagisto.shop.customers.login.after') !!}

                @if (
                    request()->cookie('enable-resend')
                    && request()->cookie('email-for-resend')
                )
                    <p class="mt-6 text-center text-sm font-medium text-slate-500">
                        <a
                            class="text-[#332a5e] hover:underline"
                            href="{{ route('shop.customers.resend.verification_email', urlencode(request()->cookie('email-for-resend'))) }}"
                        >
                            @lang('shop::app.customers.login-form.resend-verification')
                        </a>
                    </p>
                @endif

                <p class="mt-6 text-center text-sm font-medium text-slate-500">
                    @lang('shop::app.customers.login-form.new-customer')

                    <a
                        class="text-[#332a5e] hover:underline"
                        href="{{ route('shop.customers.register.index') }}"
                    >
                        @lang('shop::app.customers.login-form.create-your-account')
                    </a>
                </p>
            </div>

            <p class="mt-8 text-center text-xs text-slate-400">
                @lang('shop::app.customers.login-form.footer', ['current_year'=> date('Y'), 'company_name' => config('app.name') ])
            </p>
        </div>
    </div>

    @push('scripts')
        {!! \Webkul\Customer\Facades\Captcha::renderJS() !!}

        <script>
            function switchVisibility() {
                let passwordField = document.getElementById("password");

                passwordField.type = passwordField.type === "password"
                    ? "text"
                    : "password";
            }
        </script>
    @endpush
</x-shop::layouts>
