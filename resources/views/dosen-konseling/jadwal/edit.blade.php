<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ubah Jadwal Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Alert Info Mahasiswa --}}
                    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Mengedit jadwal untuk: <strong>{{ $jadwal->konseling->mahasiswa->user->name }}</strong>.
                                    Pastikan perubahan ini sudah dikomunikasikan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('dosen-konseling.jadwal.update', $jadwal->id_jadwal) }}" method="POST" x-data="{ metode: '{{ old('metode_konseling', $jadwal->metode_konseling) }}' }">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Tanggal --}}
                            <div>
                                <x-input-label for="tanggal_konseling" :value="__('Tanggal Konseling')" />
                                {{-- Ambil tgl_sesi dari database --}}
                                <x-text-input id="tanggal_konseling" class="block mt-1 w-full" type="date" name="tanggal_konseling" 
                                    :value="old('tanggal_konseling', \Carbon\Carbon::parse($jadwal->tgl_sesi)->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('tanggal_konseling')" class="mt-2" />
                            </div>

                            {{-- Waktu Mulai --}}
                            <div>
                                <x-input-label for="waktu_mulai" :value="__('Waktu Mulai')" />
                                <x-text-input id="waktu_mulai" class="block mt-1 w-full" type="time" name="waktu_mulai" 
                                    :value="old('waktu_mulai', \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i'))" required />
                                <x-input-error :messages="$errors->get('waktu_mulai')" class="mt-2" />
                            </div>

                            {{-- Waktu Selesai --}}
                            <div>
                                <x-input-label for="waktu_selesai" :value="__('Waktu Selesai')" />
                                <x-text-input id="waktu_selesai" class="block mt-1 w-full" type="time" name="waktu_selesai" 
                                    :value="old('waktu_selesai', \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i'))" required />
                                <x-input-error :messages="$errors->get('waktu_selesai')" class="mt-2" />
                            </div>

                            {{-- Metode --}}
                            <div>
                                <x-input-label for="metode_konseling" :value="__('Metode Konseling')" />
                                <select id="metode_konseling" name="metode_konseling" x-model="metode" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="Offline">Offline (Tatap Muka)</option>
                                    <option value="Online">Online</option>
                                </select>
                                <x-input-error :messages="$errors->get('metode_konseling')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Lokasi (Muncul jika Offline) --}}
                        <div class="mt-6" x-show="metode === 'Offline'" x-transition>
                            <x-input-label for="lokasi" :value="__('Lokasi/Ruangan (Wajib diisi jika Offline)')" />
                            <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" 
                                :value="old('lokasi', $jadwal->lokasi)" placeholder="Contoh: Ruang Konseling Gedung A" />
                            <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-6 border-t gap-3">
                            <a href="{{ route('dosen-konseling.jadwal.index') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>