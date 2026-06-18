<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.settings.shipping-classes.create.title')
    </x-slot>

    <x-admin::form :action="route('admin.settings.shipping_classes.store')">
        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                @lang('admin::app.settings.shipping-classes.create.title')
            </p>

            <div class="flex items-center gap-x-2.5">
                <a
                    href="{{ route('admin.settings.shipping_classes.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
                >
                    @lang('admin::app.settings.shipping-classes.create.back-btn')
                </a>

                <button type="submit" class="primary-button">
                    @lang('admin::app.settings.shipping-classes.create.save-btn')
                </button>
            </div>
        </div>

        <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
            <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <!-- Code -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('admin::app.settings.shipping-classes.create.code')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="code"
                            rules="required"
                            :value="old('code')"
                            :label="trans('admin::app.settings.shipping-classes.create.code')"
                            :placeholder="trans('admin::app.settings.shipping-classes.create.code')"
                        />

                        <x-admin::form.control-group.error control-name="code" />
                    </x-admin::form.control-group>

                    <!-- Name -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('admin::app.settings.shipping-classes.create.name')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="name"
                            rules="required"
                            :value="old('name')"
                            :label="trans('admin::app.settings.shipping-classes.create.name')"
                            :placeholder="trans('admin::app.settings.shipping-classes.create.name')"
                        />

                        <x-admin::form.control-group.error control-name="name" />
                    </x-admin::form.control-group>

                    <!-- Description -->
                    <x-admin::form.control-group class="!mb-0">
                        <x-admin::form.control-group.label>
                            @lang('admin::app.settings.shipping-classes.create.description')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            name="description"
                            :value="old('description')"
                            :label="trans('admin::app.settings.shipping-classes.create.description')"
                            :placeholder="trans('admin::app.settings.shipping-classes.create.description')"
                        />

                        <x-admin::form.control-group.error control-name="description" />
                    </x-admin::form.control-group>
                </div>
            </div>

            <div class="flex w-[360px] max-w-full flex-col gap-2">
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <!-- Status -->
                    <x-admin::form.control-group class="!mb-0">
                        <x-admin::form.control-group.label>
                            @lang('admin::app.settings.shipping-classes.create.status')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control type="hidden" name="status" value="0" />

                        <x-admin::form.control-group.control
                            type="switch"
                            name="status"
                            value="1"
                            :label="trans('admin::app.settings.shipping-classes.create.status')"
                            :checked="old('status') !== null ? (bool) old('status') : true"
                        />
                    </x-admin::form.control-group>
                </div>
            </div>
        </div>
    </x-admin::form>
</x-admin::layouts>
