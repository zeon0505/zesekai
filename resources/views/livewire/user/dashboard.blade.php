<div>
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Watchlist Count -->
        <div class="bg-[#0a0a0a] rounded-2xl border border-white/5 p-6 relative overflow-hidden group hover:border-red-600/30 transition-all duration-300">
            <div class="absolute top-0 right-0 w-24 h-24 bg-red-600/5 blur-[40px] pointer-events-none"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <i class="bi bi-bookmark-heart-fill text-3xl text-red-500"></i>
                    <span class="text-4xl font-black text-white">{{ \App\Models\Watchlist::where('user_id', auth()->id())->count() }}</span>
                </div>
                <h3 class="text-sm font-black uppercase tracking-widest text-gray-500 mb-1">My Watchlist</h3>
                <a href="{{ route('watchlist') }}" class="text-xs text-red-500 hover:text-red-400 font-bold uppercase tracking-wider">View All →</a>
            </div>
        </div>

        <!-- Recently Watched -->
        <div class="bg-[#0a0a0a] rounded-2xl border border-white/5 p-6 relative overflow-hidden group hover:border-red-600/30 transition-all duration-300">
            <div class="absolute top-0 right-0 w-24 h-24 bg-red-600/5 blur-[40px] pointer-events-none"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <i class="bi bi-clock-history text-3xl text-gray-500"></i>
                    <span class="text-4xl font-black text-white">0</span>
                </div>
                <h3 class="text-sm font-black uppercase tracking-widest text-gray-500 mb-1">Watch History</h3>
                <p class="text-xs text-gray-600 font-bold uppercase tracking-wider">Coming Soon</p>
            </div>
        </div>

        <!-- Profile Completion -->
        <div class="bg-[#0a0a0a] rounded-2xl border border-white/5 p-6 relative overflow-hidden group hover:border-red-600/30 transition-all duration-300">
            <div class="absolute top-0 right-0 w-24 h-24 bg-red-600/5 blur-[40px] pointer-events-none"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <i class="bi bi-person-circle text-3xl text-gray-500"></i>
                    <span class="text-4xl font-black text-white">{{ auth()->user()->profile_photo_path ? '100' : '80' }}%</span>
                </div>
                <h3 class="text-sm font-black uppercase tracking-widest text-gray-500 mb-1">Profile</h3>
                <a href="{{ route('profile') }}" class="text-xs text-red-500 hover:text-red-400 font-bold uppercase tracking-wider">Edit Profile →</a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-10">
        <h2 class="text-xl font-black uppercase tracking-tighter text-white mb-6">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('trending') }}" class="bg-[#0a0a0a] rounded-xl border border-white/5 p-6 hover:border-red-600/30 hover:bg-white/[0.02] transition-all group flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-600/10 flex items-center justify-center group-hover:bg-red-600/20 transition">
                    <i class="bi bi-fire text-xl text-red-500"></i>
                </div>
                <div>
                    <h3 class="font-black uppercase text-sm text-white group-hover:text-red-500 transition">Trending</h3>
                    <p class="text-[10px] text-gray-600 uppercase tracking-widest">Popular Now</p>
                </div>
            </a>

            <a href="{{ route('catalog') }}" class="bg-[#0a0a0a] rounded-xl border border-white/5 p-6 hover:border-red-600/30 hover:bg-white/[0.02] transition-all group flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center group-hover:bg-white/10 transition">
                    <i class="bi bi-collection-fill text-xl text-gray-400"></i>
                </div>
                <div>
                    <h3 class="font-black uppercase text-sm text-white group-hover:text-red-500 transition">Catalog</h3>
                    <p class="text-[10px] text-gray-600 uppercase tracking-widest">Browse All</p>
                </div>
            </a>

            <a href="{{ route('watchlist') }}" class="bg-[#0a0a0a] rounded-xl border border-white/5 p-6 hover:border-red-600/30 hover:bg-white/[0.02] transition-all group flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center group-hover:bg-white/10 transition">
                    <i class="bi bi-bookmark-heart-fill text-xl text-gray-400"></i>
                </div>
                <div>
                    <h3 class="font-black uppercase text-sm text-white group-hover:text-red-500 transition">Watchlist</h3>
                    <p class="text-[10px] text-gray-600 uppercase tracking-widest">My List</p>
                </div>
            </a>

            <a href="{{ route('profile') }}" class="bg-[#0a0a0a] rounded-xl border border-white/5 p-6 hover:border-red-600/30 hover:bg-white/[0.02] transition-all group flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center group-hover:bg-white/10 transition">
                    <i class="bi bi-gear-fill text-xl text-gray-400"></i>
                </div>
                <div>
                    <h3 class="font-black uppercase text-sm text-white group-hover:text-red-500 transition">Settings</h3>
                    <p class="text-[10px] text-gray-600 uppercase tracking-widest">Profile</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Continue Watching (Placeholder) -->
    <div>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-black uppercase tracking-tighter text-white">Continue Watching</h2>
            <span class="text-[10px] text-gray-600 uppercase tracking-widest font-bold">Coming Soon</span>
        </div>
        <div class="bg-[#0a0a0a] rounded-2xl border border-white/5 p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/5 border border-white/10 mb-6">
                <i class="bi bi-play-circle text-4xl text-gray-600"></i>
            </div>
            <h3 class="text-xl font-black uppercase tracking-tight text-gray-400 mb-2">No Recent Activity</h3>
            <p class="text-[10px] uppercase tracking-widest text-gray-600 mb-8">Start watching anime to see your history here</p>
            <a href="{{ route('catalog') }}" class="btn-gradient px-8 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest text-white inline-block">Browse Anime</a>
        </div>
    </div>
</div>
