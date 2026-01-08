<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zesekai - Streaming Anime Terbaik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
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
        :root {
            --primary-red: #cc0000;
            --dark-red: #8b0000;
            --soft-black: #050505;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background: #000;
            color: #ffffff;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* Animations */
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-up { animation: slideInUp 0.8s cubic-bezier(0.23, 1, 0.32, 1) forwards; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }

        /* Custom UI Elements */
        .glass {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #8b0000, #cc0000);
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 0 4px 15px rgba(204, 0, 0, 0.2);
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(204, 0, 0, 0.4);
            filter: brightness(1.1);
        }

        .gradient-text {
            background: linear-gradient(135deg, #fff 40%, #ff4d4d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Carousel Styling */
        .carousel-track {
            display: flex;
            transition: transform 0.8s cubic-bezier(0.23, 1, 0.32, 1);
            gap: 24px;
            padding: 10px 0;
        }

        .anime-card-mini {
            flex: 0 0 calc(50% - 12px);
            max-width: calc(50% - 12px);
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }

        @media (min-width: 768px) {
            .anime-card-mini { flex: 0 0 calc(20% - 20px); max-width: calc(20% - 20px); }
        }

        @media (min-width: 1024px) {
            .anime-card-mini { flex: 0 0 calc(14.28% - 20px); max-width: calc(14.28% - 20px); }
        }

        .anime-card-mini:hover {
            transform: scale(1.03) translateY(-8px);
        }

        .line-accent {
            width: 40px;
            height: 2px;
            background: #cc0000;
            margin-bottom: 12px;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #000; }
        ::-webkit-scrollbar-thumb { background: #111; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #cc0000; }
    </style>
</head>
<body class="bg-black text-white selection:bg-red-600">

    <livewire:layout.navigation />

    @if(!$is_premium && $headerAds = \App\Models\Setting::get('adsense_header_code'))
        <!-- TOP AD BANNER -->
        <div class="w-full flex justify-center py-6 bg-transparent relative z-50">
            <div class="max-w-7xl mx-auto px-6 overflow-hidden flex justify-center">
                {!! $headerAds !!}
            </div>
        </div>
    @endif

    <!-- HERO SECTION -->
    <section id="home" class="relative min-h-screen flex items-center overflow-hidden">
        <!-- Floating Red Glows -->
        <div class="absolute -top-60 -left-60 w-[500px] h-[500px] bg-red-600/5 blur-[120px] rounded-full"></div>
        <div class="absolute -bottom-60 -right-60 w-[500px] h-[500px] bg-red-600/5 blur-[120px] rounded-full"></div>

        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-20 items-center z-10 pt-10">
            <div class="space-y-8">
                <div class="inline-flex items-center gap-3 px-4 py-1.5 glass bg-white/[0.01] border-white/5 text-[9px] font-black tracking-[0.3em] text-red-500 uppercase animate-up shadow-xl">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span>
                    Update Setiap Hari
                </div>
                
                <h1 class="text-3xl md:text-5xl font-black leading-[1.05] animate-up delay-1 tracking-tighter uppercase">
                    Jelajahi Dunia <br> <span class="gradient-text">Anime Terbaik</span>
                </h1>
                
                <p class="text-base text-gray-500 max-w-sm leading-relaxed animate-up delay-2 font-medium">
                    Koleksi kurasi anime terbaik dengan visual memukau dan kualitas tanpa kompromi.
                </p>

                <div class="flex flex-wrap gap-5 animate-up delay-3 pt-4">
                    <a href="#featured" class="btn-gradient px-10 py-4 rounded-2xl font-black text-[11px] tracking-[0.2em] flex items-center gap-3 uppercase">
                        <span>▶ Mulai Menonton</span>
                    </a>
                    <a href="{{ route('watchlist') }}" class="glass px-10 py-4 border-white/[0.03] hover:bg-white/[0.05] transition-all duration-300 font-bold text-[11px] tracking-[0.2em] uppercase flex items-center justify-center">
                        Watchlist
                    </a>
                </div>
            </div>

            @php
                $hero1 = \App\Models\HeroSetting::where('key', 'hero_image_1')->first()?->value ?? 'https://m.media-amazon.com/images/M/MV5BNDFjYTIxMjctYTQ2ZC00OGQ4LWE3OGYtYTdiMzRkMTE1OTQxXkEyXkFqcGdeQXVyOTAyMDgxODQ@._V1_.jpg';
                $hero2 = \App\Models\HeroSetting::where('key', 'hero_image_2')->first()?->value ?? 'https://m.media-amazon.com/images/M/MV5BZjZjNzI5MDctY2YyZC00NmM0LThlZWItMDhmYmQyYTgzOTQ2XkEyXkFqcGdeQXVyNjU1OTg0OTM@._V1_FMjpg_UX1000_.jpg';
            @endphp

            <div class="relative hidden md:flex justify-end items-center">
                <div class="absolute inset-0 bg-red-600/[0.01] blur-[150px] rounded-full"></div>
                
                <div class="relative w-64 h-[380px] rotate-6 group transition-all duration-700 hover:rotate-0 hover:scale-105">
                     <img src="{{ $hero1 }}" 
                          class="w-full h-full object-contain">
                     @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.settings.hero') }}" class="absolute top-4 left-4 w-10 h-10 bg-red-600 rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition shadow-xl border border-white/20 hover:scale-110 active:scale-90" title="Manage Hero Images">
                                <i class="bi bi-pencil-fill text-xs"></i>
                            </a>
                        @endif
                     @endauth
                </div>

                <div class="absolute w-56 h-[340px] -rotate-3 -left-12 -z-10 opacity-30 transition-all duration-700 hover:-rotate-6 group/item hover:opacity-100 hover:z-20">
                     <img src="{{ $hero2 }}" 
                          class="w-full h-full object-contain">
                     @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.settings.hero') }}" class="absolute top-4 left-4 w-10 h-10 bg-red-600 rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition shadow-xl border border-white/20 hover:scale-110 active:scale-90" title="Manage Hero Images">
                                <i class="bi bi-pencil-fill text-xs"></i>
                            </a>
                        @endif
                     @endauth
                </div>
            </div>
        </div>
    </section>

    @if(!auth()->user()?->is_premium)
    <!-- PREMIUM BANNER -->
    <section class="pb-10 pt-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-[#0a0a0a] border border-red-600/20 rounded-[32px] p-8 md:p-16 relative overflow-hidden group shadow-2xl shadow-red-900/5">
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-red-600/5 blur-[120px] rounded-full -z-0 pointer-events-none group-hover:bg-red-600/10 transition-all duration-700"></div>
                
                <div class="relative z-10 grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-red-600/10 border border-red-600/20 rounded-full text-[8px] font-black uppercase tracking-[0.3em] text-red-500 mb-6">
                            Exclusive Offer
                        </div>
                        <h2 class="text-3xl md:text-5xl font-black uppercase tracking-tighter text-white mb-6 leading-none">Nikmati <span class="text-red-600">Premium</span> <br> Tanpa Iklan</h2>
                        <p class="text-gray-500 font-medium text-sm md:text-base mb-10 max-w-md">Tonton anime favoritmu dengan kualitas Full HD 1080p dan akses server prioritas tanpa gangguan iklan sekali saja.</p>
                        
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('subscription') }}" class="btn-gradient px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] text-white">Berlangganan Sekarang</a>
                            <div class="flex flex-col justify-center">
                                <span class="text-white font-black text-lg leading-none">IDR 29K</span>
                                <span class="text-[8px] text-gray-500 uppercase font-bold tracking-widest mt-1">Hanya per bulan</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div class="bg-white/5 border border-white/5 p-6 rounded-2xl hover:border-red-600/30 transition">
                                <i class="bi bi-hd-fill text-2xl text-red-600 mb-3 block"></i>
                                <h4 class="text-[10px] font-black uppercase text-white tracking-widest">Full HD</h4>
                            </div>
                            <div class="bg-white/5 border border-white/5 p-6 rounded-2xl hover:border-red-600/30 transition">
                                <i class="bi bi-lightning-charge-fill text-2xl text-red-600 mb-3 block"></i>
                                <h4 class="text-[10px] font-black uppercase text-white tracking-widest">Fast Track</h4>
                            </div>
                        </div>
                        <div class="space-y-4 pt-8">
                            <div class="bg-white/5 border border-white/5 p-6 rounded-2xl hover:border-red-600/30 transition">
                                <i class="bi bi-shield-lock-fill text-2xl text-red-600 mb-3 block"></i>
                                <h4 class="text-[10px] font-black uppercase text-white tracking-widest">No Ads</h4>
                            </div>
                            <div class="bg-white/5 border border-white/5 p-6 rounded-2xl hover:border-red-600/30 transition">
                                <i class="bi bi-cloud-arrow-down-fill text-2xl text-red-600 mb-3 block"></i>
                                <h4 class="text-[10px] font-black uppercase text-white tracking-widest">Offline</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- TRENDING PREVIEW SECTION -->
    <section id="featured" class="py-24 bg-black border-y border-white/[0.02]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-12">
                <div>
                    <div class="line-accent"></div>
                    <h2 class="text-2xl md:text-3xl font-black tracking-tighter uppercase">TOP <span class="text-red-600">TRENDING</span></h2>
                    <p class="text-gray-500 mt-2 font-bold text-[10px] uppercase tracking-widest">Anime yang mendominasi minggu ini</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('trending') }}" class="glass px-6 py-2 text-[10px] font-black uppercase tracking-widest hover:bg-white/5 transition">Lihat Semua</a>
                    <div class="flex gap-2">
                        <button onclick="slide('prev')" class="w-9 h-9 glass bg-white/[0.01] border-white/5 flex items-center justify-center hover:bg-white/[0.04] transition-all text-xs font-black">←</button>
                        <button onclick="slide('next')" class="w-9 h-9 btn-gradient flex items-center justify-center hover:scale-110 transition-all text-xs font-black">→</button>
                    </div>
                </div>
            </div>

            <div class="carousel-container overflow-hidden">
                <div class="carousel-track" id="track">
                    @foreach(\App\Models\Anime::latest()->take(8)->get() as $anime)
                        <div class="anime-card-mini group px-2">
                            <a href="{{ route('anime.detail', $anime->slug) }}">
                                <div class="relative aspect-[3/4.5] rounded-2xl overflow-hidden glass border-white/5 shadow-2xl">
                                    <img src="{{ $anime->poster_image }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                                    <div class="absolute top-2.5 right-2.5 bg-red-600 text-[7px] font-black px-1.5 py-0.5 rounded shadow-lg uppercase tracking-widest">Hot</div>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-4 flex flex-col justify-end">
                                        <p class="text-[9px] font-black text-red-500 uppercase tracking-widest mb-1">9.1 Rate</p>
                                        <h4 class="font-black text-[11px] uppercase tracking-tight truncate">{{ $anime->title }}</h4>
                                    </div>
                                </div>
                                <h4 class="mt-4 font-bold text-[11px] text-center tracking-wide text-gray-400 group-hover:text-red-500 transition-all duration-300 uppercase truncate">{{ $anime->title }}</h4>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- CALALOG PREVIEW SECTION -->
    <section id="list" class="py-24 bg-black">
        <div class="max-w-7xl mx-auto px-6">
             <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-12">
                <div>
                    <h2 class="text-2xl md:text-3xl font-black tracking-tighter uppercase">Katalog <span class="text-red-600">Terbaru</span></h2>
                    <p class="text-gray-500 mt-2 font-bold text-[10px] uppercase tracking-widest">Temukan favorit barumu</p>
                </div>
                <a href="{{ route('catalog') }}" class="glass px-6 py-2 text-[10px] font-black uppercase tracking-widest hover:bg-white/5 transition">Lihat Katalog Lengkap</a>
             </div>
             
             <!-- Using HomeAnimeList component but limits will be handled inside component or we just show it -->
             <livewire:home-anime-list />
        </div>
    </section>

    <footer class="py-24 bg-black border-t border-white/[0.02]">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="flex justify-center items-center gap-3 mb-10">
                @if(\App\Models\Setting::get('site_logo'))
                    <img src="{{ \Illuminate\Support\Facades\Storage::url(\App\Models\Setting::get('site_logo')) }}" class="w-8 h-8 rounded-lg object-cover bg-white/5" alt="Logo">
                @else
                    <div class="w-8 h-8 bg-gradient-to-br from-[#8b0000] to-[#cc0000] flex items-center justify-center font-black italic rounded text-[10px] text-white">Z</div>
                @endif
                <span class="text-xl font-black tracking-tighter uppercase text-white">ZESE<span class="text-red-600">KAI</span></span>
            </div>
            <p class="text-gray-600 max-w-sm mx-auto mb-10 text-[11px] leading-relaxed font-medium">Platfom streaming anime premium. Dibuat dengan cinta untuk para penggemar setia di seluruh dunia.</p>
            <div class="flex justify-center gap-10 text-gray-600 text-[9px] mb-16 uppercase tracking-[0.4em] font-black">
                <a href="#" class="hover:text-red-500 transition-colors">Terms</a>
                <a href="#" class="hover:text-red-500 transition-colors">Privacy</a>
                <a href="#" class="hover:text-red-500 transition-colors">DMCA</a>
            </div>
            <p class="text-[8px] text-gray-800 uppercase tracking-[0.5em] font-black">&copy; 2026 ZESEKAI PROJECT. ALL RIGHTS RESERVED.</p>
        </div>
    </footer>

    <script>
        const track = document.getElementById('track');
        let currentPos = 0;

        function slide(direction) {
            const track = document.getElementById('track');
            const cardElement = track.querySelector('.anime-card-mini');
            if (!cardElement) return;
            
            // Re-calculate on each click in case of resize
            const cardStyle = window.getComputedStyle(cardElement);
            // card width including margin/padding if logic needs it, but here gap is on track
            // Flex gap is 24px in CSS
            const cardWidth = cardElement.offsetWidth + 24; 
            const containerWidth = track.parentNode.offsetWidth;
            const maxScroll = track.scrollWidth - containerWidth;

            if (direction === 'next') {
                currentPos -= cardWidth * 2;
                // Don't scroll past the end
                if (Math.abs(currentPos) > maxScroll) currentPos = -maxScroll;
            } else {
                currentPos += cardWidth * 2;
                // Don't scroll past the start
                if (currentPos > 0) currentPos = 0;
            }
            track.style.transform = `translateX(${currentPos}px)`;
        }
    </script>

    @livewireScripts
</body>
</html>
