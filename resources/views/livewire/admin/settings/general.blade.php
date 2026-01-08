    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h3 class="text-2xl font-black text-white uppercase tracking-tighter">General Settings</h3>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">Configure global application settings</p>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-500 px-6 py-4 rounded-xl mb-8 flex items-center gap-3 text-sm font-bold">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-[#0a0a0a] rounded-2xl border border-white/5 p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-red-600/5 blur-[50px] pointer-events-none"></div>

            <form wire:submit="saveLogo" class="relative z-10 space-y-6">
                <div>
                     <label class="block font-black text-[10px] tracking-[0.2em] uppercase text-gray-500 mb-4">Site Logo</label>
                     
                     <div class="flex items-center gap-6">
                        @if ($logo)
                             <div class="w-24 h-24 bg-white/5 rounded-xl border border-white/10 flex items-center justify-center overflow-hidden">
                                <img src="{{ $logo->temporaryUrl() }}" class="w-full h-full object-cover">
                             </div>
                        @elseif($existingLogo)
                             <div class="w-24 h-24 bg-white/5 rounded-xl border border-white/10 flex items-center justify-center overflow-hidden">
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($existingLogo) }}" class="w-full h-full object-cover">
                             </div>
                        @else
                             <div class="w-24 h-24 bg-white/5 rounded-xl border border-white/10 flex items-center justify-center">
                                 <span class="text-gray-600 text-xs font-bold uppercase">No Logo</span>
                             </div>
                        @endif

                        <div class="flex-1">
                            <input type="file" wire:model="logo" id="logo_upload" class="hidden" accept="image/*">
                            <label for="logo_upload" class="inline-flex items-center gap-2 px-6 py-3 bg-white/5 border border-white/10 hover:bg-white/10 transition rounded-xl cursor-pointer text-xs font-bold uppercase tracking-widest text-white">
                                <i class="bi bi-upload"></i> Upload New Logo
                            </label>
                            <p class="mt-2 text-[10px] text-gray-600">Recommended size: 66x66 px. Max 1MB.</p>
                            @error('logo') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                     </div>
                </div>

                <div class="pt-6 border-t border-white/5 flex justify-end">
                    <button type="submit" class="btn-gradient bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest transition shadow-lg shadow-red-900/20">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
