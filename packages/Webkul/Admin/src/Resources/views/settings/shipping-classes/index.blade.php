<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.settings.shipping-classes.index.title')
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('admin::app.settings.shipping-classes.index.title')
        </p>

        @if (bouncer()->hasPermission('settings.shipping_classes.create'))
            <a href="{{ route('admin.settings.shipping_classes.create') }}">
                <div class="primary-button">
                    @lang('admin::app.settings.shipping-classes.index.create-btn')
                </div>
            </a>
        @endif
    </div>

    <x-admin::datagrid :src="route('admin.settings.shipping_classes.index')" />
</x-admin::layouts>
