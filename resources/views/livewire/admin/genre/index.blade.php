<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-2xl font-black text-white uppercase tracking-tighter">Genre List</h3>
            <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">Manage anime genres</p>
        </div>
        <a href="{{ route('admin.genres.create') }}" class="btn-gradient bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest transition shadow-lg shadow-red-900/20 flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> Add New Genre
        </a>
    </div>

    <div class="bg-[#0a0a0a] rounded-2xl border border-white/5 overflow-hidden relative">
        <div class="absolute top-0 right-0 w-32 h-32 bg-red-600/5 blur-[50px] pointer-events-none"></div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02] text-gray-500 text-[10px] font-black uppercase tracking-widest border-b border-white/5">
                        <th class="px-6 py-5">Name</th>
                        <th class="px-6 py-5">Slug</th>
                        <th class="px-6 py-5 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($genres as $genre)
                        <tr class="hover:bg-white/[0.02] transition duration-200 group">
                            <td class="px-6 py-4 align-middle">
                                <div class="text-white font-bold text-sm">{{ $genre->name }}</div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <span class="text-gray-500 text-xs font-mono">{{ $genre->slug }}</span>
                            </td>
                            <td class="px-6 py-4 align-middle text-right">
                                <div class="flex justify-end gap-3 opacity-60 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.genres.edit', $genre->id) }}" class="text-blue-500 hover:text-blue-400 transition" title="Edit">
                                        <i class="bi bi-pencil-square text-lg"></i>
                                    </a>
                                    <button wire:click="delete({{ $genre->id }})" 
                                            wire:confirm="Are you sure you want to delete this genre?"
                                            class="text-red-600 hover:text-red-500 transition" title="Delete">
                                        <i class="bi bi-trash text-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-16 text-center text-gray-600 font-bold text-xs uppercase tracking-widest">
                                No genres found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-white/5 bg-white/[0.01]">
            {{ $genres->links() }}
        </div>
    </div>
</div>
