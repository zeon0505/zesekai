<div class="w-full max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
    
    <!-- LEFT SIDE: Text & Quote -->
    <div class="hidden md:block space-y-6 animate-up" id="login-text">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="h-0.5 w-8 bg-red-600 rounded-full"></span>
                <span class="text-red-500 font-bold uppercase tracking-[0.2em] text-[10px]">Kembali Menjelajah</span>
            </div>
            <h1 class="text-4xl font-black uppercase tracking-tighter leading-none">
                Welcome <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">Back.</span>
            </h1>
        </div>
        
        <p class="text-gray-400 text-sm leading-relaxed max-w-xs font-medium border-l border-white/10 pl-4">
            "Ribuan dunia, satu tujuan. Lanjutkan petualangan."
        </p>

        <div class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest text-gray-500 pt-4">
            <div class="flex -space-x-2">
                <div class="w-6 h-6 rounded-full bg-gray-800 border border-black"></div>
                <div class="w-6 h-6 rounded-full bg-gray-700 border border-black"></div>
                <div class="w-6 h-6 rounded-full bg-gray-600 border border-black"></div>
            </div>
            <span>10k+ Nakama lainnya</span>
        </div>
    </div>

    <!-- RIGHT SIDE: Login Form (3D Tilt Card) -->
    <div class="relative group perspective-1000" id="login-card">
        <!-- Floating Elements behind card -->
        <div class="absolute -top-5 -right-5 w-24 h-24 bg-red-600/20 rounded-full blur-xl transition-all duration-500 group-hover:bg-red-600/40"></div>
        
        <div class="glass-panel p-8 rounded-2xl relative overflow-hidden transition-transform duration-100 ease-out transform-style-3d" id="tilt-element">
            
            <!-- Card content -->
            <div class="relative z-10 translate-z-20">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-black uppercase tracking-tighter">Login</h2>
                        <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest mt-0.5">Akses Akunmu</p>
                    </div>
                    <div class="w-8 h-8 bg-gradient-to-br from-[#8b0000] to-[#cc0000] rounded-lg flex items-center justify-center font-black text-white italic shadow-lg text-sm">A</div>
                </div>

                <form wire:submit.prevent="login" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-[9px] uppercase font-black tracking-widest text-gray-400 ml-1">Email</label>
                        <input wire:model="email" type="email" class="w-full bg-black/40 border border-white/10 focus:border-red-600/50 text-white rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-red-900/20 transition-all outline-none text-xs font-medium" placeholder="name@example.com">
                        @error('email') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-[9px] uppercase font-black tracking-widest text-gray-400 ml-1">Password</label>
                        <input wire:model="password" type="password" class="w-full bg-black/40 border border-white/10 focus:border-red-600/50 text-white rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-red-900/20 transition-all outline-none text-xs font-medium" placeholder="••••••••">
                        @error('password') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input wire:model="remember" type="checkbox" class="w-3 h-3 rounded bg-white/5 border-white/10 text-red-600 focus:ring-red-900/50 cursor-pointer">
                            <span class="text-[10px] text-gray-500 font-bold group-hover:text-gray-300 transition">Ingat Saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-[10px] text-red-500 hover:text-red-400 font-bold transition">Lupa Password?</a>
                    </div>

                    <button type="submit" class="w-full py-3 bg-gradient-to-r from-red-700 to-red-600 rounded-lg font-black uppercase tracking-widest text-[10px] text-white hover:scale-[1.02] hover:shadow-[0_5px_20px_-5px_rgba(220,38,38,0.5)] transition-all duration-300 transform active:scale-95">
                        Masuk Sekarang
                    </button>
                    
                    <div class="text-center pt-2">
                         <span class="text-gray-500 text-[10px] font-medium">Belum punya akun? </span>
                         <a href="{{ route('register') }}" class="text-white font-bold text-[10px] hover:text-red-500 transition underline decoration-red-600/50 decoration-2 underline-offset-4">Daftar disini</a>
                    </div>
                </form>
            </div>
            
            <!-- Decor Text -->
            <div class="absolute -bottom-6 -right-6 text-[100px] font-black text-white/[0.02] leading-none select-none pointer-events-none">LG</div>
        </div>
    </div>

    <script>
        // 3D Tilt Script
        const card = document.getElementById('login-card');
        const element = document.getElementById('tilt-element');

        document.addEventListener('mousemove', (e) => {
            if (window.innerWidth < 1024) return; 

            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = ((y - centerY) / centerY) * -5;
            const rotateY = ((x - centerX) / centerX) * 5;

            element.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });

        document.addEventListener('mouseleave', () => {
             element.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg)`;
        });
    </script>
</div>
