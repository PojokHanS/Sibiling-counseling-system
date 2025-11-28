<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{-- JUDUL DINAMIS SESUAI STATUS --}}
                @if(in_array($konseling->status_konseling, ['Selesai', 'Ditolak']))
                    {{ __('Detail Riwayat & Arsip') }}
                @else
                    {{ __('Proses Pengajuan Konseling') }}
                @endif
            </h2>
            <a href="{{ url()->previous() }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- KOLOM KIRI: DETAIL INFORMASI (SELALU MUNCUL) --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Info Dosen --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Identitas Dosen
                    </h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Nama Lengkap</p>
                            <p class="font-semibold text-gray-900">{{ $konseling->user->name ?? 'Tidak Diketahui' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Email</p>
                            <p class="font-semibold text-gray-900">{{ $konseling->email_dosen }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Tanggal Pengajuan</p>
                            <p class="font-semibold text-gray-900">{{ $konseling->created_at->format('d F Y, H:i') }} WIB</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Status Terakhir</p>
                            @php
                                $badgeColor = match($konseling->status_konseling) {
                                    'Selesai' => 'bg-green-100 text-green-800',
                                    'Ditolak' => 'bg-red-100 text-red-800',
                                    'Dijadwalkan' => 'bg-blue-100 text-blue-800',
                                    default => 'bg-yellow-100 text-yellow-800'
                                };
                            @endphp
                            <span class="inline-flex px-2 py-1 text-xs font-bold rounded-full {{ $badgeColor }}">
                                {{ $konseling->status_konseling }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Detail Masalah --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Detail Permasalahan
                    </h3>
                    <div class="mb-6">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi Masalah</p>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-gray-700 leading-relaxed whitespace-pre-line">{{ $konseling->deskripsi_masalah }}</div>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Harapan / Tujuan</p>
                        <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-100 text-indigo-900 font-medium">{{ $konseling->tujuan_konseling }}</div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: LOGIC SMART VIEW --}}
            <div class="lg:col-span-1">
                
                {{-- === MODE 1: LIHAT ARSIP (JIKA SUDAH SELESAI) === --}}
                @if(in_array($konseling->status_konseling, ['Selesai', 'Ditolak']))
                    <div class="bg-white rounded-xl shadow-lg border-t-4 {{ $konseling->status_konseling == 'Selesai' ? 'border-green-500' : 'border-red-500' }} sticky top-6">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">
                                {{ $konseling->status_konseling == 'Selesai' ? 'Hasil Konseling' : 'Alasan Penolakan' }}
                            </h3>
                            
                            {{-- TAMPILKAN CATATAN WAREK (READ ONLY) --}}
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4">
                                <p class="text-xs font-bold text-gray-400 uppercase mb-2">Catatan Anda (Warek)</p>
                                <div class="text-gray-800 text-sm leading-relaxed whitespace-pre-line">
                                    {{ $konseling->catatan_warek }}
                                </div>
                            </div>

                            {{-- TAMPILKAN JADWAL FINAL (JIKA ADA) --}}
                            @if($konseling->jadwal_konseling)
                                <div class="mb-4 pt-4 border-t border-dashed border-gray-200">
                                    <p class="text-xs font-bold text-gray-400 uppercase mb-2">Pelaksanaan Sesi</p>
                                    <div class="flex items-start text-sm text-gray-700">
                                        <svg class="w-4 h-4 mt-0.5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <div>
                                            {{ \Carbon\Carbon::parse($konseling->jadwal_konseling)->format('d F Y, H:i') }} WIB
                                            <br>
                                            <span class="text-gray-500 text-xs">Lokasi: {{ $konseling->lokasi_konseling }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="mt-6">
                                <span class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-500 text-sm font-bold rounded-lg cursor-not-allowed">
                                    Kasus Ditutup
                                </span>
                                <p class="text-center text-xs text-gray-400 mt-2">
                                    Diselesaikan: {{ $konseling->updated_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>

                {{-- === MODE 2: FORM KERJA (JIKA MASIH AKTIF) === --}}
                @else
                    <div class="bg-white rounded-xl shadow-lg border border-indigo-100 sticky top-6 overflow-hidden">
                        <div class="bg-indigo-600 px-6 py-4">
                            <h3 class="text-white font-bold text-lg">Tindak Lanjut</h3>
                            <p class="text-indigo-200 text-xs">Silakan proses pengajuan ini</p>
                        </div>

                        <div class="p-6">
                            <form action="{{ route('warek.konseling.update', $konseling->id_konseling_dosen) }}" method="POST">
                                @csrf
                                @method('PUT')

                                {{-- LOGIC SUB-FORM (Sama seperti sebelumnya) --}}
                                @if($konseling->status_konseling == 'Menunggu Verifikasi')
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Keputusan Awal</label>
                                        <select name="status_konseling" id="status_awal" class="w-full border-gray-300 rounded-lg shadow-sm" onchange="toggleFormAwal(this.value)">
                                            <option value="Menunggu Verifikasi">-- Pilih Tindakan --</option>
                                            <option value="Dijadwalkan">📅 Terima & Jadwalkan Sesi</option>
                                            <option value="Ditolak">❌ Tolak Pengajuan</option>
                                        </select>
                                    </div>

                                    <div id="form_jadwal_awal" class="hidden space-y-4 mb-4 border-l-2 border-indigo-500 pl-3">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Waktu Pertemuan</label>
                                            <input type="datetime-local" name="jadwal_konseling" class="w-full border-gray-300 rounded-md text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Lokasi</label>
                                            <input type="text" name="lokasi_konseling" placeholder="Contoh: Ruang Warek 1" class="w-full border-gray-300 rounded-md text-sm">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                                        <textarea name="catatan_warek" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="Tulis pesan..." required></textarea>
                                    </div>

                                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow transition">Simpan Keputusan</button>

                                @elseif($konseling->status_konseling == 'Dijadwalkan')
                                    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Pilih Aksi</label>
                                        <select name="status_konseling" id="aksi_lanjutan" class="w-full border-gray-300 rounded-lg shadow-sm text-sm" onchange="toggleFormLanjut(this.value)">
                                            <option value="Dijadwalkan" selected>🔄 Update Jadwal (Reschedule)</option>
                                            <option value="Selesai">✅ Selesaikan Kasus</option>
                                        </select>
                                    </div>

                                    {{-- FORM EDIT JADWAL --}}
                                    <div id="form_edit_jadwal" class="space-y-4 mb-6">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Update Waktu</label>
                                            <input type="datetime-local" name="jadwal_konseling" 
                                                value="{{ \Carbon\Carbon::parse($konseling->jadwal_konseling)->format('Y-m-d\TH:i') }}" 
                                                class="w-full border-gray-300 rounded-md text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Update Lokasi</label>
                                            <input type="text" name="lokasi_konseling" 
                                                value="{{ $konseling->lokasi_konseling }}" 
                                                class="w-full border-gray-300 rounded-md text-sm">
                                        </div>
                                        <div class="hidden">
                                            <input type="text" name="catatan_warek" value="{{ $konseling->catatan_warek ?? 'Jadwal diperbarui' }}"> 
                                        </div>
                                        <button type="submit" class="w-full bg-white border border-indigo-600 text-indigo-600 hover:bg-indigo-50 font-bold py-2 px-4 rounded-lg shadow-sm transition">Simpan Jadwal Baru</button>
                                    </div>

                                    {{-- FORM SELESAI --}}
                                    <div id="form_hasil" class="hidden space-y-4 mb-6 border-t pt-4 border-dashed border-gray-300">
                                        <div class="bg-green-50 p-3 rounded text-xs text-green-800 border border-green-100">
                                            <strong>Info:</strong> Data akan dipindahkan ke Arsip Riwayat.
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-gray-800 mb-1">Hasil Konseling</label>
                                            <textarea name="catatan_warek" id="input_hasil" rows="5" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" placeholder="Kesimpulan akhir..."></textarea>
                                        </div>
                                        {{-- Input Hidden Jadwal Lama --}}
                                        <input type="hidden" name="jadwal_konseling" value="{{ $konseling->jadwal_konseling }}">
                                        <input type="hidden" name="lokasi_konseling" value="{{ $konseling->lokasi_konseling }}">

                                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow transition">Simpan & Selesai</button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- SCRIPT: HANYA BERJALAN DI MODE KERJA (JIKA ADA FORM) --}}
    @if(!in_array($konseling->status_konseling, ['Selesai', 'Ditolak']))
    <script>
        function toggleFormAwal(val) {
            const formJadwal = document.getElementById('form_jadwal_awal');
            if(val === 'Dijadwalkan') {
                formJadwal.classList.remove('hidden');
                formJadwal.querySelectorAll('input').forEach(el => el.disabled = false);
            } else {
                formJadwal.classList.add('hidden');
                formJadwal.querySelectorAll('input').forEach(el => el.disabled = true);
            }
        }

        function toggleFormLanjut(val) {
            const formEdit = document.getElementById('form_edit_jadwal');
            const formHasil = document.getElementById('form_hasil');
            const inputHasil = document.getElementById('input_hasil');

            if(val === 'Selesai') {
                formEdit.classList.add('hidden');
                formHasil.classList.remove('hidden');
                formEdit.querySelectorAll('input').forEach(el => el.disabled = true);
                formHasil.querySelectorAll('input, textarea').forEach(el => el.disabled = false);
                inputHasil.required = true; 
            } else {
                formEdit.classList.remove('hidden');
                formHasil.classList.add('hidden');
                formEdit.querySelectorAll('input').forEach(el => el.disabled = false);
                formHasil.querySelectorAll('input, textarea').forEach(el => el.disabled = true);
                inputHasil.required = false;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const aksi = document.getElementById('aksi_lanjutan');
            if(aksi) toggleFormLanjut(aksi.value);
            const statusAwal = document.getElementById('status_awal');
            if(statusAwal) toggleFormAwal(statusAwal.value);
        });
    </script>
    @endif
</x-app-layout>