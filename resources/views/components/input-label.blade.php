@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm text-gray-500 font-bold mb-2']) }}>
    {{ $value ?? $slot }}
</label>
