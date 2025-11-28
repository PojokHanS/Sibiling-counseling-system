<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pengajuan Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('dosen.curhat.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="tipe_konseli" :value="__('Identitas Pengaju')" />
                            <select id="tipe_konseli" name="tipe_konseli" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="Dosen">Dosen</option>
                                <option value="Tendik">Tenaga Kependidikan (Staf)</option>
                            </select>
                            <x-input-error :messages="$errors->get('tipe_konseli')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="deskripsi_masalah" :value="__('Deskripsi Permasalahan')" />
                            <p class="text-sm text-gray-500 mb-2">Ceritakan secara singkat apa yang sedang Anda hadapi/rasakan.</p>
                            <textarea id="deskripsi_masalah" name="deskripsi_masalah" rows="5" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('deskripsi_masalah') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi_masalah')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="tujuan_konseling" :value="__('Harapan / Tujuan Konseling')" />
                            <p class="text-sm text-gray-500 mb-2">Apa yang Anda harapkan dari sesi konseling ini?</p>
                            <textarea id="tujuan_konseling" name="tujuan_konseling" rows="3" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('tujuan_konseling') }}</textarea>
                            <x-input-error :messages="$errors->get('tujuan_konseling')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('dosen.curhat.index') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                            <x-primary-button>
                                {{ __('Kirim Pengajuan') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>