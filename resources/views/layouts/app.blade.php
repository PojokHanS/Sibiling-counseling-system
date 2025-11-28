<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIBILING UBBG') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root{
            --bg-cream:#FFFCF9;--bg-green-light:#EAF7F2;--bg-green-dark:#2BA172;--bg-green-darker:#23865F;
            --text-dark:#111827;--text-gray:#6B7280;--text-light:#9CA3AF;--border-light:#E5E7EB;
            --shadow-sm:0 2px 8px rgba(0,0,0,.05);--shadow-md:0 8px 24px rgba(0,0,0,.08);--shadow-lg:0 20px 40px rgba(0,0,0,.06)
        }
        .font-sans{font-family:'Inter',sans-serif}
        .sidebar-modern{background:linear-gradient(180deg,var(--bg-green-dark) 0%,var(--bg-green-darker) 100%);box-shadow:var(--shadow-lg)}
        .menu-hover{transition:.3s;color:rgba(255,255,255,.85)}
        .menu-hover:hover{background:rgba(255,255,255,.18);color:#fff;transform:translateX(4px)}
        .menu-active{background:rgba(255,255,255,.24);color:#fff;border-left:4px solid #fff}
        .logo-text{background:linear-gradient(135deg,#fff 0%,#EAF7F2 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;font-weight:800}
        .main-content{background:var(--bg-cream)}
        .header-modern{background:#fff;box-shadow:var(--shadow-sm);border-bottom:1px solid var(--border-light)}
        .user-dropdown{background:rgba(255,255,255,.98);backdrop-filter:blur(10px);border:1px solid rgba(0,0,0,.04)}
        .icon-primary{color:#fff}
        .sidebar-scroll::-webkit-scrollbar{width:4px}
        .sidebar-scroll::-webkit-scrollbar-track{background:rgba(255,255,255,.1);border-radius:10px}
        .sidebar-scroll::-webkit-scrollbar-thumb{background:rgba(255,255,255,.35);border-radius:10px}
        .sidebar-transition{transition:all .3s cubic-bezier(.4,0,.2,1)}
        .role-badge{background:rgba(255,255,255,.2);color:#fff;font-size:.7rem;padding:.25rem .5rem;border-radius:12px;margin-top:.25rem}
        .dashboard-card{background:#fff;border-radius:16px;box-shadow:var(--shadow-sm);border:1px solid var(--border-light)}
        .table-modern{width:100%;border-collapse:collapse}
        .table-modern th{background:var(--bg-green-light);color:var(--text-dark);font-weight:600;padding:1rem;text-align:left;border-bottom:2px solid var(--border-light)}
        .table-modern td{padding:1rem;border-bottom:1px solid var(--border-light);color:var(--text-gray)}
        .table-modern tr:hover{background:var(--bg-cream)}
        .empty-state{text-align:center;padding:3rem 2rem;color:var(--text-light)}
        .empty-state svg{width:64px;height:64px;margin-bottom:1rem;opacity:.5}
        
        /* === PREMIUM LOADING ANIMATION === */
        .premium-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--bg-green-dark) 0%, var(--bg-green-darker) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .premium-loader.active {
            opacity: 1;
            visibility: visible;
        }

        .loader-logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            animation: logoBounce 2s ease-in-out infinite;
        }

        .loader-logo span {
            font-size: 2rem;
            font-weight: 800;
            color: var(--bg-green-dark);
        }

        .loader-content {
            text-align: center;
            color: white;
        }

        .loader-text {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            opacity: 0;
            animation: fadeInUp 0.8s 0.5s ease forwards;
        }

        .loader-subtext {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            opacity: 0;
            animation: fadeInUp 0.8s 0.7s ease forwards;
        }

        .loader-progress {
            width: 200px;
            height: 4px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            overflow: hidden;
        }

        .loader-progress-bar {
            height: 100%;
            background: white;
            border-radius: 10px;
            animation: progressLoad 2s ease-in-out infinite;
        }

        @keyframes logoBounce {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.05); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes progressLoad {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 100%; }
        }

        .navigation-loading {
            position: relative;
            pointer-events: none;
        }
        
        .navigation-loading::after {
            content: '';
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% { transform: translateY(-50%) rotate(0deg); }
            100% { transform: translateY(-50%) rotate(360deg); }
        }
        
        @media (max-width:1023px){ .offcanvas { position:fixed; inset:0 auto 0 0; height:100vh; } }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">

<div id="premiumLoader" class="premium-loader">
    <div class="loader-logo">
        <span>S</span>
    </div>
    <div class="loader-content">
        <div class="loader-text">SIBILING UBBG</div>
        <div class="loader-subtext">Memuat konten...</div>
        <div class="loader-progress">
            <div class="loader-progress-bar"></div>
        </div>
    </div>
</div>

<div x-data="{ 
    open:true, 
    mobileOpen:false,
    showLoading(url) {
        // Show premium loader
        const loader = document.getElementById('premiumLoader');
        loader.classList.add('active');
        
        // Add loading state to clicked menu
        event.target.classList.add('navigation-loading');
        
        // Navigate after short delay for smooth UX
        setTimeout(() => {
            window.location.href = url;
        }, 800);
    }
}" class="flex min-h-screen">

    <div x-show="mobileOpen" @click="mobileOpen=false"
         class="fixed inset-0 bg-black/50 z-40 lg:hidden"
         x-transition.opacity></div>

    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col main-content lg:ml-0 transition-all duration-300">
        <div class="lg:hidden header-modern px-4 py-3 flex items-center justify-between">
            <button @click="mobileOpen=true" class="p-2 rounded-lg hover:bg-gray-100">
                <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="text-lg font-semibold text-gray-800">SIBILING UBBG</div>
            <div class="w-10"></div>
        </div>

        @if (isset($header))
            <header class="header-modern">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main class="flex-1 p-6 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>
</div>

<script>
    // Hide loader when page is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.getElementById('premiumLoader');
        if (loader) {
            loader.classList.remove('active');
        }
    });
</script>
</body>
</html>