<x-app-layout>
    {{-- INJECT ALPINE.JS & FONTS --}}
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-header { background: linear-gradient(135deg, #047857 0%, #0d9488 100%); }
    </style>

    {{-- HEADER --}}
    <div class="glass-header pb-24 pt-12 px-4 sm:px-8 shadow-lg relative overflow-hidden">
        <svg class="absolute top-0 right-0 w-64 h-64 text-white opacity-5 transform translate-x-10 -translate-y-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/></svg>
        <div class="max-w-4xl mx-auto relative z-10 text-white text-center">
            <h2 class="font-extrabold text-3xl md:text-4xl tracking-tight leading-tight mb-2">
                Evaluasi Layanan Konseling
            </h2>
            <p class="text-emerald-100 text-sm md:text-base font-medium opacity-90">
                Tiket #{{ $konseling->id_konseling }} • Bantu kami meningkatkan kualitas layanan dengan mengisi survei ini.
            </p>
        </div>
    </div>

    {{-- FORM CONTENT --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 pb-20 relative z-20">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <form action="{{ route('mahasiswa.survei.store', $konseling->id_konseling) }}" method="POST" class="p-6 md:p-10 space-y-8">
                @csrf

                {{-- Alert Info --}}
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Penting:</strong> Setelah mengisi survei ini, Anda akan dapat mengunduh <strong>Surat Bukti/Evaluasi Konseling</strong> sebagai dokumen resmi.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Pertanyaan 1 --}}
                <div>
                    <label class="block text-gray-800 font-bold mb-2">
                        1. Pengetahuan / pemahaman baru apa yang Anda peroleh setelah mengikuti layanan bimbingan konseling?
                    </label>
                    <textarea name="pemahaman_baru" rows="3" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition" placeholder="Ceritakan pemahaman baru yang Anda dapatkan..." required>{{ old('pemahaman_baru') }}</textarea>
                    <x-input-error :messages="$errors->get('pemahaman_baru')" class="mt-2" />
                </div>

                {{-- Pertanyaan 2 --}}
                <div>
                    <label class="block text-gray-800 font-bold mb-2">
                        2. Bagaimana perasaan Anda setelah mengikuti layanan bimbingan konseling?
                    </label>
                    <textarea name="perasaan" rows="3" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition" placeholder="Gambarkan perasaan Anda (misal: lebih lega, tenang, dll)..." required>{{ old('perasaan') }}</textarea>
                    <x-input-error :messages="$errors->get('perasaan')" class="mt-2" />
                </div>

                {{-- Pertanyaan 3 --}}
                <div>
                    <label class="block text-gray-800 font-bold mb-2">
                        3. Jelaskan tindakan yang akan Anda lakukan setelah mengikuti layanan bimbingan konseling?
                    </label>
                    <textarea name="tindakan" rows="3" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition" placeholder="Rencana tindakan konkret Anda kedepan..." required>{{ old('tindakan') }}</textarea>
                    <x-input-error :messages="$errors->get('tindakan')" class="mt-2" />
                </div>

                {{-- Pertanyaan 4 --}}
                <div>
                    <label class="block text-gray-800 font-bold mb-2">
                        4. Jelaskan tanggung jawab Anda setelah mengikuti layanan bimbingan konseling?
                    </label>
                    <textarea name="tanggung_jawab" rows="3" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition" placeholder="Komitmen tanggung jawab yang akan Anda ambil..." required>{{ old('tanggung_jawab') }}</textarea>
                    <x-input-error :messages="$errors->get('tanggung_jawab')" class="mt-2" />
                </div>

                <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
                    <a href="{{ route('mahasiswa.riwayat.show', $konseling->id_konseling) }}" class="text-gray-500 font-medium hover:text-gray-700">
                        Batal
                    </a>
                    <button type="submit" class="bg-emerald-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-emerald-700 shadow-lg hover:shadow-emerald-500/30 transition transform hover:-translate-y-1">
                        Simpan & Unduh Bukti
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>