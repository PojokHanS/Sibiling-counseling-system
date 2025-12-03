<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Perjalanan Konseling') }}
            </h2>
            <div class="mt-2 sm:mt-0">
                <span class="px-4 py-1.5 text-sm font-bold rounded-full shadow-sm
                    {{ $konseling->status_konseling === 'Selesai' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 
                      ($konseling->status_konseling === 'Ditolak' ? 'bg-red-100 text-red-800 border border-red-200' : 
                      ($konseling->status_konseling === 'Disetujui' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 
                      ($konseling->status_konseling === 'Dijadwalkan' ? 'bg-indigo-100 text-indigo-800 border border-indigo-200' : 'bg-amber-100 text-amber-800 border border-amber-200'))) }}">
                    Status: {{ strtoupper($konseling->status_konseling) }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('mahasiswa.riwayat.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-emerald-600 transition group">
                <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Riwayat
            </a>

            {{-- ALERT: ALASAN PENOLAKAN (Hanya muncul jika Ditolak/Revisi) --}}
            @if(in_array($konseling->status_konseling, ['Ditolak', 'Perlu Revisi']) && $konseling->alasan_penolakan)
                <div class="bg-red-50 border-l-4 border-red-500 p-6 shadow-md rounded-r-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-bold text-red-800">
                                {{ $konseling->status_konseling === 'Ditolak' ? 'Pengajuan Ditolak' : 'Perlu Revisi' }}
                            </h3>
                            <div class="mt-2 text-red-700 text-sm leading-relaxed">
                                <p class="font-semibold">Catatan dari Dosen:</p>
                                <p class="bg-white/50 p-3 rounded mt-1 border border-red-100 italic">"{{ $konseling->alasan_penolakan }}"</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- GRID UTAMA --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- KOLOM KIRI (2/3): Timeline, Jadwal, Hasil, Detail Masalah --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- 1. BAGIAN JADWAL KONSELING (Muncul jika ada jadwal) --}}
                    @if($konseling->jadwalSesi->isNotEmpty())
                        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-indigo-100">
                            <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-blue-600 flex items-center gap-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <h3 class="font-bold text-white text-lg">Agenda Jadwal Konseling</h3>
                            </div>
                            <div class="p-6 bg-indigo-50/30">
                                <div class="space-y-4">
                                    @foreach($konseling->jadwalSesi as $index => $sesi)
                                        <div class="flex flex-col md:flex-row gap-4 bg-white p-4 rounded-lg border border-indigo-100 shadow-sm hover:shadow-md transition">
                                            {{-- Tanggal --}}
                                            <div class="flex-shrink-0 text-center bg-indigo-50 rounded-lg p-3 min-w-[100px] border border-indigo-100">
                                                <span class="block text-xs font-bold text-indigo-500 uppercase">{{ \Carbon\Carbon::parse($sesi->jadwal_konseling)->translatedFormat('F') }}</span>
                                                <span class="block text-2xl font-extrabold text-indigo-700">{{ \Carbon\Carbon::parse($sesi->jadwal_konseling)->format('d') }}</span>
                                                <span class="block text-xs font-medium text-gray-500">{{ \Carbon\Carbon::parse($sesi->jadwal_konseling)->translatedFormat('l') }}</span>
                                            </div>
                                            
                                            {{-- Detail --}}
                                            <div class="flex-1 space-y-2">
                                                <div class="flex justify-between items-start">
                                                    <h4 class="font-bold text-gray-800">Sesi Konseling #{{ $index + 1 }}</h4>
                                                    <span class="text-xs px-2 py-1 bg-gray-100 rounded text-gray-600">
                                                        {{ \Carbon\Carbon::parse($sesi->jadwal_konseling)->format('H:i') }} WIB
                                                    </span>
                                                </div>
                                                
                                                <div class="text-sm text-gray-600">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                        <span>{{ $sesi->tempat_konseling ?? 'Online / Lokasi ditentukan Dosen' }}</span>
                                                    </div>
                                                    @if($sesi->link_meeting)
                                                        <div class="flex items-center gap-2 mt-2">
                                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                            <a href="{{ $sesi->link_meeting }}" target="_blank" class="text-blue-600 hover:underline font-medium">
                                                                Link Meeting (Zoom/GMeet)
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- 2. BAGIAN HASIL KONSELING (Muncul jika sudah ada hasil/selesai) --}}
                    @if($konseling->hasilKonseling)
                        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-emerald-100">
                            <div class="px-6 py-4 bg-gradient-to-r from-emerald-600 to-green-600 flex items-center gap-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <h3 class="font-bold text-white text-lg">Hasil & Kesimpulan Konseling</h3>
                            </div>
                            <div class="p-6 bg-emerald-50/30">
                                <div class="prose prose-sm max-w-none text-gray-700">
                                    <h4 class="font-bold text-emerald-800 mb-2">Catatan Dosen Konselor:</h4>
                                    <div class="bg-white p-4 rounded-lg border border-emerald-100 shadow-sm mb-4">
                                        {{ $konseling->hasilKonseling->hasil_konseling ?? 'Belum ada catatan detail.' }}
                                    </div>
                                    
                                    @if($konseling->hasilKonseling->rekomendasi)
                                        <h4 class="font-bold text-emerald-800 mb-2">Rekomendasi / Tindak Lanjut:</h4>
                                        <div class="bg-white p-4 rounded-lg border border-emerald-100 shadow-sm">
                                            {{ $konseling->hasilKonseling->rekomendasi }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- 3. DETAIL PERMASALAHAN (Readonly) --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <h3 class="font-bold text-gray-700">Arsip Pengajuan Awal</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Deskripsi Masalah</h4>
                                <div class="p-4 bg-gray-50 rounded-lg text-gray-700 leading-relaxed border border-gray-100 text-sm">
                                    {{ $konseling->deskripsi_masalah ?? 'Tidak ada deskripsi.' }}
                                </div>
                            </div>

                            <div>
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Harapan / Tujuan</h4>
                                <div class="p-4 bg-gray-50 rounded-lg text-gray-700 leading-relaxed border border-gray-100 text-sm">
                                    {{ $konseling->tujuan_konseling ?? 'Tidak ada tujuan spesifik.' }}
                                </div>
                            </div>

                             {{-- Asesmen K10 (Accordion Style) --}}
                             <div x-data="{ open: false }" class="border border-gray-200 rounded-lg">
                                <button @click="open = !open" class="w-full px-4 py-3 bg-gray-50 flex justify-between items-center text-sm font-medium text-gray-600 hover:bg-gray-100 transition">
                                    <span>Lihat Hasil Asesmen Awal (K10)</span>
                                    <svg class="w-4 h-4 transform transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="open" class="p-4 bg-white border-t border-gray-200">
                                    @php 
                                        $questions = [
                                            1 => 'Lelah tanpa sebab?', 2 => 'Merasa cemas?', 3 => 'Sangat gugup?', 4 => 'Putus asa?', 5 => 'Gelisah?',
                                            6 => 'Tidak bisa duduk tenang?', 7 => 'Merasa tertekan?', 8 => 'Sulit beraktivitas?', 9 => 'Sangat sedih?', 10 => 'Tidak berharga?'
                                        ];
                                        $hasil = $konseling->asesmen_k10; 
                                    @endphp
                                    @if(!empty($hasil) && is_array($hasil))
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                            @foreach($hasil as $index => $jawaban)
                                                <div class="text-xs flex justify-between border-b border-gray-100 py-1">
                                                    <span class="text-gray-500">{{ $index + 1 }}. {{ $questions[$index + 1] ?? 'Q'.($index+1) }}</span>
                                                    <span class="font-bold text-gray-700">{{ $jawaban }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN (1/3): Meta Data & Info --}}
                <div class="space-y-6">
                    
                    {{-- Card Info Status --}}
                    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 overflow-hidden">
                        <div class="bg-gray-800 px-6 py-4">
                            <h3 class="font-bold text-white text-sm uppercase tracking-wider">Info Pengajuan</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-semibold">Tanggal Pengajuan</p>
                                <p class="text-gray-800 font-medium">
                                    {{ \Carbon\Carbon::parse($konseling->tgl_pengajuan)->translatedFormat('l, d F Y') }}
                                </p>
                            </div>
                            
                            <hr class="border-dashed border-gray-200">

                            <div>
                                <p class="text-xs text-gray-400 uppercase font-semibold">Kategori Masalah</p>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @if($konseling->jenis_permasalahan)
                                        @foreach($konseling->jenis_permasalahan as $jenis)
                                            <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-md font-medium border border-purple-200">
                                                {{ $jenis }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-gray-500 text-sm">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card Info Dosen Wali --}}
                    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 overflow-hidden">
                        <div class="px-6 py-3 border-b border-gray-100 bg-gray-50">
                            <h3 class="font-bold text-gray-700 text-xs uppercase">Dosen Pembimbing Akademik</h3>
                        </div>
                        <div class="p-6">
                            @if($konseling->dosenWali && $konseling->dosenWali->user)
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full bg-gray-200 object-cover" 
                                             src="https://ui-avatars.com/api/?name={{ urlencode($konseling->dosenWali->user->name) }}&background=0D9488&color=fff" 
                                             alt="{{ $konseling->dosenWali->user->name }}">
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $konseling->dosenWali->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $konseling->dosenWali->nidn ?? '' }}</div>
                                    </div>
                                </div>
                            @else
                                <div class="text-gray-500 italic text-sm text-center">Data PA tidak tersedia.</div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>