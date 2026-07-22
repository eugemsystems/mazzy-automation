{{--
    Vue-bound enquiry form used inside product cards (AJAX submission).
    Must be rendered within a Vue template scope that provides `product`,
    `enquiryForm`, `isSendingEnquiry`, and a `sendEnquiry()` method
    (see v-product-card in components/products/card.blade.php).
--}}
<form @submit.prevent="sendEnquiry()">
    <p class="mb-4 text-sm text-slate-500">
        @{{ product.name }}
    </p>

    <div class="mb-4">
        <label class="mb-1 block text-xs font-medium text-slate-600">
            @lang('shop::app.products.view.enquiry-name')
        </label>
        <input
            type="text"
            v-model="enquiryForm.name"
            required
            class="w-full rounded-md border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-slate-400 focus:outline-none"
        >
    </div>

    <div class="mb-4">
        <label class="mb-1 block text-xs font-medium text-slate-600">
            @lang('shop::app.products.view.enquiry-email')
        </label>
        <input
            type="email"
            v-model="enquiryForm.email"
            required
            class="w-full rounded-md border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-slate-400 focus:outline-none"
        >
    </div>

    <div class="mb-4">
        <label class="mb-1 block text-xs font-medium text-slate-600">
            @lang('shop::app.products.view.enquiry-phone')
        </label>
        <input
            type="text"
            v-model="enquiryForm.phone"
            class="w-full rounded-md border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-slate-400 focus:outline-none"
        >
    </div>

    <div class="mb-4">
        <label class="mb-1 block text-xs font-medium text-slate-600">
            @lang('shop::app.products.view.enquiry-message')
        </label>
        <textarea
            v-model="enquiryForm.message"
            required
            rows="4"
            class="w-full rounded-md border border-slate-200 px-3 py-2 text-sm text-slate-700 focus:border-slate-400 focus:outline-none"
        ></textarea>
    </div>

    <button
        type="submit"
        class="w-full max-w-full rounded-lg bg-[#332a5e] px-5 py-2.5 text-sm text-white transition-colors hover:bg-[#FF9923] disabled:cursor-not-allowed disabled:opacity-50"
        :disabled="isSendingEnquiry"
    >
        @lang('shop::app.products.view.enquiry-submit')
    </button>
</form>
