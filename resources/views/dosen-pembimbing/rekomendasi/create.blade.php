<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hidden">
            {{ __('Buat Rekomendasi Konseling') }}
        </h2>
    </x-slot>

    <style>
        @import url('https://fonts.bunny.net/css?family=inter:400,500,600,700,800');
        :root { --primary-green: #2E8B57; --primary-dark: #23865F; --bg-cream: #FFFCF9; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-cream); }
        .bg-shapes { position: fixed; inset: 0; z-index: 0; overflow: hidden; pointer-events: none; }
        .glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.6); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); border-radius: 1rem; }
        .emerald-header { background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%); }
    </style>

    <div class="bg-shapes">
        <div class="absolute top-0 left-0 w-1/3 h-1/3 bg-gradient-to-br from-green-100 to-transparent rounded-br-full opacity-40"></div>
    </div>

    <div class="py-12 relative z-10 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="glass-card overflow-hidden">
                {{-- CARD HEADER --}}
                <div class="emerald-header px-8 py-6 flex items-center gap-4">
                    <div class="bg-white/20 p-3 rounded-full backdrop-blur-sm">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Formulir Rekomendasi Konseling</h2>
                        <p class="text-emerald-100 text-sm">Ajukan rekomendasi untuk mahasiswa bimbingan Anda agar mendapatkan layanan konseling.</p>
                    </div>
                </div>

                <div class="p-8">
                    <form method="POST" action="{{ route('dosen-pembimbing.rekomendasi.store') }}" class="space-y-8">
                        @csrf
                        <input type="hidden" name="nim_mahasiswa" value="{{ $mahasiswa->nim }}">

                        {{-- INFO MAHASISWA --}}
                        <div class="bg-emerald-50 rounded-xl p-6 border border-emerald-100 flex items-center gap-4">
                            <img class="h-16 w-16 rounded-full object-cover border-2 border-emerald-200" src="https://ui-avatars.com/api/?name={{ urlencode($mahasiswa->user->name) }}&background=2E8B57&color=fff" alt="">
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg">{{ $mahasiswa->user->name }}</h3>
                                <p class="text-sm text-gray-600">NIM: <span class="font-mono font-bold">{{ $mahasiswa->nim }}</span> • Prodi: {{ $mahasiswa->prodi->nama_prodi ?? '-' }}</p>
                            </div>
                        </div>

                        {{-- FORM INPUTS --}}
                        <div class="space-y-6">
                            {{-- Aspek --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Aspek Permasalahan (Pilih satu atau lebih)</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    @foreach(['Akademik', 'Pribadi', 'Sosial', 'Karir'] as $aspek)
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="aspek_permasalahan[]" value="{{ $aspek }}" class="peer sr-only">
                                        <div class="rounded-lg border border-gray-300 p-3 text-center hover:bg-gray-50 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 transition">
                                            <span class="text-sm font-medium">{{ $aspek }}</span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                                <x-input-error :messages="$errors->get('aspek_permasalahan')" class="mt-2" />
                            </div>

                            {{-- Deskripsi --}}
                            <div>
                                <label for="deskripsi_masalah" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Masalah / Pengamatan Awal</label>
                                <textarea name="deskripsi_masalah" id="deskripsi_masalah" rows="5" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition" placeholder="Jelaskan secara singkat apa yang Anda amati dari mahasiswa ini..."></textarea>
                                <x-input-error :messages="$errors->get('deskripsi_masalah')" class="mt-2" />
                            </div>

                            {{-- Harapan --}}
                            <div>
                                <label for="harapan_pa" class="block text-sm font-bold text-gray-700 mb-2">Harapan Anda sebagai Pembimbing</label>
                                <textarea name="harapan_pa" id="harapan_pa" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition" placeholder="Apa hasil yang Anda harapkan setelah mahasiswa ini dikonseling?"></textarea>
                                <x-input-error :messages="$errors->get('harapan_pa')" class="mt-2" />
                            </div>
                        </div>

                        {{-- TOMBOL AKSI --}}
                        <div class="flex justify-end items-center gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('dosen-pembimbing.mahasiswa') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-2.5 bg-gradient-to-r from-emerald-600 to-green-600 text-white rounded-lg font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition transform">
                                Kirim Rekomendasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>