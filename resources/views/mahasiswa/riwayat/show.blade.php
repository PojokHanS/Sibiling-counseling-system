<x-app-layout>
    {{-- INJECT ALPINE.JS & FONTS --}}
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        .glass-header {
            background: linear-gradient(135deg, #047857 0%, #0d9488 100%);
        }
    </style>

    {{-- HEADER MODERN (THEME: GREEN EMERALD) --}}
    <div class="glass-header pb-32 pt-12 px-4 sm:px-8 shadow-lg relative overflow-hidden">
        {{-- Background Pattern Decoration --}}
        <svg class="absolute top-0 right-0 w-64 h-64 text-white opacity-5 transform translate-x-10 -translate-y-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/></svg>
        
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center text-white">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-md border border-white/30 rounded-full text-xs font-bold uppercase tracking-wider">
                            Tiket #{{ $konseling->id_konseling }}
                        </span>
                        <span class="px-3 py-1 bg-emerald-800/40 backdrop-blur-md border border-white/10 rounded-full text-xs font-bold uppercase tracking-wider">
                            {{ $konseling->jenis_konseli ?? 'Mahasiswa' }}
                        </span>
                    </div>
                    <h2 class="font-extrabold text-3xl md:text-4xl tracking-tight leading-tight">
                        Detail Perjalanan Konseling
                    </h2>
                    <p class="text-emerald-100 mt-2 text-sm md:text-base font-medium opacity-90 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Diajukan pada {{ \Carbon\Carbon::parse($konseling->tgl_pengajuan)->translatedFormat('l, d F Y') }}
                    </p>
                </div>
                
                <div class="mt-6 md:mt-0">
                    <a href="{{ route('mahasiswa.riwayat.index') }}" 
                       class="group px-5 py-2.5 bg-white text-emerald-800 hover:bg-emerald-50 rounded-xl text-sm font-bold transition shadow-xl flex items-center gap-2 transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 pb-20 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- LEFT COLUMN: TIMELINE & DATA (8 Columns) --}}
            <div class="lg:col-span-8 space-y-8">

                {{-- 1. BAGIAN FORMULIR DOSEN WALI (RUJUKAN) - PRIORITAS --}}
                @if($konseling->sumber_pengajuan == 'dosen_pa' || $konseling->upaya_dilakukan)
                    <div class="bg-white rounded-2xl shadow-xl border-l-4 border-emerald-500 overflow-hidden" x-data="{ openPA: true }">
                        <div class="bg-emerald-50/50 p-5 border-b border-emerald-100 flex justify-between items-center cursor-pointer" @click="openPA = !openPA">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">Rujukan Dosen Pembimbing</h3>
                                    <p class="text-xs text-emerald-600 font-bold uppercase tracking-wide">Data Observasi Awal</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform" :class="{'rotate-180': openPA}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                        
                        <div x-show="openPA" x-collapse class="p-6 space-y-6">
                            {{-- Observasi Masalah --}}
                            @if($konseling->permasalahan)
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Observasi Masalah (Oleh PA)</label>
                                <div class="mt-1 p-4 bg-gray-50 rounded-xl text-gray-700 leading-relaxed border border-gray-100 font-medium">
                                    "{{ $konseling->permasalahan }}"
                                </div>
                            </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Upaya Dilakukan --}}
                                @if($konseling->upaya_dilakukan)
                                <div class="bg-emerald-50/30 p-4 rounded-xl border border-emerald-100">
                                    <label class="text-xs font-bold text-emerald-700 uppercase flex items-center gap-1 mb-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        Upaya Sebelumnya
                                    </label>
                                    <p class="text-sm text-gray-700">{{ $konseling->upaya_dilakukan }}</p>
                                </div>
                                @endif

                                {{-- Harapan PA --}}
                                @if($konseling->harapan_pa)
                                <div class="bg-blue-50/30 p-4 rounded-xl border border-blue-100">
                                    <label class="text-xs font-bold text-blue-700 uppercase flex items-center gap-1 mb-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                        Harapan PA
                                    </label>
                                    <p class="text-sm text-gray-700">{{ $konseling->harapan_pa }}</p>
                                </div>
                                @endif
                            </div>

                            {{-- Aspek Permasalahan (Tags) --}}
                            @if($konseling->aspek_permasalahan)
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 block">Aspek Permasalahan</label>
                                <div class="flex flex-wrap gap-2">
                                    @php $aspek = is_array($konseling->aspek_permasalahan) ? $konseling->aspek_permasalahan : json_decode($konseling->aspek_permasalahan, true) ?? [$konseling->aspek_permasalahan]; @endphp
                                    @foreach($aspek as $item)
                                        <span class="px-3 py-1 bg-white border border-gray-200 text-gray-600 rounded-lg text-xs font-bold shadow-sm">
                                            # {{ $item }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- 2. KARTU MASALAH UTAMA (INPUTAN MAHASISWA) --}}
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 sm:p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full opacity-50 z-0"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span class="w-2 h-8 bg-emerald-500 rounded-full"></span>
                            Detail Keluhan
                        </h3>
                        
                        <div class="prose prose-emerald max-w-none">
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 text-gray-700 leading-relaxed relative">
                                <span class="absolute top-4 left-4 text-4xl text-emerald-200 font-serif leading-none opacity-50">"</span>
                                <p class="relative z-10 pl-6 italic">
                                    {{ $konseling->deskripsi_masalah ?? $konseling->permasalahan }}
                                </p>
                            </div>
                        </div>

                        @if($konseling->tujuan_konseling)
                            <div class="mt-6">
                                <h4 class="text-sm font-bold text-gray-800 uppercase mb-2">Harapan / Tujuan Konseling</h4>
                                <p class="text-sm text-gray-600 bg-white border border-gray-200 p-4 rounded-xl shadow-sm">
                                    {{ $konseling->tujuan_konseling }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- 3. TIMELINE JOURNEY (VISUALISASI SESI) --}}
                <div class="relative pl-6 sm:pl-8 pt-4">
                    {{-- Garis Timeline Hijau --}}
                    <div class="absolute left-3 sm:left-5 top-0 bottom-0 w-0.5 bg-gradient-to-b from-emerald-500 to-gray-200"></div>

                    <h3 class="text-lg font-bold text-gray-800 mb-8 relative z-10 flex items-center">
                        <span class="bg-emerald-600 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3 shadow-lg shadow-emerald-200 ring-4 ring-white text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        Timeline Sesi Konseling
                    </h3>

                    {{-- LOOP SESI --}}
                    @forelse($konseling->jadwalSesi as $index => $sesi)
                        <div class="relative mb-8 group" x-data="{ expandedSesi: false }">
                            {{-- Dot Connector --}}
                            <div class="absolute -left-[35px] sm:-left-[43px] top-6 w-4 h-4 rounded-full border-2 border-white 
                                {{ $sesi->status_sesi == 'Selesai' ? 'bg-emerald-500 ring-4 ring-emerald-50' : 'bg-gray-300 ring-4 ring-gray-50' }} z-10 shadow-sm"></div>

                            {{-- Card Sesi --}}
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg hover:border-emerald-200 transition-all duration-300 overflow-hidden">
                                {{-- Header --}}
                                <div class="px-5 py-4 flex justify-between items-center bg-gray-50/50 border-b border-gray-100 cursor-pointer" @click="expandedSesi = !expandedSesi">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-white p-2 rounded-lg border border-gray-100 shadow-sm text-center min-w-[60px]">
                                            <span class="block text-xs text-gray-400 font-bold uppercase">{{ \Carbon\Carbon::parse($sesi->tgl_sesi)->format('M') }}</span>
                                            <span class="block text-lg font-extrabold text-gray-800">{{ \Carbon\Carbon::parse($sesi->tgl_sesi)->format('d') }}</span>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800">Sesi Konseling #{{ $index + 1 }}</h4>
                                            <p class="text-xs text-gray-500 font-medium">
                                                {{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }} WIB
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold 
                                            {{ $sesi->status_sesi == 'Selesai' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $sesi->status_sesi ?? 'Terjadwal' }}
                                        </span>
                                        <svg class="w-5 h-5 text-gray-400 transform transition-transform" :class="{'rotate-180': expandedSesi}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>

                                {{-- Body --}}
                                <div x-show="expandedSesi" x-collapse class="p-5">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div class="flex items-center gap-3 text-sm text-gray-600 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            <div>
                                                <span class="block text-xs text-gray-400 font-bold uppercase">Lokasi</span>
                                                <span class="font-semibold">{{ $sesi->lokasi ?? $sesi->tempat_konseling ?? 'Online' }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 text-sm text-gray-600 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            <div>
                                                <span class="block text-xs text-gray-400 font-bold uppercase">Metode</span>
                                                <span class="font-semibold">{{ $sesi->metode_konseling }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    @if($sesi->hasilKonseling)
                                        <div class="bg-gradient-to-r from-emerald-50 to-white border border-emerald-100 rounded-xl p-4 mt-4">
                                            <h5 class="text-xs font-bold text-emerald-800 uppercase mb-2 flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Hasil Konseling
                                            </h5>
                                            <p class="text-sm text-gray-700 leading-relaxed mb-3">
                                                {{ $sesi->hasilKonseling->diagnosis ?? $sesi->hasilKonseling->hasil_konseling }}
                                            </p>
                                            
                                            @if($sesi->hasilKonseling->rekomendasi)
                                                <div class="pt-3 border-t border-emerald-100">
                                                    <span class="text-xs font-bold text-emerald-600 uppercase">Rekomendasi:</span>
                                                    <p class="text-sm text-emerald-800 font-medium">{{ $sesi->hasilKonseling->rekomendasi }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-400 italic text-center py-2">Belum ada catatan hasil.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 bg-white border-2 border-dashed border-gray-200 rounded-2xl text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h4 class="text-gray-800 font-bold">Belum Ada Sesi</h4>
                            <p class="text-sm text-gray-500">Menunggu jadwal dari Dosen Konseling.</p>
                        </div>
                    @endforelse

                    {{-- Finish Point --}}
                    <div class="absolute left-3 sm:left-5 bottom-0 w-3 h-3 bg-gray-300 rounded-full -ml-1.5 ring-4 ring-white"></div>
                </div>
            </div>

            {{-- RIGHT COLUMN: SIDEBAR (4 Columns) --}}
            <div class="lg:col-span-4 space-y-6">
                
                {{-- 1. STATUS BADGE --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 text-center">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Status Saat Ini</h4>
                    @php
                        $statusClass = match($konseling->status_konseling) {
                            'Selesai' => 'bg-emerald-100 text-emerald-700 border-emerald-200 ring-emerald-50',
                            'Disetujui' => 'bg-blue-100 text-blue-700 border-blue-200 ring-blue-50',
                            'Ditolak' => 'bg-red-100 text-red-700 border-red-200 ring-red-50',
                            default => 'bg-orange-100 text-orange-700 border-orange-200 ring-orange-50',
                        };
                    @endphp
                    <span class="inline-block px-6 py-2 rounded-full text-lg font-extrabold border ring-4 {{ $statusClass }}">
                        {{ strtoupper($konseling->status_konseling) }}
                    </span>
                    
                    {{-- TOMBOL SURVEI LOGIC --}}
                    @if($konseling->status_konseling == 'Selesai')
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            @if($konseling->surveiKepuasan)
                                <a href="{{ route('mahasiswa.survei.download', $konseling->id_konseling) }}" class="block w-full py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 shadow-lg hover:shadow-emerald-200 transition mb-2">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Download Bukti
                                    </div>
                                </a>
                                <p class="text-xs text-emerald-600 font-medium">Anda sudah mengisi survei evaluasi.</p>
                            @else
                                <a href="{{ route('mahasiswa.survei.create', $konseling->id_konseling) }}" class="block w-full py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 shadow-lg hover:shadow-blue-200 transition animate-pulse">
                                    Isi Survei Evaluasi
                                </a>
                                <p class="text-xs text-gray-500 mt-2">Wajib diisi untuk unduh bukti.</p>
                            @endif
                        </div>
                    @endif
                    
                    <p class="text-xs text-gray-400 mt-3">
                        Terakhir diperbarui: {{ optional($konseling->updated_at)->diffForHumans() ?? '-' }}
                    </p>
                </div>

                {{-- 2. PROFILE DOSEN PEMBIMBING --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gray-800 p-4">
                        <h4 class="text-xs font-bold text-white uppercase tracking-widest">Dosen Pembimbing</h4>
                    </div>
                    <div class="p-6">
                        @if($konseling->dosenWali && $konseling->dosenWali->user)
                            <div class="flex flex-col items-center text-center">
                                <img class="h-20 w-20 rounded-full object-cover border-4 border-white shadow-md -mt-10" 
                                     src="https://ui-avatars.com/api/?name={{ urlencode($konseling->dosenWali->user->name) }}&background=047857&color=fff&size=128" 
                                     alt="{{ $konseling->dosenWali->user->name }}">
                                <h5 class="mt-3 font-bold text-gray-800">{{ $konseling->dosenWali->user->name }}</h5>
                                <p class="text-xs text-gray-500">{{ $konseling->dosenWali->nidn }}</p>
                                <span class="mt-2 px-3 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold rounded-full uppercase">
                                    Academic Advisor
                                </span>
                            </div>
                        @else
                            <p class="text-gray-400 text-sm italic text-center">Tidak ada data dosen.</p>
                        @endif
                    </div>
                </div>

                {{-- 3. ASESMEN K10 --}}
                <div x-data="{ openK10: false }" class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <button @click="openK10 = !openK10" class="w-full flex justify-between items-center p-4 bg-gradient-to-r from-emerald-600 to-teal-500 text-white hover:opacity-90 transition">
                        <div class="text-left">
                            <h4 class="font-bold text-sm">Hasil Asesmen K10</h4>
                            <p class="text-[10px] opacity-80">Klik untuk lihat detail</p>
                        </div>
                        <svg class="w-5 h-5 transform transition-transform" :class="{'rotate-180': openK10}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="openK10" x-collapse class="bg-gray-50">
                         @php 
                            $questions = [
                                1 => 'Lelah tanpa sebab?', 2 => 'Merasa cemas?', 3 => 'Sangat gugup?', 4 => 'Putus asa?', 5 => 'Gelisah?',
                                6 => 'Tidak bisa duduk tenang?', 7 => 'Merasa tertekan?', 8 => 'Sulit beraktivitas?', 9 => 'Sangat sedih?', 10 => 'Tidak berharga?'
                            ];
                            $hasil = is_string($konseling->asesmen_k10) ? json_decode($konseling->asesmen_k10, true) : $konseling->asesmen_k10; 
                        @endphp

                        @if(!empty($hasil) && is_array($hasil))
                            <div class="divide-y divide-gray-200 max-h-60 overflow-y-auto">
                                @foreach($hasil as $index => $jawaban)
                                    <div class="px-4 py-2 flex justify-between items-center text-xs">
                                        <span class="text-gray-500 w-2/3 truncate">{{ $questions[$index + 1] ?? 'Q'.($index+1) }}</span>
                                        <span class="font-bold text-emerald-700">{{ $jawaban }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-4 text-center text-gray-400 text-xs">Data tidak tersedia.</div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>