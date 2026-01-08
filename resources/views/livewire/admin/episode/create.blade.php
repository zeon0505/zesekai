<div x-data="sansekaiHelper()">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-2xl font-black text-white uppercase tracking-tighter">Add Episode: {{ $anime->title }}</h3>
            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Add a new episode and stream URL</p>
        </div>
        <a href="{{ route('admin.anime.episodes.index', $anime->id) }}" class="text-gray-400 hover:text-white font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 transition">
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
        <!-- Input Form -->
        <div class="lg:col-span-2">
            <div class="bg-[#0a0a0a] rounded-2xl border border-white/5 p-8 relative overflow-hidden shadow-2xl">
                <!-- Decorative background -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-red-600/5 blur-[100px] -z-0"></div>

                <form wire:submit="save" class="space-y-6 relative z-10">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Episode Number</label>
                            <input wire:model="episode_number" type="number" class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-white focus:border-red-600/50 focus:outline-none transition" placeholder="e.g. 1">
                            @error('episode_number') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Title (Optional)</label>
                            <input wire:model="title" type="text" class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-white focus:border-red-600/50 focus:outline-none transition" placeholder="e.g. Prologue">
                            @error('title') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Stream API / Embed URL</label>
                                <span class="text-[9px] text-red-500 font-bold uppercase tracking-widest animate-pulse">Required</span>
                            </div>
                            <input wire:model="video_url" type="url" class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-white focus:border-red-600/50 focus:outline-none transition" placeholder="Paste link here or use helper ->">
                            @error('video_url') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Thumbnail URL (Optional)</label>
                            <input wire:model="thumbnail_image" type="url" class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-white focus:border-red-600/50 focus:outline-none transition" placeholder="https://...">
                            @error('thumbnail_image') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-3 border-t border-white/5">
                        <button type="submit" class="px-10 py-4 rounded-xl bg-red-600 hover:bg-red-700 text-white font-black text-[11px] uppercase tracking-widest transition shadow-lg shadow-red-900/30 active:scale-95">
                            Save Episode
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- API Helper Widget (Client Side FIXED) -->
        <div class="lg:col-span-1">
            <div class="bg-[#0a0a0a] rounded-2xl border border-red-600/20 p-6 relative overflow-hidden group shadow-xl">
                <div class="absolute inset-0 bg-gradient-to-br from-red-600/[0.05] to-transparent opacity-50"></div>
                
                <h4 class="text-sm font-black text-white uppercase tracking-widest mb-4 flex items-center gap-2 relative z-10">
                    <i class="bi bi-magic text-red-500"></i>
                    <span x-text="sourceNames[selectedSource] + ' Helper'"></span>
                </h4>
                
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

                <!-- Search Results -->
                <div class="mt-6 space-y-3 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar relative z-10">
                    <template x-if="loading">
                        <div class="py-10 text-center space-y-3">
                            <div class="w-8 h-8 border-2 border-red-600 border-t-transparent rounded-full animate-spin mx-auto"></div>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest" x-text="'Mencari di ' + sourceNames[selectedSource] + '...'"></p>
                        </div>
                    </template>
                    <template x-for="(res, index) in results" :key="res.url + '-' + index">
                        <div class="space-y-2">
                            <button @click="getDetails(res.url)" 
                                    class="w-full text-left p-3 rounded-xl bg-white/[0.02] hover:bg-red-900/10 border border-white/5 transition flex items-center gap-4 group"
                                    :class="{'border-red-600/50 bg-red-900/5': selectedAnime === res.url}">
                                <div class="w-12 h-16 rounded-lg overflow-hidden flex-shrink-0 shadow-lg">
                                    <img :src="res.cover" class="w-full h-full object-cover">
                                </div>
                                <div class="overflow-hidden">
                                     <div class="text-[11px] font-black text-white leading-tight mb-1 group-hover:text-red-500 transition" x-text="res.judul"></div>
                                     <div class="text-[9px] text-gray-500 font-bold uppercase" x-text="(res.type || 'Anime') + ' • ' + (res.status || 'Active')"></div>
                                </div>
                            </button>

                            <!-- Episodes List -->
                            <template x-if="selectedAnime === res.url">
                                <div class="pl-4 mt-2 mb-6 border-l-2 border-red-600/30">
                                    <template x-if="episodesLoading">
                                        <div class="text-[9px] text-red-500 pl-3 animate-pulse uppercase font-black tracking-widest py-3">Mengambil daftar episode...</div>
                                    </template>
                                    
                                    <div x-show="!episodesLoading && episodes.length > 0" class="mb-4 pl-3">
                                        <button @click="importAll()" 
                                                class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-[9px] font-black uppercase text-white tracking-widest rounded-xl transition flex items-center justify-center gap-2 shadow-lg shadow-red-900/20 disabled:opacity-50"
                                                :disabled="bulkImporting">
                                            <i class="bi" :class="bulkImporting ? 'bi-arrow-repeat animate-spin' : 'bi-cloud-download-fill'"></i>
                                            <span x-text="bulkImporting ? 'Sedang Mengimpor (' + currentProgress + '/' + episodes.length + ')...' : 'Impor Semua Episode (' + episodes.length + ')'"></span>
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-4 gap-2 pl-3">
                                        <template x-for="ep in episodes" :key="ep.url">
                                            <button @click="importLink(ep.url, ep.ch)" 
                                                    class="p-2 bg-white/5 hover:bg-red-600 hover:text-white rounded-lg text-[10px] font-black transition border border-white/5 flex flex-col items-center justify-center gap-1 shadow-sm">
                                                <span x-text="ep.ch"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>

                    <template x-if="!loading && results.length === 0 && hasSearched">
                        <div class="py-10 text-center opacity-50">
                            <i class="bi bi-search text-2xl mb-2 block"></i>
                            <p class="text-[10px] font-black uppercase tracking-widest">Tidak ditemukan hasil.</p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <script>
        function sansekaiHelper() {
            return {
                searchQuery: '{{ $anime->title }}',
                results: [],
                loading: false,
                hasSearched: false,
                selectedAnime: null,
                selectedSource: 'sansekai',
                sourceNames: {
                    'sansekai': 'Sansekai',
                    'otakudesu': 'Otakudesu',
                    'samehadaku': 'Samehadaku',
                    'kusonime': 'Kusonime'
                },
                episodes: [],
                episodesLoading: false,
                bulkImporting: false,
                currentProgress: 0,

                init() {
                    window.addEventListener('api-error', (event) => {
                        alert(`API Ditolak: ${event.detail.message}`);
                    });
                },

                async searchAnime() {
                    if(!this.searchQuery) return;
                    this.loading = true;
                    this.hasSearched = true;
                    this.results = [];
                    this.selectedAnime = null;
                    console.log('Searching...', this.searchQuery, 'Source:', this.selectedSource);
                    try {
                        const results = await this.$wire.searchOnApiServer(this.searchQuery, this.selectedSource);
                        console.log('Results received:', results);
                        this.results = results || [];
                    } catch (e) {
                        console.error('Search error:', e);
                        alert('Gagal menghubungi server lokal.');
                    } finally {
                        this.loading = false;
                    }
                },

                async getDetails(urlId) {
                    if(this.selectedAnime === urlId) {
                        this.selectedAnime = null;
                        return;
                    }
                    this.selectedAnime = urlId;
                    this.episodesLoading = true;
                    this.episodes = [];
                    try {
                        // Call Server-side Proxy with Source
                        const eps = await @this.getApiDetailsServer(urlId, this.selectedSource);
                        this.episodes = eps || [];
                    } catch (e) {
                        console.error(e);
                        alert('Gagal mengambil daftar episode.');
                    } finally {
                        this.episodesLoading = false;
                    }
                },

                async importLink(episodeUrlId, title) {
                    const numberMatch = title.toString().match(/\d+/);
                    const number = numberMatch ? numberMatch[0] : '1';
                    
                    this.loading = true; // Use loading state for individual import
                    console.log(`Importing episode: ${title} (${episodeUrlId}) from ${this.selectedSource}`);
                    
                    try {
                        // Call Server-side Proxy using $wire
                        const finalUrl = await this.$wire.getApiVideoServer(episodeUrlId, this.selectedSource);
                        console.log(`Received URL: ${finalUrl}`);
                        
                        if(finalUrl && finalUrl !== 'null' && finalUrl !== '') {
                            await this.$wire.setApiData(finalUrl, number, title.toString());
                            window.scrollTo({top: 0, behavior: 'smooth'});
                        } else {
                            alert('Video tidak tersedia atau gagal diambil dari sumber ini.');
                        }
                    } catch (e) {
                        console.error('Import Error:', e);
                        alert('Terjadi kesalahan saat mengambil link streaming.');
                    } finally {
                        this.loading = false;
                    }
                },

                async importAll() {
                    if(!confirm(`Impor ${this.episodes.length} episode sekaligus? Proses ini memakan waktu beberapa saat.`)) return;
                    
                    this.bulkImporting = true;
                    this.currentProgress = 0;
                    let importedCount = 0;

                    const episodeList = [...this.episodes];

                    for(const ep of episodeList) {
                        // Delay 3s to avoid block
                        await new Promise(r => setTimeout(r, 2000));
                        
                        const numberMatch = ep.ch.toString().match(/\d+/);
                        const number = numberMatch ? numberMatch[0] : (this.currentProgress + 1);
                        
                        try {
                            const finalUrl = await this.$wire.getApiVideoServer(ep.url, this.selectedSource);
                            if(finalUrl && finalUrl !== 'null' && finalUrl !== '') {
                                await this.$wire.directSave(finalUrl, number, ep.ch.toString());
                                importedCount++;
                            }
                        } catch (e) {
                            console.error(`Gagal impor episode ${ep.ch}:`, e);
                        }

                        this.currentProgress++;
                    }

                    this.bulkImporting = false;
                    alert(`Selesai! Berhasil mengimpor ${importedCount} dari ${episodeList.length} episode.`);
                    window.location.reload(); 
                }
            }
        }
    </script>
</div>
