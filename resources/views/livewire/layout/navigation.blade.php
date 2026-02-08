<nav x-data="{ open: false }" class="fixed w-full top-0 z-[100] px-4 md:px-12 py-4">
    <div class="max-w-7xl mx-auto flex justify-between items-center bg-black/80 backdrop-blur-xl px-8 py-3 border border-white/5 rounded-2xl shadow-2xl">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-2 group">
            @if(\App\Models\Setting::get('site_logo'))
                <img src="{{ \Illuminate\Support\Facades\Storage::url(\App\Models\Setting::get('site_logo')) }}" class="w-7 h-7 rounded-lg object-cover bg-white/5" alt="Logo">
            @else
                <div class="w-7 h-7 bg-gradient-to-br from-[#8b0000] to-[#cc0000] flex items-center justify-center font-black text-sm italic rounded-lg group-hover:rotate-12 transition-transform duration-500 text-white">Z</div>
            @endif
            <span class="text-lg font-black tracking-tighter uppercase text-white">ZESE<span class="text-red-600">KAI</span></span>
        </a>

        <!-- Navigation Links -->
        <div class="hidden md:flex gap-10 font-bold text-gray-400 text-[10px] uppercase tracking-[0.2em]">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-red-600' : '' }} hover:text-white transition-colors">Home</a>
            @auth
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-red-600' : '' }} hover:text-white transition-colors">Dashboard</a>
                @if(!auth()->user()->is_premium)
                    <a href="{{ route('subscription') }}" class="{{ request()->routeIs('subscription') ? 'text-red-600' : '' }} hover:text-white transition-colors">Premium</a>
                @endif
            @endauth
            <a href="{{ route('trending') }}" class="{{ request()->routeIs('trending') ? 'text-red-600' : '' }} hover:text-white transition-colors">Trending</a>
            <a href="{{ route('catalog') }}" class="{{ request()->routeIs('catalog') ? 'text-red-600' : '' }} hover:text-white transition-colors">Catalog</a>
        </div>

        <!-- User Settings -->
        <div class="hidden md:flex items-center gap-6">
            @auth
                <div class="relative" x-data="{ userOpen: false }">
                    <button @click="userOpen = !userOpen" class="flex items-center gap-3 text-[10px] font-black text-gray-300 uppercase tracking-widest hover:text-white transition">
                        <span>{{ auth()->user()->name }}</span>
                        @if(auth()->user()->is_premium)
                            <span class="bg-red-600 text-[8px] px-1.5 py-0.5 rounded italic text-white">PREMIUM</span>
                        @endif
                        <svg class="w-2.5 h-2.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="userOpen" @click.away="userOpen = false" class="absolute right-0 mt-4 w-48 bg-zinc-900 border border-white/5 rounded-xl shadow-2xl py-2 overflow-hidden z-50">
                        @if(auth()->user()->email === 'admin@zesekai.com')
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-[10px] font-bold text-yellow-500 hover:text-yellow-400 hover:bg-white/5 transition uppercase tracking-widest border-b border-white/5">
                                Admin Panel
                            </a>
                        @endif
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-[10px] font-bold text-red-500 hover:text-red-400 hover:bg-white/5 transition uppercase tracking-widest border-b border-white/5">
                            User Dashboard
                        </a>
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-[10px] font-bold text-gray-400 hover:text-white hover:bg-white/5 transition uppercase tracking-widest">
                            Profile
                        </a>
                        <button x-on:click.prevent="$dispatch('open-modal', 'confirm-logout')" class="w-full text-left px-4 py-2 text-[10px] font-bold text-red-600 hover:text-red-400 hover:bg-red-600/5 transition uppercase tracking-widest">
                            Logout
                        </button>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-5">
                    <a href="{{ route('login') }}" class="text-[10px] font-black text-gray-400 hover:text-white transition uppercase tracking-widest">Login</a>
                    <a href="{{ route('register') }}" class="btn-gradient px-6 py-2 rounded-xl font-bold text-[10px] uppercase tracking-widest shadow-xl shadow-red-900/10 text-white">Sign Up</a>
                </div>
            @endauth
        </div>

        <!-- Hamburger -->
        <div class="flex items-center md:hidden">
            <button @click="open = ! open" class="text-gray-400 hover:text-white transition">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Responsive Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden mt-2 bg-black/80 backdrop-blur-xl border border-white/5 rounded-2xl p-4 space-y-4">
        <a href="{{ route('home') }}" class="block text-[10px] font-black {{ request()->routeIs('home') ? 'text-red-600' : 'text-gray-400' }} uppercase tracking-widest">Home</a>
        <a href="{{ route('trending') }}" class="block text-[10px] font-black {{ request()->routeIs('trending') ? 'text-red-600' : 'text-gray-400' }} uppercase tracking-widest">Trending</a>
        <a href="{{ route('catalog') }}" class="block text-[10px] font-black {{ request()->routeIs('catalog') ? 'text-red-600' : 'text-gray-400' }} uppercase tracking-widest">Catalog</a>
        
        @auth
            <a href="{{ route('dashboard') }}" class="block text-[10px] font-black {{ request()->routeIs('dashboard') ? 'text-red-600' : 'text-gray-400' }} uppercase tracking-widest">Dashboard</a>
            @if(!auth()->user()->is_premium)
                <a href="{{ route('subscription') }}" class="block text-[10px] font-black {{ request()->routeIs('subscription') ? 'text-red-600' : 'text-gray-400' }} uppercase tracking-widest">Premium</a>
            @endif
            <a href="{{ route('profile') }}" class="block text-[10px] font-black {{ request()->routeIs('profile') ? 'text-red-600' : 'text-gray-400' }} uppercase tracking-widest">Profile</a>
            <button x-on:click.prevent="$dispatch('open-modal', 'confirm-logout')" class="block w-full text-left text-[10px] font-black text-red-600 uppercase tracking-widest">Logout</button>
        @else
            <a href="{{ route('login') }}" class="block text-[10px] font-black {{ request()->routeIs('login') ? 'text-red-600' : 'text-gray-400' }} uppercase tracking-widest">Login</a>
            <a href="{{ route('register') }}" class="block text-[10px] font-black text-red-600 uppercase tracking-widest">Sign Up</a>
        @endauth
    </div>

    <!-- Livewire Logout Logic is handled by the component -->
    
    <!-- Logout Confirmation Modal -->
    <x-modal name="confirm-logout" :show="false" focusable>
        <div class="p-6 text-center">
            <div class="flex justify-center mb-6">
                <!-- Icon or Character Image -->
                <div class="w-20 h-20 bg-red-600/10 rounded-full flex items-center justify-center border border-red-600/20">
                    <i class="bi bi-box-arrow-right text-4xl text-red-600"></i>
                </div>
            </div>

            <h2 class="text-2xl font-black uppercase tracking-tighter text-white mb-2">
                Leaving so soon?
            </h2>

            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-8">
                Are you sure you want to log out from Zesekai?
            </p>

            <div class="flex justify-center gap-4">
                <button x-on:click="$dispatch('close')" class="px-6 py-3 rounded-xl border border-white/10 text-xs font-bold uppercase tracking-widest text-gray-400 hover:bg-white/5 transition">
                    Cancel
                </button>
                <button wire:click="logout" class="px-6 py-3 rounded-xl bg-red-600 text-xs font-bold uppercase tracking-widest text-white hover:bg-red-700 shadow-lg shadow-red-900/20 transition">
                    Logout
                </button>
            </div>
        </div>
    </x-modal>
</nav>
