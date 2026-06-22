<x-admin::layouts>
    <!--Page title -->
    <x-slot:title>
        @lang('admin::app.cms.create.title')
    </x-slot>

    <!--Create Page Form -->
    <x-admin::form
        :action="route('admin.cms.store')"
        enctype="multipart/form-data"
    >

        {!! view_render_event('bagisto.admin.cms.pages.create.create_form_controls.before') !!}

        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                @lang('admin::app.cms.create.title')
            </p>


            <div class="flex items-center gap-x-2.5">
                <!-- Back Button -->
                <a
                    href="{{ route('admin.cms.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
                >
                    @lang('admin::app.account.edit.back-btn')
                </a>

                <!--Save Button -->
                <button
                    type="submit"
                    class="primary-button"
                >
                    @lang('admin::app.cms.create.save-btn')
                </button>
            </div>
        </div>

        <!-- body content -->
        <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
            <!-- Left sub-component -->
            <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">

                {!! view_render_event('bagisto.admin.cms.pages.create.card.description.before') !!}

                <!--Content -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('admin::app.cms.create.description')
                    </p>

                    <!-- Html Content -->
                    <x-admin::form.control-group class="!mb-0">
                        <x-admin::form.control-group.label class="required">
                            @lang('admin::app.cms.create.content')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            id="content"
                            name="html_content"
                            rules="required"
                            :value="old('html_content')"
                            :label="trans('admin::app.cms.create.content')"
                            :placeholder="trans('admin::app.cms.create.content')"
                            :tinymce="true"
                        />

                        <x-admin::form.control-group.error control-name="html_content" />
                    </x-admin::form.control-group>
                </div>

                {!! view_render_event('bagisto.admin.cms.pages.create.card.description.after') !!}

                {!! view_render_event('bagisto.admin.cms.pages.create.card.seo.before') !!}

                <!-- SEO Input Fields -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('admin::app.cms.create.seo')
                    </p>

                    <!-- SEO Title & Description Blade Component -->
                    <x-admin::seo
                        slug="page"
                        meta-title-field="meta_title"
                        url-key-field="url_key"
                        meta-description-field="meta_description"
                    />

                    <!-- Meta Title -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('admin::app.cms.create.meta-title')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            id="meta_title"
                            name="meta_title"
                            :value="old('meta_title')"
                            :label="trans('admin::app.cms.create.meta-title')"
                            :placeholder="trans('admin::app.cms.create.meta-title')"
                        />

                        <x-admin::form.control-group.error control-name="meta_title" />
                    </x-admin::form.control-group>

                    <!-- URL Key -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('admin::app.cms.create.url-key')
                            <span class="text-xs font-normal text-gray-400 ml-1">(auto-generated from title)</span>
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            id="url_key"
                            name="url_key"
                            :value="old('url_key')"
                            :label="trans('admin::app.cms.create.url-key')"
                            placeholder="leave blank to auto-generate"
                        />

                        <x-admin::form.control-group.error control-name="url_key" />
                    </x-admin::form.control-group>

                    <!-- Meta Keywords -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('admin::app.cms.create.meta-keywords')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            id="meta_keywords"
                            name="meta_keywords"
                            :value="old('meta_keywords')"
                            :label="trans('admin::app.cms.create.meta-keywords')"
                            :placeholder="trans('admin::app.cms.create.meta-keywords')"
                        />

                        <x-admin::form.control-group.error control-name="meta_keywords" />
                    </x-admin::form.control-group>

                    <!-- Meta Description -->
                    <x-admin::form.control-group class="!mb-0">
                        <x-admin::form.control-group.label>
                            @lang('admin::app.cms.create.meta-description')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            id="meta_description"
                            name="meta_description"
                            :value="old('meta_description')"
                            :label="trans('admin::app.cms.create.meta-description')"
                            :placeholder="trans('admin::app.cms.create.meta-description')"
                        />

                        <x-admin::form.control-group.error control-name="meta_description" />
                    </x-admin::form.control-group>
                </div>

                {!! view_render_event('bagisto.admin.cms.pages.create.card.seo.after') !!}
            </div>

            <!-- Right sub-component -->
            <div class="flex w-[360px] max-w-full flex-col gap-2 max-sm:w-full">
                <!-- General -->

                {!! view_render_event('bagisto.admin.cms.pages.create.card.accordion.general.before') !!}

                <x-admin::accordion>
                    <x-slot:header>
                        <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                            @lang('admin::app.cms.create.general')
                        </p>
                    </x-slot>

                    <x-slot:content>
                        <!-- Page Title -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.cms.create.page-title')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                id="page_title"
                                name="page_title"
                                rules="required"
                                :value="old('page_title')"
                                :label="trans('admin::app.cms.create.page-title')"
                                :placeholder="trans('admin::app.cms.create.page-title')"
                            />

                            <x-admin::form.control-group.error control-name="page_title" />
                        </x-admin::form.control-group>

                        <!-- Select Channels -->
                        <x-admin::form.control-group.label>
                            @lang('admin::app.cms.create.channels')
                        </x-admin::form.control-group.label>

                        @php $defaultChannelId = core()->getDefaultChannel()->id; @endphp

                        @foreach(core()->getAllChannels() as $channel)
                            <x-admin::form.control-group class="!mb-2 flex select-none items-center gap-2.5 last:!mb-0">
                                <x-admin::form.control-group.control
                                    type="checkbox"
                                    :id="'channels_' . $channel->id"
                                    name="channels[]"
                                    :value="$channel->id"
                                    :for="'channels_' . $channel->id"
                                    :label="trans('admin::app.cms.create.channels')"
                                    :checked="$channel->id === $defaultChannelId"
                                />

                                <label
                                    class="cursor-pointer text-xs font-medium text-gray-600 dark:text-gray-300"
                                    for="channels_{{ $channel->id }}"
                                    v-pre
                                >
                                    {{ core()->getChannelName($channel) }}
                                </label>
                            </x-admin::form.control-group>
                        @endforeach

                        <x-admin::form.control-group.error control-name="channels[]" />
                    </x-slot>
                </x-admin::accordion>

                {!! view_render_event('bagisto.admin.cms.pages.create.card.accordion.general.after') !!}

                <!-- Solutions Menu Settings -->
                <x-admin::accordion>
                    <x-slot:header>
                        <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                            Solutions Menu
                        </p>
                    </x-slot>

                    <x-slot:content>
                        <x-admin::form.control-group class="!mb-4">
                            <div class="flex items-center justify-between gap-2.5">
                                <div>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white">Show in Solutions Menu</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">This page will appear in the Solutions dropdown in the site navigation.</p>
                                </div>

                                <x-admin::form.control-group.control
                                    type="switch"
                                    name="show_in_solutions"
                                    id="show_in_solutions"
                                    :value="1"
                                    :checked="false"
                                />
                            </div>
                        </x-admin::form.control-group>

                        <x-admin::form.control-group class="!mb-4">
                            <x-admin::form.control-group.label>
                                Menu Label <span class="text-xs text-gray-400">(optional — uses page title if blank)</span>
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="menu_label"
                                :value="old('menu_label')"
                                placeholder="Label shown in the nav menu"
                            />
                        </x-admin::form.control-group>

                        <x-admin::form.control-group class="!mb-4">
                            <x-admin::form.control-group.label>
                                Parent Menu Item <span class="text-xs text-gray-400">(for sub-menus)</span>
                            </x-admin::form.control-group.label>

                            <select
                                name="parent_id"
                                class="w-full rounded border border-gray-300 px-3 py-2 text-sm text-gray-700 focus:border-gray-400 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300"
                            >
                                <option value="">— None (top-level item) —</option>
                                @foreach(\Webkul\CMS\Models\Page::where('show_in_solutions', true)->whereNull('parent_id')->orderBy('sort_order')->orderBy('id')->get() as $parentPage)
                                    <option value="{{ $parentPage->id }}">{{ $parentPage->menu_label ?: $parentPage->page_title }}</option>
                                @endforeach
                            </select>
                        </x-admin::form.control-group>

                        <x-admin::form.control-group class="!mb-0">
                            <x-admin::form.control-group.label>Sort Order</x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="sort_order"
                                :value="old('sort_order', 0)"
                                placeholder="0"
                            />
                        </x-admin::form.control-group>
                    </x-slot>
                </x-admin::accordion>

            </div>
        </div>

        {!! view_render_event('bagisto.admin.cms.pages.create.create_form_controls.after') !!}

    </x-admin::form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var titleInput = document.getElementById('page_title');
        var slugInput  = document.getElementById('url_key');

        if (!titleInput || !slugInput) return;

        var userEditedSlug = slugInput.value.length > 0;

        slugInput.addEventListener('input', function () {
            userEditedSlug = slugInput.value.length > 0;
        });

        titleInput.addEventListener('input', function () {
            if (userEditedSlug) return;
            slugInput.value = titleInput.value
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        });
    });
</script>
@endpush
</x-admin::layouts>
