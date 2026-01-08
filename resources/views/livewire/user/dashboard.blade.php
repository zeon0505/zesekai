<div class="pt-8 pb-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="mb-16">
            <h1 class="text-5xl font-black uppercase tracking-tighter mb-4">Dashboard</h1>
            <p class="text-gray-500 text-lg">Selamat datang kembali, <span class="text-red-600 font-bold">{{ auth()->user()->name }}</span>!</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8 hover:border-red-600/50 transition">
                <div class="text-5xl mb-4">📺</div>
                <h3 class="text-2xl font-black mb-2">Anime Favorit</h3>
                <p class="text-gray-500">Kelola daftar anime favoritmu</p>
            </div>

            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8 hover:border-red-600/50 transition">
                <div class="text-5xl mb-4">⭐</div>
                <h3 class="text-2xl font-black mb-2">Review Kamu</h3>
                <p class="text-gray-500">Lihat semua review yang kamu tulis</p>
            </div>

            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8 hover:border-red-600/50 transition">
                <div class="text-5xl mb-4">⚙️</div>
                <h3 class="text-2xl font-black mb-2">Pengaturan</h3>
                <p class="text-gray-500">Atur profil dan preferensimu</p>
            </div>
        </div>
    </div>
</div>
