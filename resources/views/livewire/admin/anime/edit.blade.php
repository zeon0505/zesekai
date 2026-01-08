<div x-data="animeHelper()">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-2xl font-black text-white uppercase tracking-tighter">Edit Anime: {{ $anime->title }}</h3>
            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Update existing anime records</p>
        </div>
        <a href="{{ route('admin.anime.index') }}" class="text-gray-400 hover:text-white font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 transition">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    @if (session()->has('api_message'))
        <div class="bg-blue-500/10 border border-blue-500/20 text-blue-500 px-6 py-4 rounded-xl mb-6 flex items-center gap-3 text-xs font-bold uppercase tracking-widest">
            <i class="bi bi-info-circle-fill"></i>
            {{ session('api_message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-[#0a0a0a] rounded-2xl border border-white/5 p-8 relative overflow-hidden shadow-2xl">
                <div class="absolute top-0 right-0 w-64 h-64 bg-red-600/5 blur-[100px] -z-0"></div>

                <form wire:submit="update" class="space-y-6 relative z-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Title</label>
                            <input wire:model="title" type="text" class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-white focus:border-red-600/50 focus:outline-none transition" placeholder="e.g. Jujutsu Kaisen">
                            @error('title') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Status</label>
                            <select wire:model="status" class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-white focus:border-red-600/50 focus:outline-none transition">
                                <option value="Ongoing">Ongoing</option>
                                <option value="Completed">Completed</option>
                                <option value="Upcoming">Upcoming</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Type</label>
                            <select wire:model="type" class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-white focus:border-red-600/50 focus:outline-none transition">
                                <option value="TV">TV Series</option>
                                <option value="Movie">Movie</option>
                                <option value="OVA">OVA</option>
                                <option value="Special">Special</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Aired Date</label>
                            <input wire:model="aired_at" type="date" class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-white focus:border-red-600/50 focus:outline-none transition">
                            @error('aired_at') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex items-end pb-1">
                            <label class="flex items-center gap-3 cursor-pointer p-3 bg-black border border-white/10 rounded-xl hover:border-red-600/30 transition w-full">
                                <input wire:model="is_premium" type="checkbox" class="w-4 h-4 text-red-600 bg-black border-white/20 rounded focus:ring-red-600">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Premium</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Synopsis</label>
                        <textarea wire:model="synopsis" rows="5" class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-white focus:border-red-600/50 focus:outline-none transition" placeholder="Anime description..."></textarea>
                        @error('synopsis') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Poster URL</label>
                            <input wire:model="poster_image" type="url" class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-white focus:border-red-600/50 focus:outline-none transition" placeholder="https://...">
                            @error('poster_image') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Banner URL</label>
                            <input wire:model="banner_image" type="url" class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-white focus:border-red-600/50 focus:outline-none transition" placeholder="https://...">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 border-b border-white/5 pb-2">Select Genres</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3">
                            @foreach($genres as $genre)
                                <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-white/5 transition group">
                                    <input wire:model="selectedGenres" type="checkbox" value="{{ $genre->id }}" class="w-3.5 h-3.5 rounded bg-black border-white/20 text-red-600 focus:ring-red-600 transition">
                                    <span class="text-[10px] font-bold text-gray-500 group-hover:text-gray-300 uppercase tracking-widest">{{ $genre->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-6 border-t border-white/5 flex justify-end gap-3">
                        <button type="submit" class="px-10 py-4 rounded-xl bg-red-600 hover:bg-red-700 text-white font-black text-[11px] uppercase tracking-widest transition shadow-lg shadow-red-900/30 active:scale-95">
                            Update Anime
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sansekai Helper Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-[#0a0a0a] rounded-2xl border border-red-600/20 p-6 relative overflow-hidden group shadow-xl">
                <div class="absolute inset-0 bg-gradient-to-br from-red-600/[0.05] to-transparent opacity-50"></div>
                
                <h4 class="text-sm font-black text-white uppercase tracking-widest mb-4 flex items-center gap-2 relative z-10">
                    <i class="bi bi-magic text-red-500"></i>
                    <span x-text="sourceNames[selectedSource] + ' Helper'"></span>
                </h4>
                
                <p class="text-[9px] text-gray-500 font-bold uppercase mb-4 relative z-10">Autofill data from external database.</p>

                <div class="space-y-4 relative z-10">
                    <div>
                        <label class="block text-[8px] font-black text-gray-500 uppercase tracking-widest mb-1.5 ml-1">Pilih Sumber API</label>
                        <select x-model="selectedSource" @change="searchAnime" class="w-full bg-black border border-white/10 rounded-xl px-4 py-2.5 text-[10px] text-white font-bold focus:outline-none focus:border-red-600/50 transition">
                            <option value="sansekai">Sansekai API (Bisa Terblokir)</option>
                            <option value="otakudesu">Otakudesu Mirror (Stabil)</option>
                            <option value="samehadaku">Samehadaku (Alternatif)</option>
                            <option value="kusonime">Kusonime (Batch/Lengkap)</option>
                        </select>
                    </div>
                    <div class="relative">
                        <input x-model="searchQuery" @keyup.enter="searchAnime" type="text" class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-red-600/50 transition pr-10" placeholder="Ketik judul anime...">
                        <button @click="searchAnime" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-red-500 transition">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Results -->
                <div class="mt-6 space-y-3 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar relative z-10">
                    <template x-if="loading">
                        <div class="py-10 text-center space-y-3">
                            <div class="w-8 h-8 border-2 border-red-600 border-t-transparent rounded-full animate-spin mx-auto"></div>
                            <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest" x-text="'Mencari di ' + sourceNames[selectedSource] + '...'"></p>
                        </div>
                    </template>

                    <template x-for="(res, index) in results" :key="res.url + '-' + index">
                        <button @click="importData(res.url)" 
                                class="w-full text-left p-3 rounded-xl bg-white/[0.02] hover:bg-red-900/10 border border-white/5 transition flex items-center gap-4 group">
                            <div class="w-12 h-16 rounded-lg overflow-hidden flex-shrink-0 shadow-lg">
                                <img :src="res.cover" class="w-full h-full object-cover">
                            </div>
                            <div class="overflow-hidden">
                                 <div class="text-[11px] font-black text-white leading-tight mb-1 group-hover:text-red-500 transition line-clamp-2" x-text="res.judul"></div>
                                 <div class="text-[9px] text-gray-500 font-bold uppercase flex items-center gap-2">
                                     <span x-text="res.type || 'Anime'"></span>
                                     <span class="w-1 h-1 bg-gray-700 rounded-full"></span>
                                     <span class="text-red-500">Click to Import</span>
                                 </div>
                            </div>
                        </button>
                    </template>

                    <template x-if="!loading && results.length === 0 && hasSearched">
                        <div class="py-10 text-center opacity-50">
                            <p class="text-[10px] font-black uppercase tracking-widest">Tidak ditemukan hasil.</p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <script>
        function animeHelper() {
            return {
                searchQuery: '{{ $title }}',
                results: [],
                loading: false,
                hasSearched: false,
                selectedSource: 'sansekai',
                sourceNames: {
                    'sansekai': 'Sansekai',
                    'otakudesu': 'Otakudesu',
                    'samehadaku': 'Samehadaku',
                    'kusonime': 'Kusonime'
                },

                async searchAnime() {
                    if(!this.searchQuery) return;
                    this.loading = true;
                    this.hasSearched = true;
                    this.results = [];
                    try {
                        const results = await this.$wire.searchOnApiServer(this.searchQuery, this.selectedSource);
                        this.results = results || [];
                    } catch (e) {
                        console.error(e);
                        alert('Gagal mencari anime.');
                    } finally {
                        this.loading = false;
                    }
                },

                async importData(urlId) {
                    this.loading = true;
                    try {
                        const animeData = await this.$wire.getAnimeInfoServer(urlId, this.selectedSource);
                        if(animeData) {
                            await this.$wire.setApiData(animeData);
                            window.scrollTo({top: 0, behavior: 'smooth'});
                        } else {
                            alert('Data tidak ditemukan.');
                        }
                    } catch (e) {
                        console.error(e);
                        alert('Gagal mengambil detail anime.');
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</div>
