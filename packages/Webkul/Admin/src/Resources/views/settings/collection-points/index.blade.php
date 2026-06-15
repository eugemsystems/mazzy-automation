<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.settings.collection-points.index.title')
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('admin::app.settings.collection-points.index.title')
        </p>

        <!-- Create Button -->
        @if (bouncer()->hasPermission('settings.collection_points.create'))
            <a href="{{ route('admin.settings.collection_points.create') }}">
                <div class="primary-button">
                    @lang('admin::app.settings.collection-points.index.create-btn')
                </div>
            </a>
        @endif
    </div>

    {!! view_render_event('bagisto.admin.settings.collection_points.list.before') !!}

    <x-admin::datagrid :src="route('admin.settings.collection_points.index')" />

    {!! view_render_event('bagisto.admin.settings.collection_points.list.after') !!}

</x-admin::layouts>
