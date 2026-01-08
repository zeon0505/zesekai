@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-white/5 border-white/10 text-white focus:border-red-600 focus:ring-red-600/20 rounded-xl shadow-sm transition duration-300']) !!}>
