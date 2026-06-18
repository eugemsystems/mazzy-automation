<x-admin::layouts>
    <x-slot:title>{{ $item->exists ? 'Edit Gallery Item' : 'Add Gallery Item' }}</x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            {{ $item->exists ? 'Edit Gallery Item' : 'Add Gallery Item' }}
        </p>
        <a href="{{ route('admin.content.gallery.index') }}" class="secondary-button">Back</a>
    </div>

    <form
        action="{{ $item->exists ? route('admin.content.gallery.update', $item->id) : route('admin.content.gallery.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="mt-4"
    >
        @csrf
        @if ($item->exists)
            @method('PUT')
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded bg-red-50 p-3 text-sm text-red-700 dark:bg-red-900/20 dark:text-red-400">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="box-shadow rounded bg-white p-6 dark:bg-gray-900">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Type --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Type *</label>
                    <select name="type" class="w-full rounded border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300" id="media-type" onchange="toggleSourceFields()">
                        <option value="image" {{ old('type', $item->type) === 'image' ? 'selected' : '' }}>Image</option>
                        <option value="video" {{ old('type', $item->type) === 'video' ? 'selected' : '' }}>Video (embed URL)</option>
                    </select>
                </div>

                {{-- Display On --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Display On *</label>
                    <select name="display_on" class="w-full rounded border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                        <option value="gallery" {{ old('display_on', $item->display_on) === 'gallery' ? 'selected' : '' }}>Gallery page only</option>
                        <option value="our_work" {{ old('display_on', $item->display_on) === 'our_work' ? 'selected' : '' }}>Our Work page only</option>
                        <option value="both" {{ old('display_on', $item->display_on) === 'both' ? 'selected' : '' }}>Both pages</option>
                    </select>
                </div>

                {{-- Title --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Title (optional)</label>
                    <input type="text" name="title" value="{{ old('title', $item->title) }}"
                           class="w-full rounded border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300"
                           placeholder="E.g. Smart Lighting Project">
                </div>

                {{-- Section (for Our Work grouping) --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Section / Category (optional)</label>
                    <input type="text" name="section" value="{{ old('section', $item->section) }}"
                           class="w-full rounded border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300"
                           placeholder="E.g. Smart Lighting Systems">
                    <p class="mt-1 text-xs text-gray-500">Used to group videos on the Our Work page.</p>
                </div>

                {{-- File Upload --}}
                <div id="file-field">
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Upload File (image or video)</label>
                    <input type="file" name="file" accept="image/*,video/*"
                           class="w-full rounded border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                    @if ($item->file_path)
                        <p class="mt-1 text-xs text-green-600">Current file: {{ basename($item->file_path) }} (upload a new one to replace)</p>
                    @endif
                </div>

                {{-- URL --}}
                <div id="url-field">
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        <span id="url-label">Image URL <span class="text-gray-400">(alternative to upload)</span></span>
                    </label>
                    <input type="text" name="url" value="{{ old('url', $item->url) }}"
                           class="w-full rounded border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300"
                           placeholder="https://..." id="url-input">
                    <p class="mt-1 text-xs text-gray-500" id="url-hint">For video: paste the Facebook embed iframe URL (the src= value).</p>
                </div>

                {{-- Sort Order --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" min="0"
                           class="w-full rounded border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                </div>

                {{-- Active --}}
                <div class="flex items-center gap-3 pt-5">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" id="is_active"
                           {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}
                           class="h-4 w-4 rounded border-gray-300">
                    <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Active (show on site)</label>
                </div>

            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="primary-button">
                    {{ $item->exists ? 'Save Changes' : 'Add Item' }}
                </button>
                <a href="{{ route('admin.content.gallery.index') }}" class="secondary-button">Cancel</a>
            </div>
        </div>
    </form>

    <script>
        function toggleSourceFields() {
            var type = document.getElementById('media-type').value;
            var urlHint = document.getElementById('url-hint');
            var urlLabel = document.getElementById('url-label');
            var urlInput = document.getElementById('url-input');

            if (type === 'video') {
                urlLabel.innerHTML = 'Video Embed URL <span class="text-red-500">*</span>';
                urlHint.textContent = 'Paste the Facebook/YouTube embed URL (the src= value from the iframe).';
                document.getElementById('file-field').style.display = 'none';
            } else {
                urlLabel.innerHTML = 'Image URL <span class="text-gray-400">(alternative to upload)</span>';
                urlHint.textContent = 'Optional: provide a URL instead of uploading a file.';
                document.getElementById('file-field').style.display = '';
            }
        }
        toggleSourceFields();
    </script>
</x-admin::layouts>
