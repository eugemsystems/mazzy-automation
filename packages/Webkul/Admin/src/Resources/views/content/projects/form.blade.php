<x-admin::layouts>
    <x-slot:title>{{ $project->exists ? 'Edit Project' : 'Add Project' }}</x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            {{ $project->exists ? 'Edit Project' : 'Add Project' }}
        </p>
        <a href="{{ route('admin.content.projects.index') }}" class="secondary-button">Back</a>
    </div>

    <form
        action="{{ $project->exists ? route('admin.content.projects.update', $project->id) : route('admin.content.projects.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="mt-4"
    >
        @csrf
        @if ($project->exists)
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

                {{-- Title --}}
                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Project Title *</label>
                    <input type="text" name="title" value="{{ old('title', $project->title) }}" required
                           class="w-full rounded border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300"
                           placeholder="E.g. Sandton Smart Home Installation">
                </div>

                {{-- Description --}}
                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Description (optional)</label>
                    <textarea name="description" rows="4"
                              class="w-full rounded border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300"
                              placeholder="Describe the project, location, technologies used...">{{ old('description', $project->description) }}</textarea>
                </div>

                {{-- Sort Order --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}" min="0"
                           class="w-full rounded border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                </div>

                {{-- Active --}}
                <div class="flex items-center gap-3 pt-5">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" id="is_active"
                           {{ old('is_active', $project->is_active ?? true) ? 'checked' : '' }}
                           class="h-4 w-4 rounded border-gray-300">
                    <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Active (show on Projects page)</label>
                </div>

            </div>

            {{-- Image Upload --}}
            <div class="mt-6">
                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Upload Project Photos
                </label>
                <input type="file" name="images[]" accept="image/*" multiple
                       class="w-full rounded border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                <p class="mt-1 text-xs text-gray-500">Select multiple images. JPG, PNG, WebP — max 10MB each.</p>
            </div>

            {{-- Existing Images --}}
            @if ($project->exists && $project->images->count())
                <div class="mt-6">
                    <p class="mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">Current Photos (click × to remove)</p>
                    <div class="flex flex-wrap gap-3" id="existing-images">
                        @foreach ($project->images as $img)
                            <div class="relative" id="img-{{ $img->id }}">
                                <img src="{{ Storage::disk('public')->url($img->image_path) }}"
                                     alt="{{ $img->caption }}"
                                     class="h-24 w-32 rounded object-cover shadow">
                                <button
                                    type="button"
                                    onclick="deleteImage({{ $img->id }})"
                                    class="absolute -right-2 -top-2 flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-xs text-white hover:bg-red-700"
                                    title="Remove">×</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mt-6 flex gap-3">
                <button type="submit" class="primary-button">
                    {{ $project->exists ? 'Save Changes' : 'Create Project' }}
                </button>
                <a href="{{ route('admin.content.projects.index') }}" class="secondary-button">Cancel</a>
            </div>
        </div>
    </form>

    <script>
        function deleteImage(imageId) {
            if (!confirm('Remove this image?')) return;
            fetch('/{{ config('app.admin_url') }}/content/projects/images/' + imageId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            }).then(function(r) {
                if (r.ok) {
                    var el = document.getElementById('img-' + imageId);
                    if (el) el.remove();
                }
            });
        }
    </script>
</x-admin::layouts>
