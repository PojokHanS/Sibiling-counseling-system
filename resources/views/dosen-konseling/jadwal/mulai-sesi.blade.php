<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mulai Sesi Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- INFO MAHASISWA --}}
                    <div class="mb-6 bg-indigo-50 border-l-4 border-indigo-500 p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-indigo-900">Sesi Konseling Aktif</h3>
                                <p class="text-sm text-indigo-700 mt-1">
                                    Mahasiswa: <strong>{{ $jadwal->konseling->mahasiswa->user->name }}</strong><br>
                                    NIM: {{ $jadwal->konseling->mahasiswa->nim }}<br>
                                    Topik: {{ $jadwal->konseling->jenis_permasalahan ? implode(', ', $jadwal->konseling->jenis_permasalahan) : 'Umum' }}
                                </p>
                            </div>
                            <span class="px-3 py-1 bg-white text-indigo-600 rounded-full text-xs font-bold border border-indigo-200">
                                {{ \Carbon\Carbon::now()->format('d M Y') }}
                            </span>
                        </div>
                    </div>

                    {{-- ERROR MESSAGE DISPLAY (Agar tidak cuma 'mutar' kalau ada error) --}}
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('dosen-konseling.jadwal.simpanSesi', $jadwal->id_jadwal) }}" method="POST">
                        @csrf
                        
                        {{-- 1. CATATAN / HASIL KONSELING --}}
                        <div class="mb-6">
                            <x-input-label for="hasil_konseling" :value="__('Catatan Hasil Konseling (Diagnosis / Observasi)')" />
                            <textarea id="hasil_konseling" name="hasil_konseling" rows="6" 
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                placeholder="Tuliskan diagnosis, poin-poin diskusi, dan hasil observasi sesi ini..."
                                required>{{ old('hasil_konseling') }}</textarea>
                            <x-input-error :messages="$errors->get('hasil_konseling')" class="mt-2" />
                        </div>

                        {{-- 2. REKOMENDASI / TINDAK LANJUT --}}
                        <div class="mb-6">
                            <x-input-label for="rekomendasi" :value="__('Rekomendasi / Tindak Lanjut')" />
                            <textarea id="rekomendasi" name="rekomendasi" rows="4" 
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                placeholder="Saran untuk mahasiswa, tugas rumah, atau rencana pertemuan berikutnya...">{{ old('rekomendasi') }}</textarea>
                            <x-input-error :messages="$errors->get('rekomendasi')" class="mt-2" />
                        </div>

                        {{-- 3. STATUS AKHIR SESI --}}
                        <div class="mb-6">
                            <x-input-label for="status_akhir" :value="__('Status Akhir Kasus')" />
                            <select id="status_akhir" name="status_akhir" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="" disabled selected>-- Pilih Status Akhir --</option>
                                <option value="Butuh Sesi Lanjutan" {{ old('status_akhir') == 'Butuh Sesi Lanjutan' ? 'selected' : '' }}>Butuh Sesi Lanjutan (Jadwalkan Lagi Nanti)</option>
                                <option value="Selesai" {{ old('status_akhir') == 'Selesai' ? 'selected' : '' }}>Selesai (Kasus Ditutup)</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">*Jika "Selesai", kasus ini akan ditutup. Jika "Butuh Sesi Lanjutan", Anda bisa membuat jadwal baru nanti.</p>
                            <x-input-error :messages="$errors->get('status_akhir')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-6 border-t gap-3">
                            <a href="{{ route('dosen-konseling.jadwal.index') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan Hasil Sesi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>