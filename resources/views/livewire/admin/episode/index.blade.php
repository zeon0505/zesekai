<div>
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-2xl font-black text-white uppercase tracking-tighter">Episodes: {{ $anime->title }}</h3>
            <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">Manage episodes for this anime</p>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('admin.anime.index') }}" class="text-gray-400 hover:text-white font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 transition px-4 py-3 rounded-xl border border-white/5">
                <i class="bi bi-arrow-left"></i> Back to Anime
            </a>
            <a href="{{ route('admin.anime.episodes.create', $anime->id) }}" class="btn-gradient bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest transition shadow-lg shadow-red-900/20 flex items-center gap-2">
                <i class="bi bi-plus-lg"></i> Add Episode
            </a>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-500 px-6 py-4 rounded-xl mb-8 flex items-center gap-3 text-sm font-bold">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-[#0a0a0a] rounded-2xl border border-white/5 overflow-hidden relative">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02] text-gray-500 text-[10px] font-black uppercase tracking-widest border-b border-white/5">
                        <th class="px-6 py-5">No</th>
                        <th class="px-6 py-5">Title</th>
                        <th class="px-6 py-5">Stream URL</th>
                        <th class="px-6 py-5 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($episodes as $episode)
                        <tr class="hover:bg-white/[0.02] transition duration-200 group">
                            <td class="px-6 py-4 align-middle">
                                <div class="text-white font-bold text-sm bg-white/5 w-8 h-8 rounded flex items-center justify-center border border-white/5">
                                    {{ $episode->episode_number }}
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="text-white font-bold text-sm">{{ $episode->title ?? 'Episode ' . $episode->episode_number }}</div>
                            </td>
                            <td class="px-6 py-4 align-middle max-w-xs">
                                <div class="text-[10px] text-gray-500 truncate" title="{{ $episode->video_url }}">{{ $episode->video_url }}</div>
                            </td>
                            <td class="px-6 py-4 align-middle text-right">
                                <div class="flex justify-end gap-3 opacity-60 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.anime.episodes.edit', ['anime' => $anime->id, 'episode' => $episode->id]) }}" class="text-blue-500 hover:text-blue-400 transition" title="Edit">
                                        <i class="bi bi-pencil-square text-lg"></i>
                                    </a>
                                    <button wire:click="confirmDelete({{ $episode->id }})" 
                                            class="text-red-600 hover:text-red-500 transition" title="Delete">
                                        <i class="bi bi-trash text-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center text-gray-700 font-bold uppercase text-xs">Belum ada episode.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-white/5">
            {{ $episodes->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-modal name="confirm-episode-delete" :show="false" focusable>
        <div class="p-6 text-center">
            <div class="flex justify-center mb-6">
                <!-- Icon -->
                <div class="w-20 h-20 bg-red-600/10 rounded-full flex items-center justify-center border border-red-600/20">
                    <i class="bi bi-trash-fill text-4xl text-red-600"></i>
                </div>
            </div>

            <h2 class="text-2xl font-black uppercase tracking-tighter text-white mb-2">
                Delete Episode?
            </h2>

            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-8">
                Are you sure? This episode will be permanently removed.
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
