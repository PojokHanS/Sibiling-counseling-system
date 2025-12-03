<x-app-layout>
    {{-- Sembunyikan Header Default Laravel --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hidden">
            {{ __('Dashboard Dosen') }}
        </h2>
    </x-slot>

    {{-- INJECT STYLE DARI WELCOME PAGE --}}
    <style>
        /* === IMPORT FONT INTER === */
        @import url('https://fonts.bunny.net/css?family=inter:400,500,600,700,800');

        /* === VARIABLES (SAMA PERSIS DENGAN WELCOME.BLADE.PHP) === */
        :root {
            --primary-green: #2E8B57;
            --primary-light: #3CB371;
            --primary-dark: #23865F;
            --bg-cream: #FFFCF9;
            --bg-green-light: #EAF7F2;
            --text-dark: #1A1A1A;
            --text-gray: #4A4A4A;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.06);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-cream); /* Cream Background */
            color: var(--text-dark);
        }

        /* === BACKGROUND SHAPES ANIMATION === */
        .bg-shapes { position: fixed; inset: 0; z-index: 0; overflow: hidden; pointer-events: none; }
        .shape-top-right { position: absolute; top: -10%; right: -5%; width: 50%; height: 50%; background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-green) 100%); border-bottom-left-radius: 50% 40%; opacity: 0.08; animation: float 8s ease-in-out infinite; }
        .shape-bottom-left { position: absolute; bottom: -10%; left: -5%; width: 50%; height: 50%; background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%); border-top-right-radius: 50% 40%; opacity: 0.08; animation: float 10s ease-in-out infinite reverse; }
        @keyframes float { 0%, 100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-20px) rotate(1deg); } }

        /* === GLASS CARD STYLE === */
        .glass-card {
            background: rgba(255, 255, 255, 0.85); /* Lebih transparan */
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: var(--shadow-md);
            border-radius: 1.25rem;
            transition: all 0.3s ease;
        }
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-light);
        }

        /* === TEXT GRADIENT === */
        .text-gradient {
            background: linear-gradient(135deg, var(--text-dark) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* === SECTION TITLES === */
        .section-title {
            font-size: 1.25rem; 
            font-weight: 800; 
            color: var(--primary-dark); 
            margin-bottom: 1.5rem; 
            display: flex; 
            align-items: center; 
            gap: 0.75rem;
            position: relative;
        }
        .section-title::after {
            content: ''; flex: 1; height: 2px; 
            background: linear-gradient(to right, var(--primary-light), transparent);
            opacity: 0.3;
        }

        /* === BUTTONS === */
        .btn-action {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 0.5rem 1.25rem; border-radius: 50px;
            font-weight: 600; font-size: 0.875rem; transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
            color: white; box-shadow: 0 4px 15px rgba(46, 139, 87, 0.3);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(46, 139, 87, 0.4); }
        
        .btn-secondary {
            background: white; border: 1px solid #e5e7eb; color: var(--text-gray);
        }
        .btn-secondary:hover { border-color: var(--primary-green); color: var(--primary-green); }

    </style>

    {{-- BACKGROUND ANIMASI --}}
    <div class="bg-shapes">
        <div class="shape-top-right"></div>
        <div class="shape-bottom-left"></div>
    </div>

    {{-- CONTENT WRAPPER --}}
    <div class="py-12 relative z-10 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            {{-- HEADER WELCOME --}}
            <div class="text-center md:text-left animate-fade-in-up">
                <h1 class="text-4xl font-extrabold tracking-tight mb-2">
                    Halo, <span class="text-gradient">{{ Auth::user()->name }}</span> 👋
                </h1>
                <p class="text-lg text-gray-600">
                    Selamat datang di <span class="font-bold text-emerald-700">SIBILING Dashboard</span>. Berikut adalah ringkasan peran aktif Anda hari ini.
                </p>
                
                {{-- Role Badges --}}
                <div class="mt-4 flex flex-wrap gap-2 justify-center md:justify-start">
                    <span class="px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white border border-emerald-200 text-emerald-700 shadow-sm">
                        Dosen
                    </span>
                    @if($isKonselor) 
                        <span class="px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-50 border border-amber-200 text-amber-700 shadow-sm">
                            Konselor
                        </span> 
                    @endif
                    @if($isPA) 
                        <span class="px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-purple-50 border border-purple-200 text-purple-700 shadow-sm">
                            Pembimbing Akademik
                        </span> 
                    @endif
                </div>
            </div>

            {{-- 1. PANEL KONSELOR (Kuning Elegan) --}}
            @if($isKonselor)
                <div>
                    <h3 class="section-title text-amber-700">
                        <span class="bg-amber-100 p-2 rounded-lg text-amber-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </span>
                        Area Tugas Konseling
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Card: Pengajuan Masuk --}}
                        <div class="glass-card p-6 border-l-4 border-amber-400 relative overflow-hidden group">
                            <div class="absolute right-0 top-0 w-24 h-24 bg-amber-100 rounded-bl-full opacity-20 transition-transform group-hover:scale-150"></div>
                            <div class="relative z-10">
                                <p class="text-sm font-bold text-amber-600 uppercase tracking-wider mb-1">Pengajuan Baru</p>
                                <div class="flex items-end gap-2 mb-4">
                                    <h4 class="text-5xl font-extrabold text-gray-800">{{ $jumlahPengajuanBaru }}</h4>
                                    <span class="text-sm text-gray-500 mb-2">Menunggu verifikasi</span>
                                </div>
                                <a href="{{ route('dosen-konseling.pengajuan.index') }}" class="btn-action bg-amber-500 text-white hover:bg-amber-600 shadow-md">
                                    Proses Pengajuan <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>

                        {{-- Card: Jadwal Hari Ini --}}
                        <div class="glass-card p-6 border-l-4 border-blue-400 relative overflow-hidden group">
                            <div class="absolute right-0 top-0 w-24 h-24 bg-blue-100 rounded-bl-full opacity-20 transition-transform group-hover:scale-150"></div>
                            <div class="relative z-10">
                                <p class="text-sm font-bold text-blue-600 uppercase tracking-wider mb-1">Agenda Hari Ini</p>
                                <div class="flex items-end gap-2 mb-4">
                                    <h4 class="text-5xl font-extrabold text-gray-800">{{ $jadwalHariIni }}</h4>
                                    <span class="text-sm text-gray-500 mb-2">Sesi terjadwal</span>
                                </div>
                                <a href="{{ route('dosen-konseling.jadwal.index') }}" class="btn-action bg-blue-500 text-white hover:bg-blue-600 shadow-md">
                                    Lihat Jadwal <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- 2. PANEL PEMBIMBING AKADEMIK (Ungu Elegan) --}}
            @if($isPA)
                <div>
                    <h3 class="section-title text-purple-700">
                        <span class="bg-purple-100 p-2 rounded-lg text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </span>
                        Area Pembimbing Akademik
                    </h3>
                    <div class="glass-card p-8 flex flex-col md:flex-row items-center justify-between gap-6 border-l-4 border-purple-500">
                        <div class="flex items-center gap-6">
                            <div class="p-4 bg-purple-100 rounded-full text-purple-600">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-3xl font-extrabold text-gray-800">{{ $totalMahasiswaBimbingan }}</h4>
                                <p class="text-sm font-semibold text-gray-500">Mahasiswa di bawah bimbingan Anda</p>
                            </div>
                        </div>
                        <div class="flex gap-3 w-full md:w-auto">
                            <a href="{{ route('dosen-pembimbing.mahasiswa') }}" class="btn-action bg-purple-600 text-white hover:bg-purple-700 shadow-md w-full md:w-auto">
                                Data Mahasiswa
                            </a>
                            <a href="{{ route('dosen-pembimbing.mahasiswa') }}" class="btn-action btn-secondary w-full md:w-auto">
                                + Rekomendasi
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            {{-- 3. PANEL PRIBADI (Hijau SIBILING) --}}
            <div>
                <h3 class="section-title">
                    <span class="bg-emerald-100 p-2 rounded-lg text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </span>
                    Aktivitas Pribadi (Konseling Dosen)
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    {{-- Total --}}
                    <div class="glass-card p-6 text-center hover:bg-white">
                        <h4 class="text-3xl font-extrabold text-gray-800">{{ $totalCurhat }}</h4>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Total Curhat</p>
                    </div>

                    {{-- Proses --}}
                    <div class="glass-card p-6 text-center hover:bg-white">
                        <h4 class="text-3xl font-extrabold text-amber-500">{{ $dalamProses }}</h4>
                        <p class="text-xs font-bold text-amber-600/60 uppercase tracking-widest mt-1">Sedang Diproses</p>
                    </div>

                    {{-- Selesai --}}
                    <div class="glass-card p-6 text-center hover:bg-white">
                        <h4 class="text-3xl font-extrabold text-emerald-600">{{ $selesai }}</h4>
                        <p class="text-xs font-bold text-emerald-600/60 uppercase tracking-widest mt-1">Selesai</p>
                    </div>

                    {{-- Action Card --}}
                    <div class="glass-card p-6 flex flex-col justify-center items-center bg-gradient-to-br from-emerald-600 to-green-500 text-white shadow-lg transform hover:-translate-y-2 transition">
                        <p class="text-sm font-semibold mb-4 opacity-90">Butuh teman cerita?</p>
                        <a href="{{ route('dosen.curhat.create') }}" class="px-5 py-2 bg-white text-emerald-700 rounded-full font-bold text-sm hover:bg-emerald-50 transition w-full text-center shadow-sm">
                            Buat Curhat Baru
                        </a>
                        <a href="{{ route('dosen.curhat.index') }}" class="mt-3 text-xs text-emerald-100 hover:text-white underline decoration-emerald-200">
                            Lihat Riwayat
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>