<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Zesekai') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * { font-family: 'Outfit', sans-serif; }
        body { background-color: #000; color: #fff; overflow-x: hidden; }

        /* Animated Background */
        .bg-animate {
            background: linear-gradient(-45deg, #000000, #1a0505, #000000, #0a0000);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .floating-shape {
            position: absolute;
            filter: blur(80px);
            z-index: 0;
            animation: float 20s infinite;
            opacity: 0.4;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -50px) rotate(10deg); }
            66% { transform: translate(-20px, 20px) rotate(-5deg); }
            100% { transform: translate(0, 0) rotate(0deg); }
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* 3D Tilt Effect Utilities */
        .tilt-card {
            transform-style: preserve-3d;
            transform: perspective(1000px);
        }
        
        .translate-z-10 { transform: translateZ(20px); }
        .translate-z-20 { transform: translateZ(40px); }
    </style>
</head>
<body class="antialiased bg-animate min-h-screen flex items-center justify-center relative selection:bg-red-600 selection:text-white">

    <!-- Floating Background Elements -->
    <div class="floating-shape w-96 h-96 bg-red-600 rounded-full -top-20 -left-20"></div>
    <div class="floating-shape w-80 h-80 bg-red-900 rounded-full top-1/2 right-0 delay-1000"></div>
    <div class="floating-shape w-64 h-64 bg-red-700 rounded-full bottom-0 left-1/4 delay-2000"></div>

    <!-- Back Button -->
    <a href="{{ route('home') }}" class="fixed top-8 left-8 z-50 flex items-center gap-3 px-5 py-2.5 glass-panel rounded-full text-white/70 hover:text-white hover:bg-white/10 transition-all duration-300 group">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 group-hover:-translate-x-1 transition-transform">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
        <span class="text-[10px] font-black uppercase tracking-widest hidden md:inline-block">Kembali</span>
    </a>

    <!-- Main Content Container -->
    <div class="w-full min-h-screen flex items-center justify-center z-10 p-4 md:p-8">
        {{ $slot }}
    </div>

    <script>
        document.addEventListener('mousemove', (e) => {
            const shapes = document.querySelectorAll('.floating-shape');
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;

            shapes.forEach((shape, index) => {
                const speed = (index + 1) * 20;
                const xOffset = (window.innerWidth / 2 - e.clientX) / speed;
                const yOffset = (window.innerHeight / 2 - e.clientY) / speed;
                
                shape.style.transform = `translate(${xOffset}px, ${yOffset}px)`;
            });
        });
    </script>
</body>
</html>
