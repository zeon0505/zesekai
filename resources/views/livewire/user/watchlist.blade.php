<div>
    <!-- HEADLINE SECTION -->
    <section class="relative pt-32 pb-12 bg-black">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 space-y-4">
                <div class="line-accent mx-auto"></div>
                <h2 class="text-3xl md:text-5xl font-black tracking-tighter uppercase">My <span class="text-red-600">Watchlist</span></h2>
                <p class="text-gray-500 text-[10px] font-black uppercase tracking-[0.3em]">List anime yang ingin kamu tonton</p>
            </div>

            @if($watchlists->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-7 gap-6">
                    @foreach($watchlists as $item)
                        @if($item->anime)
                            <div class="anime-card-mini group block relative">
                                <a href="{{ route('anime.detail', $item->anime->slug) }}">
                                    <div class="relative aspect-[3/4.5] rounded-2xl overflow-hidden glass border-white/5 shadow-2xl">
                                        <img src="{{ $item->anime->poster_image }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-4 flex flex-col justify-end">
                                            <h4 class="font-black text-[11px] uppercase tracking-tight truncate">{{ $item->anime->title }}</h4>
                                        </div>
                                    </div>
                                    <h4 class="mt-4 font-bold text-[11px] text-center tracking-wide text-gray-400 group-hover:text-red-500 transition-all duration-300 uppercase truncate">{{ $item->anime->title }}</h4>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="text-center py-20">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/5 border border-white/10 mb-6">
                        <i class="bi bi-bookmark-plus text-3xl text-gray-600"></i>
                    </div>
                    <h3 class="text-xl font-black uppercase tracking-tight text-gray-400">Belum ada anime di watchlist</h3>
                    <p class="text-[10px] uppercase tracking-widest text-gray-600 mt-2 mb-8">Jelajahi katalog dan tambahkan anime favoritmu</p>
                    <a href="{{ route('catalog') }}" class="btn-gradient px-8 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest text-white">Jelajahi Anime</a>
                </div>
            @endif
        </div>
    </section>
</div>
