<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIBILING UBBG') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Scripts & Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* --- CRITICAL CSS FOR LOADER (Agar loading instan tanpa menunggu Tailwind) --- */
        :root {
            --ubbg-green: #047857;
            --ubbg-dark: #064e3b;
            --cream-bg: #F8FAFC;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--cream-bg);
            margin: 0; padding: 0;
            overflow: hidden; /* Prevent scroll saat loading */
        }

        /* PREMIUM LOADER STYLE */
        #app-loader {
            position: fixed; inset: 0; z-index: 99999;
            background: #ffffff;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            transition: transform 0.8s cubic-bezier(0.77, 0, 0.175, 1); /* Ease In Out Quart */
        }

        .loader-logo-wrapper {
            position: relative;
            width: 100px; height: 100px;
            background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 10px 25px -5px rgba(4, 120, 87, 0.15);
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }

        .loader-logo {
            width: 60px; height: auto;
            animation: pulse-logo 2s infinite;
        }

        .loader-text {
            font-weight: 800; font-size: 1.5rem; letter-spacing: -0.5px;
            color: var(--ubbg-green);
            opacity: 0; transform: translateY(10px);
            animation: fadeUp 0.8s ease-out 0.3s forwards;
        }

        .loader-subtext {
            font-size: 0.875rem; color: #64748b; font-weight: 500;
            margin-top: 5px; opacity: 0;
            animation: fadeUp 0.8s ease-out 0.5s forwards;
        }

        /* Animation States */
        body.loaded #app-loader {
            transform: translateY(-100%); /* Curtain Effect */
        }

        body.loaded {
            overflow: auto; /* Enable scroll after load */
        }

        @keyframes pulse-logo {
            0% { transform: scale(1); filter: drop-shadow(0 0 0 rgba(4,120,87,0)); }
            50% { transform: scale(1.05); filter: drop-shadow(0 0 10px rgba(4,120,87,0.2)); }
            100% { transform: scale(1); filter: drop-shadow(0 0 0 rgba(4,120,87,0)); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="antialiased h-screen flex overflow-hidden bg-slate-50 selection:bg-emerald-500 selection:text-white">

    {{-- --- PREMIUM LOADER --- --}}
    <div id="app-loader">
        <div class="loader-logo-wrapper">
            {{-- Pastikan logo ada di public/images/logo-ubbg.png --}}
            <img src="{{ asset('images/logo-ubbg.png') }}" alt="UBBG Logo" class="loader-logo">
        </div>
        <div class="loader-text">SIBILING v2</div>
        <div class="loader-subtext">Sistem Bimbingan Konseling UBBG</div>
        
        {{-- Progress Bar Kecil --}}
        <div class="mt-8 w-32 h-1 bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-emerald-500 rounded-full animate-[loading_1.5s_ease-in-out_infinite]" style="width: 50%"></div>
        </div>
    </div>

    {{-- --- MAIN APP STRUCTURE --- --}}
    <div x-data="{ 
            sidebarOpen: true, 
            mobileOpen: false,
            init() {
                // Check screen size on load
                if (window.innerWidth < 1024) { this.sidebarOpen = false; }
            }
         }" 
         class="flex w-full h-full relative transition-all duration-300">

        {{-- Mobile Overlay --}}
        <div x-show="mobileOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileOpen = false"
             class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-40 lg:hidden">
        </div>

        {{-- SIDEBAR INCLUDE --}}
        @include('layouts.sidebar')

        {{-- MAIN CONTENT WRAPPER --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#F8FAFC] transition-all duration-300 relative">
            
            {{-- HEADER MOBILE --}}
            <div class="lg:hidden bg-white/80 backdrop-blur-md border-b border-gray-200 px-4 py-3 flex items-center justify-between sticky top-0 z-30">
                <button @click="mobileOpen = true" class="p-2 -ml-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <img src="{{ asset('images/logo-ubbg.png') }}" class="h-8 w-auto" alt="Logo">
                <div class="w-8"></div> {{-- Spacer --}}
            </div>

            {{-- HEADER DESKTOP (Optional Slot) --}}
            @if (isset($header))
                <header class="bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-20 shadow-sm">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            {{-- CONTENT SCROLLABLE AREA --}}
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 scroll-smooth">
                {{-- Fade In content after loader --}}
                <div class="animate-[fadeIn_0.5s_ease-out_0.8s_both]">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <style>
        @keyframes loading {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <script>
        // Logic Loader - Menunggu semua asset selesai di-load
        window.addEventListener('load', () => {
            // Delay sedikit biar user sempat lihat brandingnya (Experience Premium)
            setTimeout(() => {
                document.body.classList.add('loaded');
            }, 800);
        });
    </script>
</body>
</html>