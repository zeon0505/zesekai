<div>
    <div class="mb-16 flex flex-col md:flex-row items-center justify-center gap-4">
        <!-- Search Bar -->
        <div class="relative w-full max-w-lg group">
            <input type="text" wire:model.live.debounce.300ms="search" 
                   placeholder="Cari anime..." 
                   class="w-full bg-white/[0.03] border border-white/10 text-white pl-12 pr-6 py-3.5 rounded-xl focus:outline-none focus:border-red-600 focus:ring-4 focus:ring-red-600/5 transition-all duration-300 text-sm font-medium placeholder:text-gray-600">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-600 group-focus-within:text-red-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <!-- Genre Filter Dropdown -->
        <div class="relative w-full md:w-60">
            <select wire:model.live="selectedGenre" 
                    class="w-full bg-white/[0.03] border border-white/10 text-white px-6 py-3.5 rounded-xl focus:outline-none focus:border-red-600 focus:ring-4 focus:ring-red-600/5 transition-all duration-300 appearance-none cursor-pointer text-sm font-semibold">
                <option value="" class="bg-black">Semua Genre</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->slug }}" class="bg-black">{{ $genre->name }}</option>
                @endforeach
            </select>
            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-red-500/50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Anime Grid (6 Columns) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5 md:gap-7">
        @foreach($animes as $index => $anime)
            <div class="group animate-up" style="animation-delay: {{ ($index % 6) * 0.05 }}s">
                <a href="{{ route('anime.detail', $anime->slug) }}" class="block">
                    <div class="relative aspect-[3/4.4] rounded-xl overflow-hidden bg-zinc-950 shadow-2xl transition-all duration-500 group-hover:scale-[1.03] group-hover:-translate-y-1 border border-white/[0.05]">
                        <img src="{{ $anime->poster_image ?? '/placeholder.svg' }}" 
                             alt="{{ $anime->title }}" class="w-full h-full object-cover grayscale-[20%] group-hover:grayscale-0 transition-all duration-700">
                        
                        <!-- Premium Label -->
                        <div class="absolute top-2 right-2 z-10">
                             <div class="bg-black/60 backdrop-blur-md text-[7px] font-black px-2 py-0.5 rounded text-white uppercase tracking-widest border border-white/10">
                                {{ $anime->type }}
                             </div>
                        </div>

                        <!-- Status Overlay -->
                        <div class="absolute bottom-3 left-3 z-20">
                             <p class="text-red-500 font-bold text-[8px] tracking-[0.2em] uppercase mb-0.5">{{ $anime->status }}</p>
                             <h3 class="text-white font-bold text-xs leading-tight group-hover:text-red-400 transition-colors">{{ $anime->title }}</h3>
                        </div>

                        <!-- Dark Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/10 to-transparent opacity-80 group-hover:opacity-40 transition-opacity duration-500"></div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-20 flex justify-center">
        {{ $animes->links() }}
    </div>
</div>
