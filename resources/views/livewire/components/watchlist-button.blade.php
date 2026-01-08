<button wire:click="toggleWatchlist" class="glass px-10 py-4 border-white/[0.03] hover:bg-white/[0.05] transition-all duration-300 font-bold text-[11px] tracking-[0.2em] uppercase flex items-center gap-2 {{ $isInWatchlist ? 'text-red-500 border-red-500/20 bg-red-500/5' : '' }}">
    @if($isInWatchlist)
        <i class="bi bi-check-lg"></i> Watchlisted
    @else
        <i class="bi bi-plus-lg"></i> Watchlist
    @endif
</button>
