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
                      ($konseling->status_konseling === 'Dijadwalkan' || $konseling->status_konseling === 'Terjadwal' ? 'bg-indigo-100 text-indigo-800 border border-indigo-200' : 
                      'bg-amber-100 text-amber-800 border border-amber-200'))) }}">
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

            {{-- ALERT: INFO DARI DOSEN PA (JIKA ADA) --}}
            {{-- FIX: Menampilkan Data Lengkap Formulir Dosen Pembimbing --}}
            @if($konseling->sumber_pengajuan == 'dosen_pa' || $konseling->upaya_dilakukan)
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 shadow-md rounded-r-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4 w-full">
                            <h3 class="text-lg font-bold text-blue-800 mb-3">
                                Rujukan dari Dosen Pembimbing Akademik
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                @if($konseling->permasalahan)
                                    <div class="bg-white p-3 rounded border border-blue-100">
                                        <p class="font-semibold text-blue-900">Permasalahan Utama:</p>
                                        <p class="text-gray-700 mt-1">{{ $konseling->permasalahan }}</p>
                                    </div>
                                @endif
                                
                                @if($konseling->aspek_permasalahan)
                                    <div class="bg-white p-3 rounded border border-blue-100">
                                        <p class="font-semibold text-blue-900">Aspek Permasalahan:</p>
                                        <div class="text-gray-700 mt-1 flex flex-wrap gap-1">
                                            @if(is_array($konseling->aspek_permasalahan))
                                                @foreach($konseling->aspek_permasalahan as $aspek)
                                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full">{{ $aspek }}</span>
                                                @endforeach
                                            @else
                                                {{ $konseling->aspek_permasalahan }}
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if($konseling->upaya_dilakukan)
                                    <div class="bg-white p-3 rounded border border-blue-100">
                                        <p class="font-semibold text-blue-900">Upaya yang sudah dilakukan:</p>
                                        <p class="text-gray-700 mt-1">{{ $konseling->upaya_dilakukan }}</p>
                                    </div>
                                @endif

                                @if($konseling->harapan_pa)
                                    <div class="bg-white p-3 rounded border border-blue-100">
                                        <p class="font-semibold text-blue-900">Harapan Dosen PA:</p>
                                        <p class="text-gray-700 mt-1">{{ $konseling->harapan_pa }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- GRID UTAMA --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- KOLOM KIRI (2/3): Timeline, Jadwal, Hasil --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- 1. BAGIAN JADWAL & HASIL PER SESI --}}
                    @if($konseling->jadwalSesi->isNotEmpty())
                        <div class="space-y-6">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Riwayat Sesi Konseling
                            </h3>

                            @foreach($konseling->jadwalSesi as $index => $sesi)
                                <div class="bg-white overflow-hidden shadow-md rounded-xl border {{ $sesi->status_sesi == 'Selesai' ? 'border-emerald-200' : 'border-indigo-100' }}">
                                    {{-- HEADER SESI --}}
                                    <div class="px-6 py-3 {{ $sesi->status_sesi == 'Selesai' ? 'bg-emerald-50' : 'bg-indigo-50' }} flex justify-between items-center border-b {{ $sesi->status_sesi == 'Selesai' ? 'border-emerald-100' : 'border-indigo-100' }}">
                                        <div class="flex items-center gap-3">
                                            <span class="bg-white text-indigo-700 font-bold px-3 py-1 rounded text-xs shadow-sm border border-indigo-100">Sesi #{{ $index + 1 }}</span>
                                            <span class="text-sm font-semibold text-gray-700">
                                                {{ \Carbon\Carbon::parse($sesi->tgl_sesi ?? $sesi->jadwal_konseling)->translatedFormat('l, d F Y') }}
                                            </span>
                                        </div>
                                        <span class="text-xs font-bold uppercase {{ $sesi->status_sesi == 'Selesai' ? 'text-emerald-600' : 'text-indigo-600' }}">
                                            {{ $sesi->status_sesi ?? 'Terjadwal' }}
                                        </span>
                                    </div>

                                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                        {{-- INFO JADWAL --}}
                                        <div class="space-y-3">
                                            <div>
                                                <p class="text-xs text-gray-400 uppercase font-bold">Waktu</p>
                                                <p class="text-gray-800 font-medium">
                                                    {{ \Carbon\Carbon::parse($sesi->waktu_mulai ?? $sesi->jadwal_konseling)->format('H:i') }} 
                                                    @if($sesi->waktu_selesai) - {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }} @endif WIB
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-400 uppercase font-bold">Tempat / Lokasi</p>
                                                {{-- FIX: Tampilkan 'lokasi' ATAU 'tempat_konseling' --}}
                                                <p class="text-gray-800 font-medium flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                    {{ $sesi->lokasi ?? $sesi->tempat_konseling ?? 'Online / Lokasi belum diatur' }}
                                                </p>
                                            </div>
                                            @if($sesi->link_meeting)
                                                <div>
                                                    <a href="{{ $sesi->link_meeting }}" target="_blank" class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                        Join Meeting
                                                    </a>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- INFO HASIL (Jika Ada) --}}
                                        <div class="border-l pl-6 border-gray-100">
                                            <p class="text-xs text-gray-400 uppercase font-bold mb-2">Catatan Hasil Konseling</p>
                                            @if($sesi->hasilKonseling)
                                                {{-- FIX: Tampilkan hasil_konseling (Baru) atau diagnosis (Lama) --}}
                                                <div class="text-sm text-gray-700 bg-gray-50 p-3 rounded border border-gray-200 mb-3">
                                                    {{ $sesi->hasilKonseling->hasil_konseling ?? $sesi->hasilKonseling->diagnosis ?? 'Belum ada catatan detail.' }}
                                                </div>

                                                @if($sesi->hasilKonseling->rekomendasi)
                                                    <p class="text-xs text-gray-400 uppercase font-bold mb-1">Rekomendasi</p>
                                                    <div class="text-sm text-emerald-700 bg-emerald-50 p-2 rounded border border-emerald-100">
                                                        {{ $sesi->hasilKonseling->rekomendasi }}
                                                    </div>
                                                @endif
                                            @else
                                                <p class="text-sm text-gray-400 italic">Sesi ini belum memiliki catatan hasil.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- 2. DETAIL MASALAH MAHASISWA --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 mt-8">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <h3 class="font-bold text-gray-700">Data Awal Mahasiswa</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            @if($konseling->deskripsi_masalah)
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Deskripsi Masalah (Anda)</h4>
                                    <div class="p-4 bg-gray-50 rounded-lg text-gray-700 leading-relaxed border border-gray-100 text-sm">
                                        {{ $konseling->deskripsi_masalah }}
                                    </div>
                                </div>
                            @endif

                            @if($konseling->tujuan_konseling)
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Harapan / Tujuan</h4>
                                    <div class="p-4 bg-gray-50 rounded-lg text-gray-700 leading-relaxed border border-gray-100 text-sm">
                                        {{ $konseling->tujuan_konseling }}
                                    </div>
                                </div>
                            @endif

                             {{-- Asesmen K10 --}}
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
                                    @else
                                        <p class="text-gray-500 text-xs italic text-center">Data asesmen tidak tersedia.</p>
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