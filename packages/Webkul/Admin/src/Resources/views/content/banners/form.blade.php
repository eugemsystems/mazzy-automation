<x-admin::layouts>
    <x-slot:title>{{ $banner->exists ? 'Edit Banner' : 'Add Banner' }}</x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            {{ $banner->exists ? 'Edit Home Banner' : 'Add Home Banner' }}
        </p>
        <a href="{{ route('admin.content.banners.index') }}" class="secondary-button">Back</a>
    </div>

    <form
        action="{{ $banner->exists ? route('admin.content.banners.update', $banner->id) : route('admin.content.banners.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="mt-4"
    >
        @csrf
        @if ($banner->exists)
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
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Title *</label>
                    <input type="text" name="title" value="{{ old('title', $banner->title) }}" required
                           class="w-full rounded border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300"
                           placeholder="E.g. Smart Automation Systems Providers">
                </div>

                {{-- Subtitle --}}
                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Subtitle (optional)</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}"
                           class="w-full rounded border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300"
                           placeholder="Supporting text shown below the title">
                </div>

                {{-- Button Text --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Button Text (optional)</label>
                    <input type="text" name="button_text" value="{{ old('button_text', $banner->button_text) }}"
                           class="w-full rounded border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300"
                           placeholder="E.g. More About Us">
                </div>

                {{-- Button URL --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Button URL (optional)</label>
                    <input type="text" name="button_url" value="{{ old('button_url', $banner->button_url) }}"
                           class="w-full rounded border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300"
                           placeholder="/about-us or https://...">
                </div>

                {{-- Image Upload --}}
                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Background Image</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full rounded border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                    @if ($banner->image_path)
                        <div class="mt-2">
                            <img src="{{ Storage::disk('public')->url($banner->image_path) }}" alt="Current banner"
                                 class="h-32 rounded object-cover">
                            <p class="mt-1 text-xs text-gray-500">Upload a new image to replace the current one.</p>
                        </div>
                    @endif
                    <p class="mt-1 text-xs text-gray-500">Recommended size: 1920×700px. Max 10MB (JPG, PNG, WebP).</p>
                </div>

                {{-- Sort Order --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order ?? 0) }}" min="0"
                           class="w-full rounded border border-gray-300 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                    <p class="mt-1 text-xs text-gray-500">Lower number = displayed first.</p>
                </div>

                {{-- Active --}}
                <div class="flex items-center gap-3 pt-5">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" id="is_active"
                           {{ old('is_active', $banner->is_active ?? true) ? 'checked' : '' }}
                           class="h-4 w-4 rounded border-gray-300">
                    <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Active (show on home page)</label>
                </div>

            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="primary-button">
                    {{ $banner->exists ? 'Save Changes' : 'Add Banner' }}
                </button>
                <a href="{{ route('admin.content.banners.index') }}" class="secondary-button">Cancel</a>
            </div>
        </div>
    </form>
</x-admin::layouts>
