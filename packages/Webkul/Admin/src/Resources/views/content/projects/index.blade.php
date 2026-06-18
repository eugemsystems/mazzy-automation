<x-admin::layouts>
    <x-slot:title>Projects</x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="text-xl font-bold text-gray-800 dark:text-white">Projects</p>
        <a href="{{ route('admin.content.projects.create') }}" class="primary-button">Add Project</a>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded bg-green-50 p-3 text-sm text-green-700 dark:bg-green-900/20 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
        Projects are shown on the <a href="{{ route('shop.home.projects') }}" target="_blank" class="underline">Projects page</a> of the main site.
    </p>

    <div class="box-shadow relative mt-4 rounded bg-white dark:bg-gray-900">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Images</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Title</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Description</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Images #</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Order</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Active</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-4 py-3">
                                <span class="rounded bg-blue-100 px-2 py-0.5 text-xs text-blue-700 dark:bg-blue-900 dark:text-blue-300">
                                    {{ $project->images_count }} photo{{ $project->images_count !== 1 ? 's' : '' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-800 dark:text-white">{{ $project->title }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ Str::limit(strip_tags($project->description), 60) ?: '—' }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $project->images_count }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $project->sort_order }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded px-2 py-0.5 text-xs {{ $project->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $project->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.content.projects.edit', $project->id) }}"
                                       class="cursor-pointer rounded bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-300">
                                        Edit
                                    </a>
                                    <button
                                        type="button"
                                        class="cursor-pointer rounded bg-red-100 px-3 py-1 text-xs font-medium text-red-700 hover:bg-red-200 dark:bg-red-900 dark:text-red-300"
                                        onclick="if(confirm('Delete this project and all its images?')) { fetch('{{ route('admin.content.projects.destroy', $project->id) }}', {method:'DELETE', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}}).then(()=>location.reload()); }">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-gray-500">No projects yet. Click "Add Project" to create one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin::layouts>
