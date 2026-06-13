@props([
    'name' => null,
    'controlName' => null,
])

<v-error-message
    {{ $attributes }}
    name="{{ $name ?? $controlName }}"
    v-slot="{ message }"
>
    <p
        {{ $attributes->merge(['class' => 'mt-1.5 flex items-center gap-1 text-xs font-medium text-red-500']) }}
        v-text="message"
    >
    </p>
</v-error-message>
