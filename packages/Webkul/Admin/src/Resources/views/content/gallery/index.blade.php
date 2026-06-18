<x-admin::layouts>
    <x-slot:title>Gallery & Our Work</x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="text-xl font-bold text-gray-800 dark:text-white">Gallery & Our Work Items</p>
        <a href="{{ route('admin.content.gallery.create') }}"
           class="primary-button">
            Add Item
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded bg-green-50 p-3 text-sm text-green-700 dark:bg-green-900/20 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    <div class="box-shadow relative mt-4 rounded bg-white dark:bg-gray-900">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Preview</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Title</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Type</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Display On</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Section</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Order</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Active</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-4 py-3">
                                @if ($item->type === 'image')
                                    @if ($item->file_path)
                                        <img src="{{ asset('storage/' . $item->file_path) }}" alt="" class="h-14 w-20 rounded object-cover">
                                    @elseif ($item->url)
                                        <img src="{{ $item->url }}" alt="" class="h-14 w-20 rounded object-cover">
                                    @endif
                                @else
                                    <div class="flex h-14 w-20 items-center justify-center rounded bg-gray-100 dark:bg-gray-700">
                                        <span class="text-xs text-gray-500">Video</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $item->title ?: '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded px-2 py-0.5 text-xs {{ $item->type === 'image' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                    {{ ucfirst($item->type) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                {{ ['gallery' => 'Gallery', 'our_work' => 'Our Work', 'both' => 'Both'][$item->display_on] }}
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $item->section ?: '—' }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $item->sort_order }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded px-2 py-0.5 text-xs {{ $item->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $item->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.content.gallery.edit', $item->id) }}"
                                       class="cursor-pointer rounded bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-300">
                                        Edit
                                    </a>
                                    <button
                                        type="button"
                                        class="cursor-pointer rounded bg-red-100 px-3 py-1 text-xs font-medium text-red-700 hover:bg-red-200 dark:bg-red-900 dark:text-red-300"
                                        onclick="if(confirm('Delete this item?')) { fetch('{{ route('admin.content.gallery.destroy', $item->id) }}', {method:'DELETE', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}}).then(()=>location.reload()); }">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-10 text-center text-gray-500">No items yet. Click "Add Item" to get started.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin::layouts>
