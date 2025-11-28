<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Dosen') }}
        </h2>
    </x-slot>

    {{-- Container Utama dengan Padding Vertikal yang Pas --}}
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- SECTION 1: WELCOME BANNER (CLEAN STYLE: PUTIH + TEKS HITAM) --}}
            {{-- Kita ganti jadi background putih biar teks nama pasti kelihatan --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500 relative">
                <div class="p-6 sm:p-8"> {{-- Padding diperbesar biar lega --}}
                    <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                                Selamat Datang, {{ Auth::user()->name }}! 
                                <span class="text-3xl">👋</span>
                            </h3>
                            <p class="mt-2 text-gray-600 max-w-2xl text-sm md:text-base">
                                "Kesehatan mental Anda adalah prioritas kami. Jangan ragu untuk bercerita jika ada masalah."
                            </p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <a href="{{ route('dosen.curhat.create') }}" class="inline-flex items-center px-5 py-2.5 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition shadow-md">
                                ✍️ Ajukan Konseling Baru
                            </a>
                        </div>
                    </div>
                    
                    {{-- Dekorasi Background Halus --}}
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-green-50 rounded-full opacity-50 blur-2xl"></div>
                </div>
            </div>

            {{-- SECTION 2: STATS GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Total --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-50 text-indigo-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Total Pengajuan</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalCurhat }}</p>
                        </div>
                    </div>
                </div>

                {{-- Proses --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-50 text-yellow-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Sedang Diproses</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $dalamProses }}</p>
                        </div>
                    </div>
                </div>

                {{-- Selesai --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-50 text-green-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Selesai Ditangani</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $selesai }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 3: JADWAL & RIWAYAT --}}
            {{-- Layout 2 Kolom: Kiri (Riwayat Link) & Kanan (Jadwal) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- JADWAL TERDEKAT (Prioritas Tampil Besar) --}}
                @if($jadwalTerdekat)
                <div class="lg:col-span-3 bg-white overflow-hidden shadow-sm sm:rounded-lg border border-blue-100">
                    <div class="p-6 md:p-8 bg-blue-50/50"> {{-- Padding besar biar tidak mepet --}}
                        <div class="flex flex-col md:flex-row md:items-start gap-6">
                            {{-- Ikon Kalender Besar --}}
                            <div class="flex-shrink-0">
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-blue-100 text-center min-w-[80px]">
                                    <span class="block text-xs font-bold text-gray-500 uppercase mb-1">
                                        {{ \Carbon\Carbon::parse($jadwalTerdekat->jadwal_konseling)->translatedFormat('M') }}
                                    </span>
                                    <span class="block text-3xl font-extrabold text-blue-600">
                                        {{ \Carbon\Carbon::parse($jadwalTerdekat->jadwal_konseling)->format('d') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Detail Jadwal --}}
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-bold text-gray-900">
                                        📅 Pengingat Jadwal Konseling
                                    </h3>
                                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">
                                        SEGERA
                                    </span>
                                </div>
                                
                                <p class="text-gray-600 mb-4">
                                    Anda memiliki sesi konseling yang dijadwalkan dengan Wakil Rektor.
                                </p>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-white p-3 rounded-lg border border-blue-100 flex items-center">
                                        <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase font-bold">Waktu</p>
                                            <p class="text-sm font-semibold text-gray-800">
                                                {{ \Carbon\Carbon::parse($jadwalTerdekat->jadwal_konseling)->translatedFormat('l, H:i') }} WIB
                                            </p>
                                        </div>
                                    </div>
                                    <div class="bg-white p-3 rounded-lg border border-blue-100 flex items-center">
                                        <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase font-bold">Lokasi</p>
                                            <p class="text-sm font-semibold text-gray-800 truncate">
                                                {{ $jadwalTerdekat->lokasi_konseling }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- LINK RIWAYAT (Simple Footer) --}}
                <div class="lg:col-span-3 flex justify-end">
                    <a href="{{ route('dosen.curhat.index') }}" class="group inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 transition bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200 hover:shadow-md">
                        Lihat Riwayat & Status Lengkap 
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>