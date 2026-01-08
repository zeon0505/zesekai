<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="relative group">
            <div class="absolute inset-0 bg-red-600/20 blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative bg-[#0a0a0a] p-6 rounded-2xl border border-white/5 flex items-center gap-5 hover:border-red-600/30 transition-colors">
                <div class="w-14 h-14 bg-gradient-to-br from-[#8b0000] to-[#cc0000] rounded-xl flex items-center justify-center text-white text-2xl shadow-lg shadow-red-900/20">
                    <i class="bi bi-film"></i>
                </div>
                <div>
                    <div class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Total Anime</div>
                    <div class="text-3xl font-black text-white mt-1">{{ $totalAnime }}</div>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="relative group">
            <div class="absolute inset-0 bg-blue-600/10 blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative bg-[#0a0a0a] p-6 rounded-2xl border border-white/5 flex items-center gap-5 hover:border-gray-600 transition-colors">
                <div class="w-14 h-14 bg-white/5 rounded-xl flex items-center justify-center text-gray-300 text-2xl border border-white/5">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Total Users</div>
                    <div class="text-3xl font-black text-white mt-1">{{ $totalUsers }}</div>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="relative group">
            <div class="absolute inset-0 bg-yellow-600/10 blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative bg-[#0a0a0a] p-6 rounded-2xl border border-white/5 flex items-center gap-5 hover:border-yellow-600/30 transition-colors">
                <div class="w-14 h-14 bg-yellow-500/10 rounded-xl flex items-center justify-center text-yellow-500 text-2xl border border-yellow-500/20">
                    <i class="bi bi-star-fill"></i>
                </div>
                <div>
                    <div class="text-gray-500 text-[10px] font-black uppercase tracking-widest">Premium Users</div>
                    <div class="text-3xl font-black text-white mt-1">{{ $premiumUsers }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Placeholder -->
    <div class="bg-[#0a0a0a] rounded-2xl border border-white/5 p-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-red-600/5 blur-[80px] rounded-full pointer-events-none"></div>
        <h4 class="text-lg font-black text-white uppercase tracking-tighter mb-6 relative z-10">Analytics Overview</h4>
        
        <div class="h-64 flex items-center justify-center bg-black/40 rounded-xl border border-white/5 border-dashed relative z-10">
             <div class="text-center">
                 <i class="bi bi-bar-chart-fill text-4xl text-gray-700 mb-3 block"></i>
                 <span class="text-gray-600 text-xs font-bold uppercase tracking-widest">Chart Data Unavailable</span>
             </div>
        </div>
    </div>
</div>
