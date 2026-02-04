<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name', 'Zesekai') }} - Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}?v=1">
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
    
    @php 
        $adsense_client = \App\Models\Setting::get('adsense_client');
        $popunder_code = \App\Models\Setting::get('popunder_code');
        $is_premium = auth()->user()?->is_premium;
    @endphp

    @if(!$is_premium)
        @if($adsense_client)
            <!-- Google AdSense Auto Ads -->
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $adsense_client }}" crossorigin="anonymous"></script>
        @endif
        
        @if($popunder_code)
            <!-- Pop-under Ads (Adsterra/Others) -->
            {!! $popunder_code !!}
        @endif
    @endif

    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #000; color: #fff; }
        
        /* Glassmorphism Sidebar */
        .sidebar-wrapper {
            width: 280px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            background: rgba(10, 10, 10, 0.95);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            transition: all .5s cubic-bezier(0.23, 1, 0.32, 1);
            padding: 2rem;
            overflow-y: auto;
        }

        .main-content {
            margin-left: 280px;
            padding: 2.5rem;
            min-height: 100vh;
            transition: all .5s cubic-bezier(0.23, 1, 0.32, 1);
            background: #000;
            background-image: radial-gradient(circle at 100% 0%, rgba(139, 0, 0, 0.1) 0%, transparent 40%);
        }

        .menu-title {
            font-size: .7rem;
            font-weight: 800;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: .8rem 1rem;
            font-size: 0.9rem;
            color: #aaa;
            border-radius: 12px;
            transition: all .3s;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid transparent;
        }

        .sidebar-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.03);
            border-color: rgba(255, 255, 255, 0.05);
        }

        .sidebar-link i {
            font-size: 1rem;
            margin-right: 1rem;
            color: #666;
            transition: all .3s;
        }

        /* Active State (Red Glow) */
        .sidebar-item.active .sidebar-link {
            background: linear-gradient(135deg, rgba(139,0,0,0.2), rgba(204,0,0,0.1));
            color: #fff;
            border: 1px solid rgba(204,0,0,0.3);
            box-shadow: 0 4px 20px rgba(0,0,0,0.4);
        }

        .sidebar-item.active .sidebar-link i {
            color: #ff4d4d;
        }

        /* Responsive */
        @media screen and (max-width: 1200px) {
            .sidebar-wrapper { left: -280px; }
            .main-content { margin-left: 0; }
            .sidebar-wrapper.active { left: 0; }
            .sidebar-backdrop {
                position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
                background: rgba(0,0,0,0.8); backdrop-filter: blur(5px);
                z-index: 99; display: none;
            }
            .sidebar-backdrop.show { display: block; }
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #000; }
        ::-webkit-scrollbar-thumb { background: #222; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #cc0000; }
    </style>
</head>
<body>
    <div id="app">
        
        <!-- SIDEBAR -->
        <div id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-header mb-10">
                <div class="flex justify-between items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        @if(\App\Models\Setting::get('site_logo'))
                            <img src="{{ \Illuminate\Support\Facades\Storage::url(\App\Models\Setting::get('site_logo')) }}" class="w-8 h-8 rounded-lg object-cover bg-white/5" alt="Logo">
                        @else
                            <div class="w-8 h-8 bg-gradient-to-br from-[#8b0000] to-[#cc0000] rounded-lg flex items-center justify-center font-black text-white italic group-hover:rotate-12 transition-transform">Z</div>
                        @endif
                        <span class="text-xl font-black tracking-tighter uppercase text-white">ZESEKAI</span>
                    </a>
                    <div class="block xl:hidden cursor-pointer text-gray-500 hover:text-white transition" id="sidebar-close">
                        <i class="bi bi-x-lg"></i>
                    </div>
                </div>
            </div>
            
            <div class="sidebar-menu">
                <ul class="list-none p-0 m-0">
                    <li class="menu-title">Main Menu</li>
                    
                    <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('watchlist') ? 'active' : '' }}">
                        <a href="{{ route('watchlist') }}" class='sidebar-link'>
                            <i class="bi bi-bookmark-heart-fill"></i>
                            <span>My Watchlist</span>
                        </a>
                    </li>

                    @if(!auth()->user()->is_premium)
                    <li class="sidebar-item {{ request()->routeIs('subscription') ? 'active' : '' }}">
                        <a href="{{ route('subscription') }}" class='sidebar-link'>
                            <i class="bi bi-star-fill"></i>
                            <span>Premium</span>
                        </a>
                    </li>
                    @endif

                    <li class="menu-title">Browse</li>

                    <li class="sidebar-item {{ request()->routeIs('trending') ? 'active' : '' }}">
                        <a href="{{ route('trending') }}" class='sidebar-link'>
                            <i class="bi bi-fire"></i>
                            <span>Trending</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('catalog') ? 'active' : '' }}">
                        <a href="{{ route('catalog') }}" class='sidebar-link'>
                            <i class="bi bi-collection-fill"></i>
                            <span>Catalog</span>
                        </a>
                    </li>

                    <li class="menu-title">Account</li>

                    <li class="sidebar-item {{ request()->routeIs('profile') ? 'active' : '' }}">
                        <a href="{{ route('profile') }}" class='sidebar-link'>
                            <i class="bi bi-person-fill"></i>
                            <span>Profile</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="{{ route('home') }}" class='sidebar-link hover:!text-white group'>
                            <i class="bi bi-house-fill group-hover:!text-white"></i>
                            <span>Back to Home</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                        </form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class='sidebar-link text-red-500 hover:bg-red-500/10'>
                            <i class="bi bi-box-arrow-right text-red-500"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="sidebar-backdrop" id="backdrop"></div>

        <!-- MAIN CONTENT -->
        <div id="main" class="main-content">
            <header class="mb-10 flex justify-between items-center">
                <div class="cursor-pointer text-gray-400 hover:text-white transition xl:hidden" id="burger-btn">
                    <i class="bi bi-list text-2xl"></i>
                </div>
                
                <div class="hidden xl:block">
                     <h1 class="text-2xl font-black uppercase tracking-tighter text-white">
                        {{ $title ?? 'User Dashboard' }}
                     </h1>
                     <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">Welcome back, {{ auth()->user()->name }}</p>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('profile') }}" class="text-right hidden sm:block group">
                        <div class="font-bold text-white text-sm tracking-wide group-hover:text-red-500 transition">{{ auth()->user()->name }}</div>
                        <div class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">User</div>
                    </a>
                    <a href="{{ route('profile') }}" class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-800 to-black border border-white/10 p-0.5 shadow-lg relative overflow-hidden group">
                        @if(auth()->user()->profile_photo_path)
                             <img src="{{ \Illuminate\Support\Facades\Storage::url(auth()->user()->profile_photo_path) }}" class="rounded-[10px] w-full h-full object-cover" alt="Avatar">
                        @else
                             <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=111&color=fff" class="rounded-[10px]" alt="Avatar">
                        @endif
                        <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition"></div>
                    </a>
                </div>
            </header>

            {{ $slot }}

            <footer class="mt-20 border-t border-white/5 pt-8 text-center">
                <p class="text-[10px] text-gray-600 uppercase tracking-[0.3em] font-bold">&copy; 2026 ZESEKAI PROJECT</p>
            </footer>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('swal:alert', event => {
            const data = event.detail[0] || event.detail;
            Swal.fire({
                icon: data.type,
                title: data.title,
                text: data.text,
                background: '#0a0a0a',
                color: '#fff',
                confirmButtonColor: '#cc0000',
                customClass: {
                    popup: 'border border-white/10 rounded-[32px]',
                }
            });
        });

        const burgerBtn = document.getElementById('burger-btn');
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('backdrop');
        const closeBtn = document.getElementById('sidebar-close');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            backdrop.classList.toggle('show');
        }

        if(burgerBtn) burgerBtn.addEventListener('click', toggleSidebar);
        if(backdrop) backdrop.addEventListener('click', toggleSidebar);
        if(closeBtn) closeBtn.addEventListener('click', toggleSidebar);
    </script>
</body>
</html>
