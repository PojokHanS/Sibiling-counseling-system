<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Kasus Konseling') }}
            </h2>
            <div class="mt-2 sm:mt-0">
                <span class="px-3 py-1 text-sm font-bold rounded-full 
                    {{ $konseling->status_konseling === 'Selesai' ? 'bg-green-100 text-green-800' : 
                      ($konseling->status_konseling === 'Butuh Sesi Lanjutan' ? 'bg-yellow-100 text-yellow-800' : 
                      'bg-blue-100 text-blue-800') }}">
                    {{ $konseling->status_konseling }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- TOMBOL KEMBALI --}}
            <a href="{{ route('dosen-konseling.kasus.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Kasus
            </a>

            {{-- CARD 1: INFORMASI MAHASISWA & MASALAH --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Profil & Permasalahan Awal</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Kiri: Data Diri --}}
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-16 w-16 bg-gray-200 rounded-full overflow-hidden">
                                     <img class="h-16 w-16 object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($konseling->mahasiswa->user->name) }}&background=random" alt="Foto">
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-bold">{{ $konseling->mahasiswa->user->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $konseling->nim_mahasiswa }}</p>
                                    <p class="text-sm text-gray-500">{{ $konseling->mahasiswa->prodi->nama_prodi ?? 'Prodi tidak ditemukan' }}</p>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-sm space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">No. HP / WA:</span>
                                    <span class="font-medium">{{ $konseling->mahasiswa->no_hp ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Dosen Wali:</span>
                                    <span class="font-medium">{{ $konseling->dosenWali->user->name ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Tgl Pengajuan:</span>
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($konseling->tgl_pengajuan)->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Kanan: Detail Masalah (FIX LOGIC HERE) --}}
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-semibold text-gray-700">Jenis Permasalahan</h4>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @if(is_array($konseling->jenis_permasalahan))
                                        @foreach($konseling->jenis_permasalahan as $jenis)
                                            <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-full">{{ $jenis }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-gray-500 text-sm">-</span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <h4 class="font-semibold text-gray-700">Deskripsi Masalah</h4>
                                <p class="text-gray-600 text-sm bg-gray-50 p-3 rounded mt-1 border border-gray-100">
                                    {{ $konseling->deskripsi_masalah ?? $konseling->permasalahan ?? 'Tidak ada deskripsi.' }}
                                </p>
                            </div>

                            <div>
                                <h4 class="font-semibold text-gray-700">Tujuan / Harapan</h4>
                                <p class="text-gray-600 text-sm bg-gray-50 p-3 rounded mt-1 border border-gray-100">
                                    {{ $konseling->tujuan_konseling ?? $konseling->harapan_konseling ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- BAGIAN ASESMEN (FIX ERROR 500) --}}
                    <div class="mt-8 border-t pt-6">
                        <h4 class="font-bold text-gray-800 mb-4">Hasil Asesmen Awal (Self-Report)</h4>
                        
                        @if(!empty($konseling->asesmen_k10) && is_array($konseling->asesmen_k10))
                            {{-- TAMPILKAN FORMAT BARU (K10) --}}
                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                                <h5 class="text-sm font-bold text-blue-800 mb-2">Instrumen K10 (Kessler Psychological Distress Scale)</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2">
                                    @php 
                                        $questionsK10 = [
                                            1 => 'Lelah tanpa alasan yang jelas?', 
                                            2 => 'Merasa gugup?', 
                                            3 => 'Merasa sangat gugup hingga tidak tenang?', 
                                            4 => 'Merasa putus asa?', 
                                            5 => 'Merasa gelisah atau tidak bisa diam?',
                                            6 => 'Merasa tidak bisa duduk tenang?', 
                                            7 => 'Merasa tertekan?', 
                                            8 => 'Merasa segala sesuatu berat?', 
                                            9 => 'Merasa sangat sedih hingga tidak terhibur?', 
                                            10 => 'Merasa tidak berharga?'
                                        ];
                                    @endphp
                                    @foreach($konseling->asesmen_k10 as $idx => $ans)
                                        <div class="flex justify-between border-b border-blue-100 py-1 text-sm">
                                            <span class="text-gray-600">{{ $loop->iteration }}. {{ $questionsK10[$loop->iteration] ?? 'Pertanyaan '.$loop->iteration }}</span>
                                            <span class="font-semibold text-blue-700">{{ $ans }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        @elseif(!empty($konseling->hasil_asesmen) && is_array($konseling->hasil_asesmen))
                            {{-- TAMPILKAN FORMAT LAMA (LEGACY) --}}
                            <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-100">
                                <h5 class="text-sm font-bold text-yellow-800 mb-2">Asesmen Awal (Format Lama)</h5>
                                <ul class="space-y-2">
                                    @foreach($konseling->hasil_asesmen as $index => $jawaban)
                                        <li class="flex justify-between text-sm border-b border-yellow-200 pb-1">
                                            <span class="text-gray-600">Pertanyaan #{{ $index }}</span>
                                            <span class="font-semibold text-yellow-700">{{ $jawaban }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <p class="text-gray-400 italic text-sm">Tidak ada data asesmen awal.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- CARD 2: RIWAYAT SESI KONSELING --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Riwayat Sesi & Catatan Perkembangan</h3>
                        
                        {{-- Tombol Tambah Jadwal Baru --}}
                        @if($konseling->status_konseling !== 'Selesai' && $konseling->status_konseling !== 'Ditolak')
                            <a href="{{ route('dosen-konseling.jadwal.create', $konseling->id_konseling) }}" class="text-sm bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md shadow transition">
                                + Jadwalkan Sesi Baru
                            </a>
                        @endif
                    </div>

                    @if($konseling->jadwalSesi->isEmpty())
                        <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                            <p class="text-gray-500">Belum ada sesi konseling yang dijadwalkan.</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($konseling->jadwalSesi as $sesi)
                                <div class="border rounded-lg overflow-hidden {{ $sesi->status_sesi == 'Selesai' ? 'border-green-200 bg-green-50' : 'border-gray-200' }}">
                                    {{-- Header Sesi --}}
                                    <div class="px-4 py-3 {{ $sesi->status_sesi == 'Selesai' ? 'bg-green-100' : 'bg-gray-100' }} flex justify-between items-center">
                                        <div>
                                            <span class="font-bold text-gray-700">Sesi {{ \Carbon\Carbon::parse($sesi->jadwal_konseling)->format('d M Y, H:i') }} WIB</span>
                                            <span class="text-xs ml-2 px-2 py-0.5 rounded-full {{ $sesi->metode_konseling == 'Online' ? 'bg-blue-200 text-blue-800' : 'bg-orange-200 text-orange-800' }}">
                                                {{ $sesi->metode_konseling }}
                                            </span>
                                        </div>
                                        <span class="text-xs font-semibold uppercase {{ $sesi->status_sesi == 'Selesai' ? 'text-green-700' : 'text-gray-500' }}">
                                            {{ $sesi->status_sesi }}
                                        </span>
                                    </div>

                                    {{-- Body Sesi (Hasil) --}}
                                    <div class="p-4">
                                        @if($sesi->hasilKonseling)
                                            <div class="prose prose-sm max-w-none">
                                                <p><strong class="text-gray-700">Catatan Konseling:</strong></p>
                                                <p class="text-gray-600 whitespace-pre-line">{{ $sesi->hasilKonseling->hasil_konseling }}</p>
                                                
                                                @if($sesi->hasilKonseling->rekomendasi)
                                                    <div class="mt-3 pt-3 border-t border-green-200">
                                                        <p><strong class="text-gray-700">Rekomendasi / Tindak Lanjut:</strong></p>
                                                        <p class="text-gray-600">{{ $sesi->hasilKonseling->rekomendasi }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="flex justify-between items-center">
                                                <p class="text-sm text-gray-500 italic">Sesi ini belum dilaksanakan atau belum ada catatan hasil.</p>
                                                @if($sesi->status_sesi == 'Menunggu')
                                                    <a href="{{ route('dosen-konseling.jadwal.mulaiSesi', $sesi->id_jadwal) }}" class="text-xs bg-indigo-100 text-indigo-700 hover:bg-indigo-200 px-3 py-1 rounded transition">
                                                        Mulai / Catat Sesi
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>