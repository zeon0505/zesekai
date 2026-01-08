<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-2xl font-black text-white uppercase tracking-tighter">Anime List</h3>
            <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">Manage database content</p>
        </div>
        <a href="{{ route('admin.anime.create') }}" class="btn-gradient bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest transition shadow-lg shadow-red-900/20 flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> Add New Anime
        </a>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-500 px-6 py-4 rounded-xl mb-8 flex items-center gap-3 text-sm font-bold">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-[#0a0a0a] rounded-2xl border border-white/5 overflow-hidden relative">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-red-600/5 blur-[50px] pointer-events-none"></div>

        <!-- Toolbar -->
        <div class="p-6 border-b border-white/5 flex justify-between items-center bg-white/[0.01]">
            <div class="relative w-72">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search anime..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-black border border-white/10 rounded-xl text-sm text-white focus:outline-none focus:border-red-600/50 focus:ring-1 focus:ring-red-600/50 transition placeholder-gray-700">
                <i class="bi bi-search absolute left-3 top-3 text-gray-600 text-xs"></i>
            </div>
            <div class="text-[10px] text-gray-600 font-black uppercase tracking-[0.2em]">
                Total: {{ $animes->total() }} items
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02] text-gray-500 text-[10px] font-black uppercase tracking-widest border-b border-white/5">
                        <th class="px-6 py-5">Poster</th>
                        <th class="px-6 py-5">Title</th>
                        <th class="px-6 py-5">Status</th>
                        <th class="px-6 py-5 text-center">Premium</th>
                        <th class="px-6 py-5 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($animes as $anime)
                        <tr class="hover:bg-white/[0.02] transition duration-200 group">
                            <td class="px-6 py-4 align-middle">
                                <div class="w-10 h-14 rounded overflow-hidden bg-gray-800 border border-white/10 group-hover:border-red-600/50 transition-colors">
                                    <img src="{{ $anime->poster_image }}" alt="" class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="text-white font-bold text-sm group-hover:text-red-500 transition-colors">{{ $anime->title }}</div>
                                <div class="text-[10px] text-gray-600 mt-1 uppercase tracking-wide">{{ optional($anime->studio)->name }}</div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <span class="px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-wider
                                    {{ $anime->status == 'Ongoing' ? 'bg-green-500/10 text-green-500 border border-green-500/20' : 'bg-gray-800 text-gray-400 border border-gray-700' }}">
                                    {{ $anime->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle text-center">
                                @if($anime->is_premium)
                                    <span class="text-yellow-500 text-sm glow-gold"><i class="bi bi-star-fill"></i></span>
                                @else
                                    <span class="text-gray-800 text-sm"><i class="bi bi-star"></i></span>
                                @endif
                            </td>
                            <td class="px-6 py-4 align-middle text-right">
                                <div class="flex justify-end gap-3 opacity-60 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.anime.episodes.index', $anime->id) }}" class="text-green-500 hover:text-green-400 transition" title="Manage Episodes">
                                        <i class="bi bi-collection-play-fill text-lg"></i>
                                    </a>
                                    <a href="{{ route('admin.anime.edit', $anime->id) }}" class="text-blue-500 hover:text-blue-400 transition" title="Edit">
                                        <i class="bi bi-pencil-square text-lg"></i>
                                    </a>
                                    <button wire:click="confirmDelete({{ $anime->id }})" 
                                            class="text-red-600 hover:text-red-500 transition" title="Delete">
                                        <i class="bi bi-trash text-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-700">
                                    <i class="bi bi-inbox-fill text-4xl mb-3 opacity-50"></i>
                                    <span class="text-xs font-bold uppercase tracking-widest">No anime found in database</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-white/5 bg-white/[0.01]">
            <div class="text-white">
                 {{ $animes->links() }}
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-modal name="confirm-anime-delete" :show="false" focusable>
        <div class="p-6 text-center">
            <div class="flex justify-center mb-6">
                <!-- Icon -->
                <div class="w-20 h-20 bg-red-600/10 rounded-full flex items-center justify-center border border-red-600/20">
                    <i class="bi bi-exclamation-triangle-fill text-4xl text-red-600"></i>
                </div>
            </div>

            <h2 class="text-2xl font-black uppercase tracking-tighter text-white mb-2">
                Delete Anime?
            </h2>

            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-8">
                This action cannot be undone. All episodes associated with this anime will also be deleted.
            </p>

            <div class="flex justify-center gap-4">
                <button x-on:click="$dispatch('close')" class="px-6 py-3 rounded-xl border border-white/10 text-xs font-bold uppercase tracking-widest text-gray-400 hover:bg-white/5 transition">
                    Cancel
                </button>
                <button wire:click="deleteConfirmed" class="px-6 py-3 rounded-xl bg-red-600 text-xs font-bold uppercase tracking-widest text-white hover:bg-red-700 shadow-lg shadow-red-900/20 transition">
                    Delete It!
                </button>
            </div>
        </div>
    </x-modal>
</div>
