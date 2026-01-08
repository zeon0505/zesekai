<div>
    <!-- TRENDING SECTION -->
    <section class="py-32 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-16">
                <div>
                    <div class="line-accent"></div>
                    <h2 class="text-2xl md:text-4xl font-black tracking-tighter uppercase italic">TOP <span class="text-red-600">TRENDING</span></h2>
                    <p class="text-gray-500 mt-2 font-bold text-[10px] uppercase tracking-widest">Anime yang mendominasi minggu ini</p>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-7 gap-6">
                @foreach(\App\Models\Anime::latest()->get() as $anime)
                    <div class="anime-card-mini group block">
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
    </section>
</div>
