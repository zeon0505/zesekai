@php
    $episodesList = $anime->episodes->sortBy('episode_number')->values()->map(function($ep) use ($anime) {
        return [
            'id' => $ep->id,
            'number' => $ep->episode_number,
            'title' => $ep->title ?? 'Episode ' . $ep->episode_number,
            'url' => $ep->video_url,
            'thumbnail' => $ep->thumbnail_image ?? $anime->poster_image,
        ];
    });
@endphp

<div class="min-h-screen bg-black text-white" 
     x-data="animePlayer(@js([
        'epList' => $episodesList,
        'animeTitle' => $anime->title,
        'animeSlug' => $anime->slug,
        'animePoster' => $anime->poster_image,
        'initialEpId' => $initialEpisodeId,
     ]))"
     @limit-reached.window="showLimitModal = true">
    
    <div x-cloak x-show="showLimitModal" class="fixed inset-0 z-[1000] flex items-center justify-center p-6 transition-all duration-500">
        <div class="absolute inset-0 bg-black/90 backdrop-blur-xl" @click="showLimitModal = false"></div>
        <div class="relative bg-zinc-950 border border-white/5 p-10 rounded-[40px] max-w-lg w-full text-center shadow-[0_0_100px_rgba(220,38,38,0.2)]"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            <div class="w-24 h-24 bg-red-600 rounded-full flex items-center justify-center mx-auto mb-8 shadow-[0_0_40px_rgba(220,38,38,0.4)]">
                <i class="bi bi-lock-fill text-4xl text-white"></i>
            </div>
            <h2 class="text-3xl font-black uppercase tracking-tighter mb-4 text-white uppercase">Limit Tercapai!</h2>
            <p class="text-zinc-500 text-sm mb-10 leading-relaxed font-medium">Anda telah menggunakan jatah 3 tontonan gratis hari ini. Ingin menonton sepuasnya tanpa batas?</p>
            <div class="flex flex-col gap-4">
                <a href="{{ route('profile') }}" class="px-10 py-4 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition">Upgrade ke Premium</a>
                <button @click="showLimitModal = false" class="px-10 py-4 bg-zinc-900 text-zinc-400 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition">Mungkin Nanti</button>
            </div>
        </div>
    </div>
    
    <!-- Hero / Info Utama -->
    <div x-show="!currentUrl" class="relative w-full min-h-screen">
        <div class="fixed inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/90 to-black/50 z-10"></div>
            @if($anime->banner_image || $anime->poster_image)
                <img src="{{ $anime->banner_image ?? $anime->poster_image }}" class="w-full h-full object-cover blur-3xl opacity-20 scale-110">
            @endif
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 pt-12 pb-20">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-red-600 hover:text-red-500 transition font-black uppercase text-[10px] tracking-widest mb-12">
                <i class="bi bi-arrow-left"></i> Kembali ke Beranda
            </a>

            <div class="flex flex-col md:flex-row gap-10">
                <div class="flex-shrink-0 w-48 md:w-52">
                    <div class="rounded-2xl overflow-hidden shadow-2xl border border-white/5 ring-1 ring-white/5">
                        <img src="{{ $anime->poster_image }}" class="w-full aspect-[3/4.5] object-cover">
                    </div>
                </div>

                <div class="flex-1">
                    <h1 class="text-3xl md:text-5xl font-black uppercase tracking-tighter mb-4 text-white leading-tight">{{ $anime->title }}</h1>
                    <div class="flex items-center gap-3 text-[10px] font-black uppercase tracking-widest text-zinc-500 mb-8">
                        <span class="text-red-600">{{ $anime->status }}</span>
                        <span class="w-1.5 h-1.5 bg-zinc-800 rounded-full"></span>
                        <span>{{ $anime->type }}</span>
                        <span class="w-1.5 h-1.5 bg-zinc-800 rounded-full"></span>
                        <span>{{ count($anime->episodes) }} EPS</span>
                    </div>

                    <div class="flex flex-wrap gap-4 mb-10">
                        <button @click="document.getElementById('ep-list').scrollIntoView({behavior: 'smooth'})" 
                                class="px-10 py-3.5 bg-red-600 hover:bg-red-700 text-white rounded-full font-black text-[11px] uppercase tracking-widest transition shadow-lg shadow-red-900/40">
                            Watch Now
                        </button>
                        <livewire:components.watchlist-button :animeId="$anime->id" />
                    </div>

                    <p class="text-zinc-500 text-sm leading-relaxed max-w-2xl font-medium italic line-clamp-3 mb-10">{{ $anime->synopsis }}</p>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-8 pt-8 border-t border-white/5">
                        <div class="space-y-1">
                            <div class="text-[9px] font-black text-zinc-600 uppercase">Released</div>
                            <div class="text-xs font-bold text-zinc-400">{{ $anime->aired_at ? $anime->aired_at->format('M d, Y') : 'TBA' }}</div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-[9px] font-black text-zinc-600 uppercase">Studio</div>
                            <div class="text-xs font-bold text-zinc-400">N/A</div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-[9px] font-black text-zinc-600 uppercase">Genre</div>
                            <div class="text-xs font-bold text-red-600/80">{{ $anime->genres->pluck('name')->join(', ') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- List Episode Grid -->
            <div id="ep-list" class="mt-20">
                <div class="flex items-center gap-4 mb-10">
                    <span class="w-1.5 h-8 bg-red-600 rounded-full"></span>
                    <h2 class="text-3xl font-black uppercase tracking-tighter text-white">Episodes</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <template x-for="ep in epList" :key="ep.id">
                        <button @click="playEp(ep)" class="group flex items-center gap-4 bg-zinc-900/30 border border-white/5 p-3.5 rounded-2xl hover:border-red-600/30 transition-all duration-300 text-left">
                            <div class="w-20 h-14 rounded-xl overflow-hidden flex-shrink-0 relative shadow-lg">
                                <img :src="ep.thumbnail" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-red-600/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <i class="bi bi-play-fill text-xl"></i>
                                </div>
                            </div>
                            <div class="overflow-hidden">
                                <div class="text-[12px] font-black uppercase text-white truncate" x-text="ep.title"></div>
                                <div class="text-[9px] font-bold text-zinc-500 uppercase tracking-widest mt-0.5" x-text="'Episode ' + ep.number"></div>
                            </div>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Menonton Modal-Like View -->
    <div x-show="currentUrl" class="fixed inset-0 z-[200] bg-black overflow-y-auto pt-12 pb-20" x-transition>
        <div class="max-w-3xl mx-auto px-6">
            <!-- Navbar Tonton -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-1.5 h-6 bg-red-600 rounded-full shadow-[0_0_15px_rgba(220,38,38,0.6)]"></div>
                    <div>
                        <h2 class="text-base md:text-lg font-black uppercase text-white tracking-tight leading-none" x-text="currentEpisodeTitle"></h2>
                        <p class="text-[7px] font-black text-red-500 uppercase tracking-[0.4em] mt-1.5">ZESEKAI PLAYER</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 bg-zinc-900/60 p-1.5 rounded-full border border-white/5 backdrop-blur-md">
                    <button @click="prevEp" class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center hover:bg-red-600 transition disabled:opacity-20" :disabled="!epList.find(e => e.number < currentNumber)">
                        <i class="bi bi-chevron-left text-xs"></i>
                    </button>
                    <button @click="nextEp" class="px-5 py-2 bg-red-600 text-white text-[8px] font-black uppercase tracking-widest rounded-full hover:bg-red-700 transition disabled:opacity-20 shadow-lg shadow-red-900/20" :disabled="!epList.find(e => e.number > currentNumber)">
                        Next
                    </button>
                    <button @click="currentUrl = ''; if(window.player) window.player.stop();" class="w-8 h-8 rounded-full bg-white/5 text-zinc-500 hover:text-white transition flex items-center justify-center">
                        <i class="bi bi-x-lg text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- PLAYER BOX (IFRAME VS NATIVE) -->
            <div class="aspect-video bg-zinc-950 rounded-2xl overflow-hidden shadow-[0_30px_100px_rgba(0,0,0,0.8)] border border-white/10 ring-1 ring-red-600/10 mb-8 relative group">
                <!-- Native Player -->
                <template x-if="!isEmbed">
                    <div class="w-full h-full" wire:ignore>
                        <video id="player" playsinline controls class="w-full h-full object-contain"></video>
                    </div>
                </template>

                <!-- Embed Player -->
                <template x-if="isEmbed">
                    <iframe id="player-frame" :src="currentUrl" class="w-full h-full border-0 absolute inset-0" allowfullscreen allow="autoplay; encrypted-media" referrerpolicy="no-referrer"></iframe>
                </template>
            </div>

            @if(!auth()->user()?->is_premium)
                @php
                    $headerAds = \App\Models\Setting::get('adsense_header_code');
                    $sidebarAds = \App\Models\Setting::get('adsense_sidebar_code');
                    $sponsorActive = \App\Models\Setting::get('sponsor_active');
                    $sponsorImg = \App\Models\Setting::get('sponsor_banner_url');
                    $sponsorLink = \App\Models\Setting::get('sponsor_link');
                @endphp

                <!-- ADS SECTION for NON-PREMIUM -->
                <div class="mb-12 space-y-6">
                    @if($sponsorActive && $sponsorImg)
                        <!-- Sponsor Banner -->
                        <div class="relative group">
                            <a href="{{ $sponsorLink }}" target="_blank" class="block w-full aspect-[4/1] md:aspect-[8/1] rounded-2xl overflow-hidden border border-white/5 relative">
                                <img src="{{ $sponsorImg }}" class="w-full h-full object-cover">
                                <div class="absolute top-2 right-2 px-2 py-0.5 bg-black/50 backdrop-blur-md rounded text-[6px] font-bold text-white uppercase border border-white/10 tracking-widest">Sponsor</div>
                            </a>
                        </div>
                    @endif

                    @if($headerAds)
                        <div class="bg-zinc-900/10 rounded-xl overflow-hidden flex justify-center py-2 border border-white/5">
                            {!! $headerAds !!}
                        </div>
                    @endif

                    <div class="bg-[#0a0a0a] border border-red-600/20 rounded-2xl p-4 relative overflow-hidden group">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-red-600/10 rounded-xl flex items-center justify-center border border-red-600/20">
                                    <i class="bi bi-star-fill text-red-600"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-black text-white uppercase tracking-tight">Iklan Terdeteksi</h4>
                                    <p class="text-[8px] text-gray-500 font-bold uppercase tracking-widest mt-0.5">Hapus iklan & tonton 1080p dengan Premium</p>
                                </div>
                            </div>
                            <a href="{{ route('subscription') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-red-700 transition">Upgrade</a>
                        </div>
                    </div>

                    @if($sidebarAds)
                        <div class="bg-zinc-900/10 rounded-xl overflow-hidden flex justify-center py-2 border border-white/5">
                            {!! $sidebarAds !!}
                        </div>
                    @endif
                </div>
            @endif

            @php
                $donationActive = \App\Models\Setting::get('donation_active');
                $donationLink = \App\Models\Setting::get('donation_link');
            @endphp

            @if($donationActive && $donationLink)
                <!-- DONATION SECTION -->
                <div class="mb-12">
                    <div class="bg-zinc-900/20 border border-white/5 rounded-3xl p-6 md:p-10 flex flex-col md:flex-row items-center gap-6 md:gap-10 relative overflow-hidden group shadow-2xl">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-green-600/5 blur-[50px] pointer-events-none"></div>
                        <div class="flex-shrink-0 relative">
                            <div class="w-16 h-16 bg-green-600/10 rounded-2xl flex items-center justify-center border border-green-600/20 shadow-lg">
                                <i class="bi bi-heart-fill text-green-600 text-2xl animate-pulse"></i>
                            </div>
                        </div>
                        <div class="text-center md:text-left flex-1 relative z-10">
                            <h3 class="text-lg font-black text-white uppercase tracking-tighter mb-2">Suka dengan ZESEKAI?</h3>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest leading-loose">Dukung kami untuk biaya server agar tetap lancar update setiap hari. Traktir admin kopi atau gorengan!</p>
                        </div>
                        <div class="relative z-10 w-full md:w-auto">
                            <a href="{{ $donationLink }}" target="_blank" class="block w-full text-center px-8 py-4 bg-green-600 hover:bg-green-700 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl transition shadow-xl shadow-green-900/40">
                                Support via Trakteer / Saweria
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Troubleshoot & Episodes Below -->
            <div class="flex flex-col items-center gap-10">
                <a :href="currentUrl" target="_blank" class="px-6 py-2 bg-zinc-900/50 border border-white/5 rounded-full text-[8px] font-black uppercase text-zinc-500 hover:text-red-500 hover:border-red-600/30 transition flex items-center gap-2 group">
                    <i class="bi bi-box-arrow-up-right group-hover:-translate-y-0.5 transition-transform"></i> Tonton di Server Asli
                </a>

                <div class="w-full h-px bg-gradient-to-r from-transparent via-white/5 to-transparent"></div>

                <div class="w-full">
                    <h3 class="text-[9px] font-black uppercase text-zinc-600 tracking-[0.4em] mb-8 text-center">Episode List</h3>
                    <div class="flex flex-wrap justify-center gap-2.5">
                        <template x-for="ep in epList" :key="ep.id">
                            <button @click="playEp(ep)" 
                                    :class="currentNumber === ep.number ? 'bg-red-600 text-white shadow-xl shadow-red-900/30 border-red-600' : 'bg-zinc-900/50 text-zinc-500 border-white/5 hover:border-zinc-700'"
                                    class="w-11 h-11 rounded-xl border font-black text-[10px] transition-all duration-300 flex items-center justify-center">
                                <span x-text="ep.number"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('animePlayer', (config) => ({
        isLoading: false,
        currentUrl: '',
        currentEpisodeTitle: '',
        currentNumber: 1,
        currentEpisodeId: null,
        isEmbed: true,
        epList: config.epList,
        showLimitModal: false,

        init() {
            if(config.initialEpId) {
                const ep = this.epList.find(e => e.id == config.initialEpId);
                if(ep) this.playEp(ep);
            } else {
                const localHist = JSON.parse(localStorage.getItem('zesekai_history') || '[]');
                const found = localHist.find(h => h.anime_slug == config.animeSlug);
                if(found) {
                    const ep = this.epList.find(e => e.id == found.ep_id);
                    if(ep) this.playEp(ep);
                }
            }
        },

        async playEp(ep) {
            this.isLoading = true;
            try {
                const result = await this.$wire.playEpisode(ep.id);
                if (!result) { this.isLoading = false; return; }
                
                this.currentEpisodeId = result.id;
                let url = result.url;
                this.currentEpisodeTitle = result.title;
                this.currentNumber = result.number;
                
                this.isEmbed = true;
                if (url.includes('pixeldrain.com')) {
                    const id = url.split('/').pop().split('?')[0];
                    url = 'https://pixeldrain.com/api/file/' + id;
                    this.isEmbed = false;
                } else if (url.includes('krakenfiles.com/view/')) {
                    url = url.replace('/view/', '/embed/');
                    this.isEmbed = true;
                } else {
                    const directExts = ['.mp4', '.m3u8', '.webm'];
                    const isDirect = directExts.some(ext => url.toLowerCase().split('?')[0].endsWith(ext));
                    if (isDirect) this.isEmbed = false;
                }

                this.currentUrl = url;
                if(!this.isEmbed) this.initPlyr(url);
                
                this.saveHistory(result, config.animeTitle, config.animeSlug, config.animePoster);

                window.scrollTo({top: 0, behavior: 'smooth'});
            } catch (e) {
                console.error('PlayEp Error:', e);
            } finally {
                this.isLoading = false;
            }
        },

        saveHistory(ep, animeTitle, animeSlug, animePoster) {
            let history = JSON.parse(localStorage.getItem('zesekai_history') || '[]');
            const item = {
                ep_id: ep.id, ep_number: ep.number, ep_title: ep.title,
                anime_title: animeTitle, anime_slug: animeSlug, anime_poster: animePoster,
                watched_at: new Date().toISOString()
            };
            const existingIndex = history.findIndex(h => h.anime_slug === animeSlug);
            if(existingIndex !== -1) {
                history.splice(existingIndex, 1);
            }
            history.unshift(item);
            history = history.slice(0, 10);
            localStorage.setItem('zesekai_history', JSON.stringify(history));
        },

        initPlyr(url) {
            if (window.player) { window.player.destroy(); window.player = null; }
            this.$nextTick(() => {
                const video = document.getElementById('player');
                if(!video) return;

                if (url.includes('.m3u8')) {
                    if (typeof Hls !== 'undefined' && Hls.isSupported()) {
                        const hls = new Hls(); hls.loadSource(url); hls.attachMedia(video);
                    }
                } else { video.src = url; }

                window.player = new Plyr(video, {
                    controls: ['play-large', 'play', 'progress', 'current-time', 'duration', 'mute', 'volume', 'settings', 'fullscreen'],
                    autoplay: true,
                });
                
                video.addEventListener('canplay', () => { this.isLoading = false; });
            });
        },

        nextEp() {
            const next = this.epList.find(e => e.number > this.currentNumber);
            if(next) this.playEp(next);
        },

        prevEp() {
            const prev = [...this.epList].reverse().find(e => e.number < this.currentNumber);
            if(prev) this.playEp(prev);
        }
    }));
});
</script>
