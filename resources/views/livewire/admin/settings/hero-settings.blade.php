<div>
    <div class="mb-6">
        <h3 class="text-2xl font-black text-white uppercase tracking-tighter">Hero Section Settings</h3>
        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Manage landing page visual elements</p>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-500 px-6 py-4 rounded-xl mb-6 flex items-center gap-3 text-xs font-bold uppercase tracking-widest">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-[#0a0a0a] rounded-2xl border border-white/5 p-8 relative overflow-hidden shadow-2xl">
            <form wire:submit="save" class="space-y-6 relative z-10">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Poster Hero 1 (Besar)</label>
                    <div class="flex gap-4 items-start mb-4">
                        <div class="flex-1">
                            <input wire:model="image1" type="text" class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-[10px] text-white focus:border-red-600/50 focus:outline-none transition mb-2" placeholder="URL Gambar...">
                            <div class="relative">
                                <input type="file" wire:model="upload1" class="hidden" id="upload1" accept="image/*">
                                <label for="upload1" class="flex items-center justify-center gap-2 w-full py-3 bg-zinc-900 border border-white/5 rounded-xl cursor-pointer hover:bg-zinc-800 transition text-[10px] font-black uppercase text-zinc-400 tracking-widest">
                                    <i class="bi bi-cloud-upload"></i> Upload File
                                </label>
                            </div>
                        </div>
                        <div class="aspect-[3/4.5] w-32 rounded-xl flex-shrink-0 bg-transparent">
                            @if ($upload1)
                                <img src="{{ $upload1->temporaryUrl() }}" class="w-full h-full object-contain">
                            @else
                                <img src="{{ $image1 }}" class="w-full h-full object-contain" onerror="this.src='https://placehold.co/600x900/000000/FFFFFF?text=Invalid+URL'">
                            @endif
                        </div>
                    </div>
                    @error('upload1') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-6 border-t border-white/5">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Poster Hero 2 (Kecil/Belakang)</label>
                    <div class="flex gap-4 items-start mb-4">
                        <div class="flex-1">
                            <input wire:model="image2" type="text" class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-[10px] text-white focus:border-red-600/50 focus:outline-none transition mb-2" placeholder="URL Gambar...">
                            <div class="relative">
                                <input type="file" wire:model="upload2" class="hidden" id="upload2" accept="image/*">
                                <label for="upload2" class="flex items-center justify-center gap-2 w-full py-3 bg-zinc-900 border border-white/5 rounded-xl cursor-pointer hover:bg-zinc-800 transition text-[10px] font-black uppercase text-zinc-400 tracking-widest">
                                    <i class="bi bi-cloud-upload"></i> Upload File
                                </label>
                            </div>
                        </div>
                        <div class="aspect-[3/4.5] w-32 rounded-xl flex-shrink-0 bg-transparent">
                            @if ($upload2)
                                <img src="{{ $upload2->temporaryUrl() }}" class="w-full h-full object-contain">
                            @else
                                <img src="{{ $image2 }}" class="w-full h-full object-contain" onerror="this.src='https://placehold.co/600x900/000000/FFFFFF?text=Invalid+URL'">
                            @endif
                        </div>
                    </div>
                    @error('upload2') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-6 border-t border-white/5 flex justify-end">
                    <button type="submit" class="px-10 py-4 rounded-xl bg-red-600 hover:bg-red-700 text-white font-black text-[11px] uppercase tracking-widest transition shadow-lg shadow-red-900/30 active:scale-95">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <div class="space-y-6">
            <div class="bg-red-600/10 border border-red-600/20 p-6 rounded-2xl">
                <h4 class="text-xs font-black text-white uppercase tracking-widest mb-3 flex items-center gap-2">
                    <i class="bi bi-info-circle"></i> Petunjuk
                </h4>
                <ul class="text-[10px] text-gray-400 font-bold uppercase tracking-widest leading-relaxed space-y-2">
                    <li>• Masukkan URL gambar poster (3:4) untuk tampilan landing page.</li>
                    <li>• Poster 1 adalah poster utama yang berada di depan.</li>
                    <li>• Poster 2 adalah poster pendukung yang berada di posisi belakang.</li>
                    <li>• Klik Save Changes untuk langsung memperbarui tampilan depan.</li>
                </ul>
            </div>
            
            <div class="bg-[#0a0a0a] border border-white/5 p-6 rounded-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-red-600/5 blur-3xl"></div>
                <h4 class="text-xs font-black text-white uppercase tracking-widest mb-4">Preview Landing Page</h4>
                <div class="bg-black aspect-video rounded-xl border border-white/10 flex items-center justify-center p-4">
                     <div class="relative flex items-center">
                         <div class="w-16 h-28 rounded-lg overflow-hidden translate-x-4 rotate-6 z-20">
                             <img src="{{ $upload1 ? $upload1->temporaryUrl() : $image1 }}" class="w-full h-full object-contain">
                         </div>
                         <div class="absolute -left-4 w-12 h-24 rounded-lg overflow-hidden -rotate-3 opacity-30">
                             <img src="{{ $upload2 ? $upload2->temporaryUrl() : $image2 }}" class="w-full h-full object-contain">
                         </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
