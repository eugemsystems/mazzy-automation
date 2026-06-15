<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.settings.collection-points.edit.title')
    </x-slot>

    {!! view_render_event('bagisto.admin.settings.collection_points.edit.before', ['collectionPoint' => $collectionPoint]) !!}

    <x-admin::form
        :action="route('admin.settings.collection_points.update', $collectionPoint->id)"
        method="PUT"
    >

        {!! view_render_event('bagisto.admin.settings.collection_points.edit.edit_form_controls.before', ['collectionPoint' => $collectionPoint]) !!}

        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                @lang('admin::app.settings.collection-points.edit.title')
            </p>

            <div class="flex items-center gap-x-2.5">
                <!-- Back Button -->
                <a
                    href="{{ route('admin.settings.collection_points.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
                >
                    @lang('admin::app.settings.collection-points.edit.back-btn')
                </a>

                <!-- Save Button -->
                <button type="submit" class="primary-button">
                    @lang('admin::app.settings.collection-points.edit.save-btn')
                </button>
            </div>
        </div>

        <!-- Full Panel -->
        <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
            <!-- Left Section -->
            <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
                <!-- General -->
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('admin::app.settings.collection-points.create.general')
                    </p>

                    <!-- Code -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('admin::app.settings.collection-points.create.code')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            id="code"
                            name="code"
                            rules="required"
                            :value="old('code') ?? $collectionPoint->code"
                            :label="trans('admin::app.settings.collection-points.create.code')"
                            :placeholder="trans('admin::app.settings.collection-points.create.code')"
                        />

                        <x-admin::form.control-group.error control-name="code" />
                    </x-admin::form.control-group>

                    <!-- Name -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('admin::app.settings.collection-points.create.name')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            id="name"
                            name="name"
                            rules="required"
                            :value="old('name') ?? $collectionPoint->name"
                            :label="trans('admin::app.settings.collection-points.create.name')"
                            :placeholder="trans('admin::app.settings.collection-points.create.name')"
                        />

                        <x-admin::form.control-group.error control-name="name" />
                    </x-admin::form.control-group>

                    <!-- Description -->
                    <x-admin::form.control-group class="!mb-0">
                        <x-admin::form.control-group.label>
                            @lang('admin::app.settings.collection-points.create.description')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            class="!mb-0 text-gray-600 dark:text-gray-300"
                            id="description"
                            name="description"
                            :value="old('description') ?? $collectionPoint->description"
                            :label="trans('admin::app.settings.collection-points.create.description')"
                            :placeholder="trans('admin::app.settings.collection-points.create.description')"
                        />

                        <x-admin::form.control-group.error control-name="description" />
                    </x-admin::form.control-group>
                </div>

                <!-- Address -->
                <v-collection-point-address></v-collection-point-address>
            </div>

            <!-- Right Section -->
            <div class="flex w-[360px] max-w-full flex-col gap-2">
                <x-admin::accordion>
                    <x-slot:header>
                        <div class="flex items-center justify-between">
                            <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('admin::app.settings.collection-points.create.settings')
                            </p>
                        </div>
                    </x-slot>

                    <x-slot:content>
                        <!-- Contact Number -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label>
                                @lang('admin::app.settings.collection-points.create.contact-number')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                id="contact_number"
                                name="contact_number"
                                :value="old('contact_number') ?? $collectionPoint->contact_number"
                                :label="trans('admin::app.settings.collection-points.create.contact-number')"
                                :placeholder="trans('admin::app.settings.collection-points.create.contact-number')"
                            />

                            <x-admin::form.control-group.error control-name="contact_number" />
                        </x-admin::form.control-group>

                        <!-- Handling Fee -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.settings.collection-points.create.handling-fee')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                id="handling_fee"
                                name="handling_fee"
                                rules="required"
                                :value="old('handling_fee') ?? $collectionPoint->handling_fee"
                                :label="trans('admin::app.settings.collection-points.create.handling-fee')"
                                :placeholder="trans('admin::app.settings.collection-points.create.handling-fee')"
                            />

                            <x-admin::form.control-group.error control-name="handling_fee" />
                        </x-admin::form.control-group>

                        <!-- Status -->
                        <x-admin::form.control-group class="!mb-0">
                            <x-admin::form.control-group.label>
                                @lang('admin::app.settings.collection-points.create.status')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="hidden"
                                name="status"
                                value="0"
                            />

                            <x-admin::form.control-group.control
                                type="switch"
                                name="status"
                                value="1"
                                :label="trans('admin::app.settings.collection-points.create.status')"
                                :checked="(bool) (old('status') ?? $collectionPoint->status)"
                            />

                            <x-admin::form.control-group.error control-name="status" />
                        </x-admin::form.control-group>
                    </x-slot>
                </x-admin::accordion>
            </div>
        </div>

        {!! view_render_event('bagisto.admin.settings.collection_points.edit.edit_form_controls.after', ['collectionPoint' => $collectionPoint]) !!}

    </x-admin::form>

    {!! view_render_event('bagisto.admin.settings.collection_points.edit.after', ['collectionPoint' => $collectionPoint]) !!}

    @include('admin::settings.collection-points.address', [
        'collectionPoint' => $collectionPoint,
    ])
</x-admin::layouts>
