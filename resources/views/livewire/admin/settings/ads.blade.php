<div class="py-10">
    <div class="max-w-4xl mx-auto px-6">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-white uppercase tracking-tighter">Monetization <span class="text-red-600">& Ads</span></h1>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-widest mt-1">Atur iklan Adsense dan Sponsor untuk income website Anda.</p>
            </div>
            @if (session()->has('message'))
                <div class="px-4 py-2 bg-green-500/10 border border-green-500/20 rounded-xl text-green-500 text-[10px] font-black uppercase tracking-widest animate-pulse">
                    {{ session('message') }}
                </div>
            @endif
        </div>

        <form wire:submit.prevent="save" class="space-y-8">
            <!-- Google Adsense & A-Ads Section -->
            <div class="bg-[#0a0a0a] rounded-3xl border border-white/5 p-8 relative overflow-hidden group shadow-2xl">
                <div class="absolute top-0 right-0 w-64 h-64 bg-yellow-600/5 blur-[100px] pointer-events-none"></div>
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-yellow-600/10 rounded-xl flex items-center justify-center border border-yellow-600/20">
                        <i class="bi bi-code-slash text-yellow-600 text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-sm font-black text-white uppercase tracking-widest">Ad Network Scripts</h2>
                        <p class="text-[8px] text-gray-500 font-bold uppercase tracking-widest mt-1">Gunakan untuk Google AdSense atau <span class="text-yellow-600">A-Ads</span>.</p>
                    </div>
                </div>

                <div class="space-y-6 relative z-10">
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">AdSense Publisher ID (Client)</label>
                        <input wire:model="adsense_client" type="text" class="w-full bg-black border border-white/5 rounded-2xl px-5 py-4 text-xs text-white focus:outline-none focus:border-yellow-600/50 transition font-bold" placeholder="ca-pub-xxxxxxxxxxxxxxxx">
                        <p class="text-[8px] text-gray-600 font-bold uppercase mt-2 ml-1">Hanya untuk Google AdSense. Kosongkan jika menggunakan A-Ads atau network lain.</p>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Top Ads Code (Header)</label>
                            <textarea wire:model="adsense_header_code" rows="5" class="w-full bg-black border border-white/5 rounded-2xl px-5 py-4 text-[10px] text-white focus:outline-none focus:border-yellow-600/50 transition font-mono" placeholder="Paste script iklan A-Ads atau AdSense di sini..."></textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Bottom Ads Code (Footer/Sidebar)</label>
                            <textarea wire:model="adsense_sidebar_code" rows="5" class="w-full bg-black border border-white/5 rounded-2xl px-5 py-4 text-[10px] text-white focus:outline-none focus:border-yellow-600/50 transition font-mono" placeholder="Paste script iklan A-Ads atau AdSense di sini..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Donation Section -->
            <div class="bg-[#0a0a0a] rounded-3xl border border-white/5 p-8 relative overflow-hidden group shadow-2xl">
                <div class="absolute top-0 right-0 w-64 h-64 bg-green-600/5 blur-[100px] pointer-events-none"></div>
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-600/10 rounded-xl flex items-center justify-center border border-green-600/20">
                            <i class="bi bi-heart-fill text-green-600 text-lg"></i>
                        </div>
                        <h2 class="text-sm font-black text-white uppercase tracking-widest">Support & Donation</h2>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="donation_active" class="sr-only peer">
                        <div class="w-11 h-6 bg-zinc-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        <span class="ml-3 text-[10px] font-black text-gray-500 uppercase tracking-widest">Aktifkan Tombol Donasi</span>
                    </label>
                </div>

                <div class="space-y-6 relative z-10">
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Link Donasi (Trakteer / Saweria / Kopi / QRIS)</label>
                        <input wire:model="donation_link" type="text" class="w-full bg-black border border-white/5 rounded-2xl px-5 py-4 text-xs text-white focus:outline-none focus:border-green-600/50 transition font-bold" placeholder="https://trakteer.id/username atau https://saweria.co/username">
                        <p class="text-[8px] text-gray-600 font-bold uppercase mt-2 ml-1">Tombol donasi akan muncul di bawah video player untuk semua user.</p>
                    </div>
                </div>
            </div>

            <!-- Pop-under Section (Adsterra/Aggressive) -->
            <div class="bg-[#0a0a0a] rounded-3xl border border-white/5 p-8 relative overflow-hidden group shadow-2xl">
                <div class="absolute top-0 right-0 w-64 h-64 bg-purple-600/5 blur-[100px] pointer-events-none"></div>
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-purple-600/10 rounded-xl flex items-center justify-center border border-purple-600/20">
                        <i class="bi bi-cursor-fill text-purple-600 text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-sm font-black text-white uppercase tracking-widest">Pop-under Scripts</h2>
                        <p class="text-[8px] text-gray-500 font-bold uppercase tracking-widest mt-1">Gunakan untuk <span class="text-purple-600">Adsterra</span> atau PopAds.</p>
                    </div>
                </div>

                <div class="space-y-6 relative z-10">
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Pop-Under / Anti-Adblock Script Code</label>
                        <textarea wire:model="popunder_code" rows="5" class="w-full bg-black border border-white/5 rounded-2xl px-5 py-4 text-[10px] text-white focus:outline-none focus:border-purple-600/50 transition font-mono" placeholder="Paste script pop-under (Adsterra) di sini..."></textarea>
                        <p class="text-[8px] text-gray-600 font-bold uppercase mt-3 ml-1">INFO: Iklan pop-under akan muncul saat user mengklik layar/area manapun di website.</p>
                    </div>
                </div>
            </div>

            <!-- Sponsor Banner Section -->
            <div class="bg-[#0a0a0a] rounded-3xl border border-white/5 p-8 relative overflow-hidden group shadow-2xl">
                <div class="absolute top-0 right-0 w-64 h-64 bg-red-600/5 blur-[100px] pointer-events-none"></div>
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-600/10 rounded-xl flex items-center justify-center border border-red-600/20">
                            <i class="bi bi-megaphone-fill text-red-600 text-lg"></i>
                        </div>
                        <h2 class="text-sm font-black text-white uppercase tracking-widest">Sponsor / Direct Ads</h2>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="sponsor_active" class="sr-only peer">
                        <div class="w-11 h-6 bg-zinc-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                        <span class="ml-3 text-[10px] font-black text-gray-500 uppercase tracking-widest">Status Iklan</span>
                    </label>
                </div>

                <div class="space-y-6 relative z-10">
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Sponsor Banner Image URL</label>
                        <input wire:model="sponsor_banner_url" type="text" class="w-full bg-black border border-white/5 rounded-2xl px-5 py-4 text-xs text-white focus:outline-none focus:border-red-600/50 transition font-bold" placeholder="https://example.com/banner.png">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Sponsor Link Destination</label>
                        <input wire:model="sponsor_link" type="text" class="w-full bg-black border border-white/5 rounded-2xl px-5 py-4 text-xs text-white focus:outline-none focus:border-red-600/50 transition font-bold" placeholder="https://shope.ee/xxxxx">
                    </div>

                    @if($sponsor_banner_url)
                        <div class="pt-4">
                            <label class="block text-[8px] font-black text-gray-600 uppercase tracking-widest mb-3 ml-1">Preview Iklan Sponsor</label>
                            <div class="relative w-full aspect-[4/1] md:aspect-[8/1] rounded-2xl overflow-hidden border border-white/5">
                                <img src="{{ $sponsor_banner_url }}" class="w-full h-full object-cover">
                                <div class="absolute top-2 right-2 px-2 py-0.5 bg-black/50 backdrop-blur-md rounded text-[6px] font-bold text-white uppercase border border-white/10 uppercase tracking-widest">Sponsor</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="btn-gradient px-12 py-4 rounded-2xl text-white font-black uppercase text-xs tracking-widest shadow-2xl shadow-red-900/40">
                    Simpan Konfigurasi
                </button>
            </div>
        </form>

        <div class="mt-20 p-8 bg-zinc-900/30 rounded-3xl border border-white/5">
            <h3 class="text-[10px] font-black text-white uppercase tracking-widest mb-4 flex items-center gap-2">
                <i class="bi bi-info-circle text-red-500"></i>
                Catatan Penting
            </h3>
            <ul class="space-y-3">
                <li class="text-[9px] text-gray-500 font-bold uppercase tracking-widest leading-relaxed flex items-start gap-2">
                    <span class="text-red-500 mt-1">•</span>
                    Iklan hanya akan muncul untuk user yang <span class="text-red-500">BUKAN PREMIUM</span>.
                </li>
                <li class="text-[9px] text-gray-500 font-bold uppercase tracking-widest leading-relaxed flex items-start gap-2">
                    <span class="text-red-500 mt-1">•</span>
                    Pastikan AdSense Code sudah lengkap dengan tag &lt;script&gt; jika ingin menggunakan kode manual.
                </li>
            </ul>
        </div>
    </div>
</div>
