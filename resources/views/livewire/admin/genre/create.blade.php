<div>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-2xl font-black text-white uppercase tracking-tighter">New Genre</h3>
            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Add a new genre</p>
        </div>
        <a href="{{ route('admin.genres.index') }}" class="text-gray-400 hover:text-white font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 transition">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="bg-[#0a0a0a] rounded-2xl border border-white/5 p-8 relative overflow-hidden max-w-2xl">
        <form wire:submit="save" class="space-y-6 relative z-10">
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Genre Name</label>
                <input wire:model="name" type="text" class="w-full bg-black border border-white/10 rounded-xl px-4 py-3 text-white focus:border-red-600/50 focus:outline-none transition" placeholder="e.g. Action">
                @error('name') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <a href="{{ route('admin.genres.index') }}" class="px-6 py-3 rounded-xl text-gray-400 hover:text-white font-bold text-[10px] uppercase tracking-widest transition">Cancel</a>
                <button type="submit" class="px-8 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-black text-[10px] uppercase tracking-widest transition shadow-lg shadow-red-900/20">
                    Save Genre
                </button>
            </div>
        </form>
    </div>
</div>
