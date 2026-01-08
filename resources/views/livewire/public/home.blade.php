<div>
    <livewire:layout.navigation />
    <!-- HERO SECTION -->
    <section id="home" class="relative min-h-screen flex items-center overflow-hidden">
        <!-- Floating Red Glows -->
        <div class="absolute -top-60 -left-60 w-[500px] h-[500px] bg-red-600/5 blur-[120px] rounded-full"></div>
        <div class="absolute -bottom-60 -right-60 w-[500px] h-[500px] bg-red-600/5 blur-[120px] rounded-full"></div>

        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-20 items-center z-10 pt-10">
            <div class="space-y-8">
                <div class="inline-flex items-center gap-3 px-4 py-1.5 glass bg-white/[0.01] border-white/5 text-[9px] font-black tracking-[0.3em] text-red-500 uppercase animate-up shadow-xl">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span>
                    Update Setiap Hari
                </div>
                
                <h1 class="text-3xl md:text-5xl font-black leading-[1.05] animate-up delay-1 tracking-tighter uppercase">
                    Jelajahi Dunia <br> <span class="gradient-text italic">Anime Terbaik</span>
                </h1>
                
                <p class="text-base text-gray-500 max-w-sm leading-relaxed animate-up delay-2 font-medium">
                    Koleksi kurasi anime terbaik dengan visual memukau dan kualitas tanpa kompromi.
                </p>

                <div class="flex flex-wrap gap-5 animate-up delay-3 pt-4">
                    <a href="#featured" class="btn-gradient px-10 py-4 rounded-2xl font-black text-[11px] tracking-[0.2em] flex items-center gap-3 uppercase">
                        <span>▶ Mulai Menonton</span>
                    </a>
                    <button class="glass px-10 py-4 border-white/[0.03] hover:bg-white/[0.05] transition-all duration-300 font-bold text-[11px] tracking-[0.2em] uppercase">
                        Watchlist
                    </button>
                </div>
            </div>

            <div class="relative hidden md:flex justify-end items-center">
                <div class="absolute inset-0 bg-red-600/[0.01] blur-[150px] rounded-full"></div>
                
                <div class="relative w-64 h-[380px] glass rotate-6 overflow-hidden shadow-[0_25px_50px_-12px_rgba(204,0,0,0.1)] border-white/10 group transition-all duration-700 hover:rotate-0 hover:scale-105">
                     <img src="https://m.media-amazon.com/images/M/MV5BNDFjYTIxMjctYTQ2ZC00OGQ4LWE3OGYtYTdiMzRkMTE1OTQxXkEyXkFqcGdeQXVyOTAyMDgxODQ@._V1_.jpg" 
                          class="w-full h-full object-cover">
                </div>
                <div class="absolute w-56 h-[340px] glass -rotate-3 -left-12 -z-10 overflow-hidden opacity-30 transition-all duration-700 hover:-rotate-6">
                     <img src="https://m.media-amazon.com/images/M/MV5BZjZjNzI5MDctY2YyZC00NmM0LThlZWItMDhmYmQyYTgzOTQ2XkEyXkFqcGdeQXVyNjU1OTg0OTM@._V1_FMjpg_UX1000_.jpg" 
                          class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>
</div>
