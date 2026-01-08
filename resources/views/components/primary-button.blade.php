<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-gradient-to-br from-[#8b0000] to-[#cc0000] border border-transparent rounded-xl font-black text-xs text-white uppercase tracking-widest hover:brightness-125 focus:brightness-125 active:brightness-90 transition ease-in-out duration-150 shadow-lg shadow-red-900/20']) }}>
    {{ $slot }}
</button>
