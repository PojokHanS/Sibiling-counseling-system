<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Hasil Konseling') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- KOTAK UTAMA: HASIL / FEEDBACK WAREK --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border-t-4 {{ $konseling->status_konseling == 'Selesai' ? 'border-green-500' : 'border-red-500' }}">
                <div class="p-6 sm:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">
                            {{ $konseling->status_konseling == 'Selesai' ? 'Hasil & Kesimpulan Konseling' : 'Alasan Penolakan' }}
                        </h3>
                        <span class="px-3 py-1 rounded-full text-sm font-bold {{ $konseling->status_konseling == 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ strtoupper($konseling->status_konseling) }}
                        </span>
                    </div>

                    {{-- ISI CATATAN WAREK --}}
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                        <p class="text-xs font-bold text-gray-400 uppercase mb-2">Catatan dari Wakil Rektor</p>
                        <div class="prose max-w-none text-gray-800 text-base leading-relaxed whitespace-pre-line">
                            {{ $konseling->catatan_warek }}
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end text-xs text-gray-400">
                        Diselesaikan pada: {{ $konseling->updated_at->format('d F Y, H:i') }} WIB
                    </div>
                </div>
            </div>

            {{-- KOTAK KEDUA: REVIEW PENGAJUAN AWAL (HISTORY) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-bold text-gray-700">Data Pengajuan Awal Anda</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase mb-1">Tanggal Pengajuan</p>
                        <p class="text-gray-900">{{ $konseling->created_at->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase mb-1">Jadwal Sesi (History)</p>
                        <p class="text-gray-900">
                            @if($konseling->jadwal_konseling)
                                {{ \Carbon\Carbon::parse($konseling->jadwal_konseling)->format('d F Y, H:i') }} WIB
                                <br><span class="text-xs text-gray-500">Lokasi: {{ $konseling->lokasi_konseling }}</span>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs font-bold text-gray-400 uppercase mb-1">Masalah yang Disampaikan</p>
                        <p class="text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100">{{ $konseling->deskripsi_masalah }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs font-bold text-gray-400 uppercase mb-1">Harapan Awal</p>
                        <p class="text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100">{{ $konseling->tujuan_konseling }}</p>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 flex justify-end">
                    <a href="{{ route('dosen.curhat.riwayat') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                        Kembali ke Arsip
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>