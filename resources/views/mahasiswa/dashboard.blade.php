<x-app-layout>
    {{-- KITA SEMBUNYIKAN HEADER BAWAAN BIAR BISA KITA CUSTOM SENDIRI --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hidden">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- INJECT STYLE DARI WELCOME PAGE --}}
    <style>
        /* === VARIABLES (SAMA PERSIS DENGAN WELCOME) === */
        :root {
            --primary-green: #2E8B57;
            --primary-light: #3CB371;
            --primary-dark: #23865F;
            --bg-cream: #FFFCF9;
        }

        /* Background Shapes Animation */
        .bg-shapes { position: fixed; inset: 0; z-index: 0; overflow: hidden; pointer-events: none; }
        .shape-top-right { position: absolute; top: -10%; right: -5%; width: 50%; height: 50%; background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-green) 100%); border-bottom-left-radius: 50% 40%; opacity: 0.08; animation: float 8s ease-in-out infinite; }
        .shape-bottom-left { position: absolute; bottom: -10%; left: -5%; width: 50%; height: 50%; background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%); border-top-right-radius: 50% 40%; opacity: 0.08; animation: float 10s ease-in-out infinite reverse; }
        @keyframes float { 0%, 100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-20px) rotate(1deg); } }

        /* Custom Card Style */
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
            border-radius: 1.5rem; /* Rounded Besar */
        }
        
        /* Gradient Text */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-green) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Tombol Sultan */
        .btn-emerald {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
            transition: all 0.3s ease;
        }
        .btn-emerald:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(46, 139, 87, 0.2);
        }
    </style>

    {{-- BACKGROUND ANIMASI (POSISI FIXED DI BELAKANG) --}}
    <div class="bg-shapes">
        <div class="shape-top-right"></div>
        <div class="shape-bottom-left"></div>
    </div>

    {{-- KONTEN UTAMA (Relative biar di atas background) --}}
    <div class="py-12 relative z-10 min-h-screen" style="background-color: transparent;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- WELCOME HEADER --}}
            <div class="mb-10 text-center sm:text-left animate-fade-in-up">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 tracking-tight">
                    Halo, <span class="text-gradient">{{ Auth::user()->name }}</span> 👋
                </h1>
                <p class="mt-2 text-gray-600 text-lg">
                    Selamat datang di ruang bimbingan konseling Anda. Apa kabar hari ini?
                </p>
            </div>

            {{-- MAIN DASHBOARD CARD --}}
            <div class="glass-card overflow-hidden">
                <div class="p-8 sm:p-10">
                    
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Status Pengajuan Terakhir
                    </h3>

                    {{-- LOGIC STATUS PENGIRIMAN --}}
                    @if ($konselingTerakhir)
                        @php
                            $status = $konselingTerakhir->status_konseling;
                            // Kita mapping warna & icon biar lebih spesifik
                            $statusConfig = match($status) {
                                'Menunggu Verifikasi' => [
                                    'bg' => 'bg-amber-50', 'border' => 'border-amber-200', 'text' => 'text-amber-800',
                                    'icon' => '<svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                                    'title' => 'Menunggu Verifikasi',
                                    'desc' => 'Pengajuan Anda sedang ditinjau oleh tim konseling. Mohon bersabar ya.'
                                ],
                                'Disetujui' => [
                                    'bg' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'text' => 'text-emerald-800',
                                    'icon' => '<svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                                    'title' => 'Disetujui',
                                    'desc' => 'Kabar baik! Pengajuan disetujui. Tunggu informasi jadwal selanjutnya.'
                                ],
                                'Terjadwal' => [ // Atau 'Dijadwalkan' (sesuaikan enum database)
                                    'bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'text' => 'text-blue-800',
                                    'icon' => '<svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>',
                                    'title' => 'Sudah Dijadwalkan',
                                    'desc' => 'Jadwal sesi konseling telah keluar. Cek detailnya sekarang!'
                                ],
                                'Dijadwalkan' => [ 
                                    'bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'text' => 'text-blue-800',
                                    'icon' => '<svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>',
                                    'title' => 'Sudah Dijadwalkan',
                                    'desc' => 'Jadwal sesi konseling telah keluar. Cek detailnya sekarang!'
                                ],
                                'Selesai' => [
                                    'bg' => 'bg-purple-50', 'border' => 'border-purple-200', 'text' => 'text-purple-800',
                                    'icon' => '<svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>',
                                    'title' => 'Selesai',
                                    'desc' => 'Sesi konseling telah selesai. Semoga membantu permasalahan Anda.'
                                ],
                                'Ditolak' => [
                                    'bg' => 'bg-red-50', 'border' => 'border-red-200', 'text' => 'text-red-800',
                                    'icon' => '<svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                                    'title' => 'Ditolak',
                                    'desc' => 'Pengajuan tidak dapat dilanjutkan. Silakan cek detail untuk alasannya.'
                                ],
                                'Perlu Revisi' => [
                                    'bg' => 'bg-yellow-50', 'border' => 'border-yellow-200', 'text' => 'text-yellow-800',
                                    'icon' => '<svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>',
                                    'title' => 'Perlu Revisi',
                                    'desc' => 'Ada data yang perlu Anda perbaiki. Segera lakukan revisi.'
                                ],
                                default => [
                                    'bg' => 'bg-gray-50', 'border' => 'border-gray-200', 'text' => 'text-gray-800',
                                    'icon' => '<svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                                    'title' => 'Status Tidak Dikenal',
                                    'desc' => 'Hubungi admin jika status tidak berubah.'
                                ],
                            };
                        @endphp
                        
                        {{-- STATUS CARD --}}
                        <div class="rounded-xl border {{ $statusConfig['border'] }} {{ $statusConfig['bg'] }} p-6 flex flex-col sm:flex-row items-start sm:items-center gap-5 transition-all duration-300 hover:shadow-md">
                            <div class="p-3 bg-white rounded-full shadow-sm">
                                {!! $statusConfig['icon'] !!}
                            </div>
                            <div class="flex-1">
                                <h4 class="text-lg font-bold {{ $statusConfig['text'] }}">{{ $statusConfig['title'] }}</h4>
                                <p class="text-gray-600 mt-1">{{ $statusConfig['desc'] }}</p>
                                <p class="text-xs text-gray-400 mt-2">
                                    Diajukan pada: {{ \Carbon\Carbon::parse($konselingTerakhir->tgl_pengajuan)->translatedFormat('d F Y') }}
                                </p>
                            </div>
                            <div class="mt-4 sm:mt-0">
                                <a href="{{ route('mahasiswa.riwayat.show', $konselingTerakhir->id_konseling) }}" 
                                   class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 hover:text-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>

                        {{-- TOMBOL RIWAYAT --}}
                        <div class="mt-8 text-center">
                            <a href="{{ route('mahasiswa.riwayat.index') }}" class="text-sm text-gray-500 hover:text-emerald-600 font-medium underline">
                                Lihat Semua Riwayat Konseling
                            </a>
                        </div>

                    @else
                        {{-- EMPTY STATE (BELUM ADA PENGAJUAN) --}}
                        <div class="text-center py-10">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full mb-6">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Pengajuan</h3>
                            <p class="text-gray-500 max-w-md mx-auto mb-8">
                                Jangan ragu untuk bercerita. Kami di sini untuk mendengar dan membantu menyelesaikan masalah Anda.
                            </p>
                            
                            <a href="{{ route('mahasiswa.pengajuan.create') }}" class="btn-emerald inline-flex items-center px-8 py-3 border border-transparent rounded-full font-bold text-white text-base shadow-lg hover:shadow-xl transform transition hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Mulai Konseling Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- FOOTER / INFO TAMBAHAN --}}
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="glass-card p-6 text-center hover:scale-105 transition duration-300">
                    <div class="text-emerald-500 mb-3 flex justify-center"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg></div>
                    <h4 class="font-bold text-gray-800">Dijamin Rahasia</h4>
                    <p class="text-sm text-gray-500 mt-1">Privasi Anda adalah prioritas utama kami.</p>
                </div>
                <div class="glass-card p-6 text-center hover:scale-105 transition duration-300">
                    <div class="text-emerald-500 mb-3 flex justify-center"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                    <h4 class="font-bold text-gray-800">Konselor Profesional</h4>
                    <p class="text-sm text-gray-500 mt-1">Dosen dan psikolog yang siap membantu.</p>
                </div>
                <div class="glass-card p-6 text-center hover:scale-105 transition duration-300">
                    <div class="text-emerald-500 mb-3 flex justify-center"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                    <h4 class="font-bold text-gray-800">Jadwal Fleksibel</h4>
                    <p class="text-sm text-gray-500 mt-1">Pilih waktu yang paling nyaman untuk Anda.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>