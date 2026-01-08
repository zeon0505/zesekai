<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Zesekai') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        @livewireStyles
        <style>
            * { font-family: 'Outfit', sans-serif; }
            body { background-color: #000; color: #fff; overflow-x: hidden; }
            .glass {
                background: rgba(255, 255, 255, 0.02);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.05);
            }
            .btn-gradient {
                background: linear-gradient(135deg, #8b0000, #cc0000);
                transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            }
        </style>
    </head>
    <body class="antialiased font-sans bg-black text-white">
        <div class="min-h-screen flex flex-col">
            @unless(request()->routeIs('anime.detail'))
                <livewire:layout.navigation />
            @endunless

            <!-- Page Heading -->
            @if (isset($header))
                <header class="pt-24 pb-8">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="line-accent w-10 h-1 bg-red-600 mb-4 rounded-full"></div>
                        <h2 class="text-3xl font-black uppercase tracking-tighter italic">{{ $header }}</h2>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <footer class="py-12 border-t border-white/5 text-center text-[10px] text-gray-600 uppercase tracking-[0.4em]">
                &copy; 2026 ZESEKAI PROJECT
            </footer>
        </div>
        @livewireScripts
    </body>
</html>
