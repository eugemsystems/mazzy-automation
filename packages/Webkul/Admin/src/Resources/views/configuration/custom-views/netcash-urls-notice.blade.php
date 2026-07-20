<div class="mb-4 rounded border border-blue-200 bg-blue-50 p-4 dark:border-blue-800 dark:bg-blue-950">
    <p class="font-semibold text-blue-800 dark:text-blue-400">
        @lang('admin::app.configuration.index.sales.payment-methods.netcash-urls-notice')
    </p>

    <p class="mt-1 text-sm text-blue-700 dark:text-blue-500">
        @lang('admin::app.configuration.index.sales.payment-methods.netcash-urls-notice-info')
    </p>

    <div class="mt-3 grid gap-2 text-sm">
        <div class="flex flex-wrap items-center gap-2">
            <span class="font-medium text-blue-900 dark:text-blue-300">
                @lang('admin::app.configuration.index.sales.payment-methods.accept-url'):
            </span>

            <code class="rounded bg-white px-2 py-1 text-xs text-slate-700 dark:bg-slate-900 dark:text-slate-300">
                {{ route('netcash.accept') }}
            </code>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <span class="font-medium text-blue-900 dark:text-blue-300">
                @lang('admin::app.configuration.index.sales.payment-methods.decline-url'):
            </span>

            <code class="rounded bg-white px-2 py-1 text-xs text-slate-700 dark:bg-slate-900 dark:text-slate-300">
                {{ route('netcash.decline') }}
            </code>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <span class="font-medium text-blue-900 dark:text-blue-300">
                @lang('admin::app.configuration.index.sales.payment-methods.notify-url'):
            </span>

            <code class="rounded bg-white px-2 py-1 text-xs text-slate-700 dark:bg-slate-900 dark:text-slate-300">
                {{ route('netcash.notify') }}
            </code>
        </div>
    </div>
</div>
