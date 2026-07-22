@props(['product'])

<x-shop::modal>
    <x-slot:toggle>
        <button
            type="button"
            class="w-full max-w-full rounded-lg bg-[#FF9923] px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-[#332a5e]"
        >
            @lang('shop::app.products.view.enquire-now')
        </button>
    </x-slot>

    <x-slot:header>
        @lang('shop::app.products.view.enquire-now')
    </x-slot>

    <x-slot:content>
        <x-shop::form :action="route('shop.products.enquire.send_mail')">
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <p class="mb-4 text-sm text-slate-500">
                {{ $product->name }}
            </p>

            <div class="mb-4">
                <x-shop::form.control-group.control
                    type="text"
                    name="name"
                    rules="required"
                    label="{{ trans('shop::app.products.view.enquiry-name') }}"
                    :placeholder="trans('shop::app.products.view.enquiry-name')"
                    :value="old('name')"
                />
                <x-shop::form.control-group.error control-name="name" />
            </div>

            <div class="mb-4">
                <x-shop::form.control-group.control
                    type="email"
                    name="email"
                    rules="required|email"
                    label="{{ trans('shop::app.products.view.enquiry-email') }}"
                    :placeholder="trans('shop::app.products.view.enquiry-email')"
                    :value="old('email')"
                />
                <x-shop::form.control-group.error control-name="email" />
            </div>

            <div class="mb-4">
                <x-shop::form.control-group.control
                    type="text"
                    name="phone"
                    rules="phone"
                    label="{{ trans('shop::app.products.view.enquiry-phone') }}"
                    :placeholder="trans('shop::app.products.view.enquiry-phone')"
                    :value="old('phone')"
                />
                <x-shop::form.control-group.error control-name="phone" />
            </div>

            <div class="mb-4">
                <x-shop::form.control-group.control
                    type="textarea"
                    name="message"
                    rules="required"
                    label="{{ trans('shop::app.products.view.enquiry-message') }}"
                    :placeholder="trans('shop::app.products.view.enquiry-message-placeholder')"
                    rows="4"
                />
                <x-shop::form.control-group.error control-name="message" />
            </div>

            <button
                type="submit"
                class="primary-button w-full max-w-full !py-2.5 !px-5 !rounded-lg text-sm"
            >
                @lang('shop::app.products.view.enquiry-submit')
            </button>
        </x-shop::form>
    </x-slot>
</x-shop::modal>
