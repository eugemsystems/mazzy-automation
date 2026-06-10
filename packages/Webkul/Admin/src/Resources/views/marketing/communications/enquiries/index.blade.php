<x-admin::layouts>
    <x-slot:title>
        Form Submissions
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            Form Submissions
        </p>
    </div>

    <x-admin::datagrid :src="route('admin.marketing.communications.enquiries.index')" />
</x-admin::layouts>
