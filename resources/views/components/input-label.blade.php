@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-black text-[10px] tracking-[0.2em] uppercase text-gray-500']) }}>
    {{ $value ?? $slot }}
</label>
