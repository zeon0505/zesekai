<div class="w-full max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
    
    <!-- LEFT SIDE: Text & Quote -->
    <div class="hidden md:block space-y-6 animate-up delay-100" id="register-text">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="h-0.5 w-8 bg-red-600 rounded-full"></span>
                <span class="text-red-500 font-bold uppercase tracking-[0.2em] text-[10px]">Mulai Petualangan</span>
            </div>
            <h1 class="text-4xl font-black uppercase tracking-tighter leading-none">
                Join The <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-red-800">Revolution.</span>
            </h1>
        </div>
        
        <p class="text-gray-400 text-sm leading-relaxed max-w-xs font-medium border-l border-white/10 pl-4">
            "Jangan hanya menonton. Jadilah bagian dari komunitas."
        </p>

        <div class="grid grid-cols-2 gap-4 pt-4">
            <div class="glass-panel p-3 rounded-lg border border-white/5">
                <div class="text-xl font-black text-white mb-0.5">100%</div>
                <div class="text-[9px] uppercase font-bold text-gray-500 tracking-widest">Free Access</div>
            </div>
            <div class="glass-panel p-3 rounded-lg border border-white/5">
                <div class="text-xl font-black text-white mb-0.5">HD</div>
                <div class="text-[9px] uppercase font-bold text-gray-500 tracking-widest">Quality Stream</div>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDE: Register Form (3D Tilt Card) -->
    <div class="relative group perspective-1000" id="register-card">
        <!-- Floating Elements behind card -->
        <div class="absolute -bottom-5 -left-5 w-24 h-24 bg-red-600/20 rounded-full blur-xl transition-all duration-500 group-hover:bg-red-600/40"></div>
        
        <div class="glass-panel p-8 rounded-2xl relative overflow-hidden transition-transform duration-100 ease-out transform-style-3d" id="tilt-element-reg">
            
            <!-- Card content -->
            <div class="relative z-10 translate-z-20">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-black uppercase tracking-tighter">Sign Up</h2>
                        <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest mt-0.5">Buat Akun Baru</p>
                    </div>
                    <div class="w-8 h-8 bg-gradient-to-br from-[#8b0000] to-[#cc0000] rounded-lg flex items-center justify-center font-black text-white italic shadow-lg text-sm">A</div>
                </div>

                <form wire:submit.prevent="register" class="space-y-3">
                    <!-- Name -->
                    <div class="space-y-1">
                        <label class="text-[9px] uppercase font-black tracking-widest text-gray-400 ml-1">Username</label>
                        <input wire:model="name" type="text" class="w-full bg-black/40 border border-white/10 focus:border-red-600/50 text-white rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-red-900/20 transition-all outline-none text-xs font-medium" placeholder="Your Name">
                        @error('name') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-1">
                        <label class="text-[9px] uppercase font-black tracking-widest text-gray-400 ml-1">Email</label>
                        <input wire:model="email" type="email" class="w-full bg-black/40 border border-white/10 focus:border-red-600/50 text-white rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-red-900/20 transition-all outline-none text-xs font-medium" placeholder="name@example.com">
                        @error('email') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-1">
                        <label class="text-[9px] uppercase font-black tracking-widest text-gray-400 ml-1">Password</label>
                        <input wire:model="password" type="password" class="w-full bg-black/40 border border-white/10 focus:border-red-600/50 text-white rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-red-900/20 transition-all outline-none text-xs font-medium" placeholder="Min 8 chars">
                        @error('password') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-1">
                        <label class="text-[9px] uppercase font-black tracking-widest text-gray-400 ml-1">Confirm Password</label>
                        <input wire:model="password_confirmation" type="password" class="w-full bg-black/40 border border-white/10 focus:border-red-600/50 text-white rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-red-900/20 transition-all outline-none text-xs font-medium" placeholder="Repeat password">
                    </div>

                    <button type="submit" class="w-full py-3 mt-1 bg-gradient-to-r from-red-700 to-red-600 rounded-lg font-black uppercase tracking-widest text-[10px] text-white hover:scale-[1.02] hover:shadow-[0_5px_20px_-5px_rgba(220,38,38,0.5)] transition-all duration-300 transform active:scale-95">
                        Daftar Sekarang
                    </button>
                    
                    <div class="text-center pt-1">
                         <span class="text-gray-500 text-[10px] font-medium">Sudah punya akun? </span>
                         <a href="{{ route('login') }}" class="text-white font-bold text-[10px] hover:text-red-500 transition underline decoration-red-600/50 decoration-2 underline-offset-4">Masuk disini</a>
                    </div>
                </form>
            </div>
            
            <!-- Decor Text -->
            <div class="absolute -top-6 -left-6 text-[100px] font-black text-white/[0.02] leading-none select-none pointer-events-none">RG</div>
        </div>
    </div>

    <script>
        // 3D Tilt Script for Register
        const cardReg = document.getElementById('register-card');
        const elementReg = document.getElementById('tilt-element-reg');

        document.addEventListener('mousemove', (e) => {
            if (window.innerWidth < 1024) return; 

            const rect = cardReg.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = ((y - centerY) / centerY) * -5;
            const rotateY = ((x - centerX) / centerX) * 5;

            elementReg.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });

        document.addEventListener('mouseleave', () => {
             elementReg.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg)`;
        });
    </script>
</div>
