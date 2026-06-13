@props([
    'type' => 'text',
    'name' => '',
])

@switch($type)
    @case('hidden')
    @case('text')
    @case('email')
    @case('password')
    @case('number')
        <v-field
            v-slot="{ field, errors }"
            {{ $attributes->only(['name', ':name', 'value', ':value', 'v-model', 'rules', ':rules', 'label', ':label']) }}
            name="{{ $name }}"
        >
            <input
                type="{{ $type }}"
                name="{{ $name }}"
                v-bind="field"
                :class="[errors.length ? '!border-red-400 focus:!border-red-400 focus:!ring-red-500/10' : '']"
                {{ $attributes->except(['value', ':value', 'v-model', 'rules', ':rules', 'label', ':label'])->merge(['class' => 'block h-auto w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#332a5e] focus:outline-none focus:ring-4 focus:ring-[#332a5e]/10']) }}
            >
        </v-field>
        @break

    @case('file')
        <v-field
            v-slot="{ field, errors }"
            {{ $attributes->only(['name', ':name', 'value', ':value', 'v-model', 'rules', ':rules', ':rules', 'label', ':label']) }}
            name="{{ $name }}"
        >
            <input
                type="{{ $type }}"
                name="{{ $name }}"
                :class="[errors.length ? '!border-red-400 focus:!border-red-400 focus:!ring-red-500/10' : '']"
                {{ $attributes->except(['value', ':value', 'v-model', 'rules', ':rules', 'label', ':label'])->merge(['class' => 'block h-auto w-full rounded-lg border border-slate-200 bg-white text-sm text-slate-600 shadow-sm transition file:mr-3 file:cursor-pointer file:border-0 file:bg-slate-50 file:px-3.5 file:py-2.5 file:text-sm file:font-medium file:text-slate-700 hover:border-slate-300 focus:border-[#332a5e] focus:outline-none focus:ring-4 focus:ring-[#332a5e]/10']) }}
            >
        </v-field>
        @break

    @case('color')
        <v-field
            v-slot="{ field, errors }"
            {{ $attributes->except('class') }}
            name="{{ $name }}"
        >
            <input
                type="{{ $type }}"
                :class="[errors.length ? '!border-red-400' : '']"
                v-bind="field"
                {{ $attributes->except(['value'])->merge(['class' => 'h-11 w-full cursor-pointer appearance-none rounded-lg border border-slate-200 bg-white p-1 shadow-sm transition hover:border-slate-300']) }}
            >
        </v-field>
        @break

    @case('textarea')
        <v-field
            v-slot="{ field, errors }"
            {{ $attributes->only(['name', ':name', 'value', ':value', 'v-model', 'rules', ':rules', 'label', ':label']) }}
            name="{{ $name }}"
        >
            <textarea
                type="{{ $type }}"
                name="{{ $name }}"
                v-bind="field"
                :class="[errors.length ? '!border-red-400 focus:!border-red-400 focus:!ring-red-500/10' : '']"
                {{ $attributes->except(['value', ':value', 'v-model', 'rules', ':rules', 'label', ':label'])->merge(['class' => 'block h-auto w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#332a5e] focus:outline-none focus:ring-4 focus:ring-[#332a5e]/10']) }}
            >
            </textarea>

            @if ($attributes->get('tinymce', false) || $attributes->get(':tinymce', false))
                <x-shop::tinymce
                    :selector="'textarea#' . $attributes->get('id')"
                    :prompt="stripcslashes($attributes->get('prompt', ''))"
                    ::field="field"
                >
                </x-shop::tinymce>
            @endif
        </v-field>
        @break

    @case('date')
        <v-field
            v-slot="{ field, errors }"
            {{ $attributes->only(['name', ':name', 'value', ':value', 'v-model', 'rules', ':rules', 'label', ':label']) }}
            name="{{ $name }}"
        >
            <x-shop::flat-picker.date {{ $attributes }}>
                <input
                    name="{{ $name }}"
                    v-bind="field"
                    :class="[errors.length ? '!border-red-400 focus:!border-red-400 focus:!ring-red-500/10' : '']"
                    {{ $attributes->except(['value', ':value', 'v-model', 'rules', ':rules', 'label', ':label'])->merge(['class' => 'block h-auto w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#332a5e] focus:outline-none focus:ring-4 focus:ring-[#332a5e]/10']) }}
                    autocomplete="off"
                >
            </x-shop::flat-picker.date>
        </v-field>
        @break

    @case('datetime')
        <v-field
            v-slot="{ field, errors }"
            {{ $attributes->only(['name', ':name', 'value', ':value', 'v-model', 'rules', ':rules', 'label', ':label']) }}
            name="{{ $name }}"
        >
            <x-shop::flat-picker.datetime>
                <input
                    name="{{ $name }}"
                    v-bind="field"
                    :class="[errors.length ? '!border-red-400 focus:!border-red-400 focus:!ring-red-500/10' : '']"
                    {{ $attributes->except(['value', ':value', 'v-model', 'rules', ':rules', 'label', ':label'])->merge(['class' => 'block h-auto w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#332a5e] focus:outline-none focus:ring-4 focus:ring-[#332a5e]/10']) }}
                    autocomplete="off"
                >
            </x-shop::flat-picker.datetime>
        </v-field>
        @break

    @case('select')
        <v-field
            v-slot="{ field, errors }"
            {{ $attributes->only(['name', ':name', 'value', ':value', 'v-model', 'rules', ':rules', 'label', ':label']) }}
            name="{{ $name }}"
        >
            <select
                name="{{ $name }}"
                v-bind="field"
                :class="[errors.length ? '!border-red-400 focus:!border-red-400 focus:!ring-red-500/10' : '']"
                {{ $attributes->except(['value', ':value', 'v-model', 'rules', ':rules', 'label', ':label'])->merge(['class' => 'custom-select block h-auto w-full cursor-pointer rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition hover:border-slate-300 focus:border-[#332a5e] focus:outline-none focus:ring-4 focus:ring-[#332a5e]/10']) }}
            >
                {{ $slot }}
            </select>
        </v-field>
        @break

    @case('multiselect')
        <v-field
            as="select"
            v-slot="{ value }"
            :class="[errors && errors['{{ $name }}'] ? '!border-red-400' : '']"
            {{ $attributes->except([])->merge(['class' => 'block h-auto w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition hover:border-slate-300 focus:border-[#332a5e] focus:outline-none focus:ring-4 focus:ring-[#332a5e]/10']) }}
            name="{{ $name }}"
            multiple
        >
            {{ $slot }}
        </v-field>
        @break

    @case('checkbox')
        <v-field
            type="checkbox"
            v-slot="{ field }"
            {{ $attributes->only(['name', ':name', 'value', ':value', 'v-model', 'rules', ':rules', 'label', ':label', 'key', ':key']) }}
            name="{{ $name }}"
        >
            <input
                type="checkbox"
                v-bind="field"
                {{ $attributes->except(['rules', 'label', ':label', 'key', ':key'])->merge(['class' => 'h-4 w-4 shrink-0 cursor-pointer rounded border-slate-300 accent-[#332a5e]']) }}
                name="{{ $name }}"
            />
        </v-field>
        @break

    @case('radio')
        <v-field
            type="radio"
            v-slot="{ field }"
            {{ $attributes->only(['name', ':name', 'value', ':value', 'v-model', 'rules', ':rules', 'label', ':label', 'key', ':key']) }}
            name="{{ $name }}"
        >
            <input
                type="radio"
                name="{{ $name }}"
                v-bind="field"
                {{ $attributes->except(['rules', 'label', ':label', 'key', ':key'])->merge(['class' => 'h-4 w-4 shrink-0 cursor-pointer border-slate-300 accent-[#332a5e]']) }}
            />
        </v-field>
        @break

    @case('switch')
        <label class="relative inline-flex cursor-pointer items-center">
            <v-field
                type="checkbox"
                class="hidden"
                v-slot="{ field }"
                {{ $attributes->only(['name', ':name', 'value', ':value', 'v-model', 'rules', ':rules', 'label', ':label', 'key', ':key']) }}
                name="{{ $name }}"
            >
                <input
                    type="checkbox"
                    name="{{ $name }}"
                    id="{{ $name }}"
                    class="peer sr-only"
                    v-bind="field"
                    {{ $attributes->except(['v-model', 'rules', ':rules', 'label', ':label', 'key', ':key']) }}
                />
            </v-field>

            <label
                class="peer h-6 w-11 cursor-pointer rounded-full bg-slate-200 transition-colors after:absolute after:left-0.5 after:top-0.5 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow-sm after:transition-all after:content-[''] peer-checked:bg-[#332a5e] peer-checked:after:translate-x-full peer-focus:ring-4 peer-focus:ring-[#332a5e]/10"
                for="{{ $name }}"
            ></label>
        </label>
        @break

    @case('image')
        <x-shop::media
            ::class="[errors && errors['{{ $name }}'] ? 'border !border-red-500' : '']"
            {{ $attributes }}
            name="{{ $name }}"
        />

        @break

    @case('custom')
        <v-field {{ $attributes }}>
            {{ $slot }}
        </v-field>
@endswitch
