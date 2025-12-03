<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulir Pengajuan Konseling') }}
        </h2>
    </x-slot>

    {{-- BACKGROUND: Bersih, Putih/Abu Soft ala Website Kampus --}}
    <div class="min-h-screen bg-gray-50 pb-20">
        
        {{-- HERO HEADER: Hijau UBBG --}}
        <div class="bg-emerald-600 py-10">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-3xl font-bold text-white tracking-wide">Layanan Bimbingan Konseling</h1>
                <p class="mt-2 text-emerald-100 text-lg">Kami hadir untuk mendengar, memahami, dan membantu solusi terbaik untuk Anda.</p>
            </div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8">
            <form method="POST" action="{{ route('mahasiswa.pengajuan.store') }}" class="space-y-6">
                @csrf

                {{-- ========================================================== --}}
                {{-- BAGIAN A: DATA DIRI (Accordion Open) --}}
                {{-- ========================================================== --}}
                <div x-data="{ open: true }" class="bg-white rounded-lg shadow-md overflow-hidden border-t-4 border-emerald-500">
                    <button type="button" @click="open = !open" class="w-full flex justify-between items-center px-6 py-4 bg-white hover:bg-gray-50 focus:outline-none transition">
                        <div class="flex items-center gap-3">
                            <div class="bg-emerald-100 p-2 rounded-full text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Bagian A: Data Diri Mahasiswa</h3>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="open" x-transition class="px-6 pb-6 pt-2 border-t border-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Readonly Fields --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                                <input type="text" value="{{ $mahasiswa->user->name }}" readonly class="w-full bg-gray-100 border-gray-300 rounded-md text-gray-700 shadow-sm focus:ring-0">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">NIM</label>
                                <input type="text" value="{{ $mahasiswa->nim }}" readonly class="w-full bg-gray-100 border-gray-300 rounded-md text-gray-700 shadow-sm focus:ring-0">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Program Studi</label>
                                <input type="text" value="{{ $mahasiswa->prodi->nama_prodi ?? '-' }}" readonly class="w-full bg-gray-100 border-gray-300 rounded-md text-gray-700 shadow-sm focus:ring-0">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                                <input type="text" value="{{ $mahasiswa->email }}" readonly class="w-full bg-gray-100 border-gray-300 rounded-md text-gray-700 shadow-sm focus:ring-0">
                            </div>

                            {{-- Active Input: No HP --}}
                            <div class="md:col-span-2">
                                <label for="no_hp_mahasiswa" class="block text-sm font-bold text-gray-700 mb-1">No. HP / WhatsApp (Aktif) <span class="text-red-500">*</span></label>
                                <input type="text" name="no_hp_mahasiswa" id="no_hp_mahasiswa" 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                    value="{{ old('no_hp_mahasiswa', $mahasiswa->no_hp) }}" placeholder="Contoh: 081234567890">
                                <x-input-error :messages="$errors->get('no_hp_mahasiswa')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========================================================== --}}
                {{-- BAGIAN B: KLASIFIKASI MASALAH (Accordion Open) --}}
                {{-- ========================================================== --}}
                <div x-data="{ open: true }" class="bg-white rounded-lg shadow-md overflow-hidden border-t-4 border-emerald-500">
                    <button type="button" @click="open = !open" class="w-full flex justify-between items-center px-6 py-4 bg-white hover:bg-gray-50 focus:outline-none transition">
                        <div class="flex items-center gap-3">
                            <div class="bg-emerald-100 p-2 rounded-full text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Bagian B: Klasifikasi Masalah</h3>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" x-transition class="px-6 pb-6 pt-2 border-t border-gray-100">
                        {{-- Status Konseli --}}
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-3">Status Anda saat ini:</label>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-emerald-50 transition">
                                    <input type="radio" name="tipe_konseli" value="Konseli Baru (belum pernah)" 
                                        class="text-emerald-600 focus:ring-emerald-500 border-gray-300"
                                        {{ old('tipe_konseli') == 'Konseli Baru (belum pernah)' ? 'checked' : '' }}>
                                    <span class="ml-3 text-sm text-gray-700 font-medium">Konseli Baru <span class="text-xs text-gray-500 block font-normal">(Belum pernah konseling)</span></span>
                                </label>
                                <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-emerald-50 transition">
                                    <input type="radio" name="tipe_konseli" value="Konseli Lama (sudah pernah)" 
                                        class="text-emerald-600 focus:ring-emerald-500 border-gray-300"
                                        {{ old('tipe_konseli') == 'Konseli Lama (sudah pernah)' ? 'checked' : '' }}>
                                    <span class="ml-3 text-sm text-gray-700 font-medium">Konseli Lama <span class="text-xs text-gray-500 block font-normal">(Sudah pernah konseling)</span></span>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('tipe_konseli')" class="mt-2" />
                        </div>

                        {{-- Checkbox Biasa (No Hidden Stuff) --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Jenis Permasalahan (Boleh pilih lebih dari satu):</label>
                            @php $old_jenis = old('jenis_permasalahan', []); @endphp
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                @foreach(['Sosial', 'Belajar', 'Karir', 'Pribadi'] as $jenis)
                                <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-emerald-50 transition">
                                    <input type="checkbox" name="jenis_permasalahan[]" value="{{ $jenis }}" 
                                        class="rounded text-emerald-600 border-gray-300 focus:ring-emerald-500"
                                        {{ in_array($jenis, $old_jenis) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-700">{{ $jenis }}</span>
                                </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('jenis_permasalahan')" class="mt-2" />
                        </div>
                    </div>
                </div>

                {{-- ========================================================== --}}
                {{-- BAGIAN C: DETAIL MASALAH --}}
                {{-- ========================================================== --}}
                <div x-data="{ open: true }" class="bg-white rounded-lg shadow-md overflow-hidden border-t-4 border-emerald-500">
                    <button type="button" @click="open = !open" class="w-full flex justify-between items-center px-6 py-4 bg-white hover:bg-gray-50 focus:outline-none transition">
                        <div class="flex items-center gap-3">
                            <div class="bg-emerald-100 p-2 rounded-full text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Bagian C: Detail Cerita</h3>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" x-transition class="px-6 pb-6 pt-2 border-t border-gray-100">
                        <div class="space-y-4">
                            <div>
                                <label for="deskripsi_masalah" class="block text-sm font-bold text-gray-700 mb-2">Ceritakan kondisi Anda saat ini:</label>
                                <textarea name="deskripsi_masalah" id="deskripsi_masalah" rows="5" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                    placeholder="Apa yang sedang Anda rasakan?"
                                >{{ old('deskripsi_masalah') }}</textarea>
                                <x-input-error :messages="$errors->get('deskripsi_masalah')" class="mt-2" />
                            </div>
                            <div>
                                <label for="tujuan_konseling" class="block text-sm font-bold text-gray-700 mb-2">Harapan / Tujuan Konseling:</label>
                                <textarea name="tujuan_konseling" id="tujuan_konseling" rows="3" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                    placeholder="Apa yang Anda harapkan setelah sesi ini?"
                                >{{ old('tujuan_konseling') }}</textarea>
                                <x-input-error :messages="$errors->get('tujuan_konseling')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========================================================== --}}
                {{-- BAGIAN D: ASESMEN K10 --}}
                {{-- ========================================================== --}}
                <div x-data="{ open: true }" class="bg-white rounded-lg shadow-md overflow-hidden border-t-4 border-emerald-500">
                    <button type="button" @click="open = !open" class="w-full flex justify-between items-center px-6 py-4 bg-white hover:bg-gray-50 focus:outline-none transition">
                        <div class="flex items-center gap-3">
                            <div class="bg-emerald-100 p-2 rounded-full text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Bagian D: Asesmen K10</h3>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" x-transition class="px-6 pb-6 pt-2 border-t border-gray-100">
                        <div class="bg-blue-50 text-blue-800 p-3 rounded mb-4 text-sm">
                            Pilihlah jawaban yang paling sesuai dengan kondisi Anda dalam <strong>satu bulan terakhir</strong>.
                        </div>

                        @php
                            $k10_questions = [
                                1 => 'Seberapa sering Anda merasa lelah tanpa sebab yang jelas?',
                                2 => 'Seberapa sering Anda merasa cemas atau khawatir?',
                                3 => 'Seberapa sering Anda merasa sangat gugup sehingga tidak ada yang dapat menenangkan Anda?',
                                4 => 'Seberapa sering Anda merasa putus asa?',
                                5 => 'Seberapa sering Anda merasa gelisah atau tidak tenang?',
                                6 => 'Seberapa sering Anda merasa sangat gelisah sehingga tidak dapat duduk tenang?',
                                7 => 'Seberapa sering Anda merasa tertekan?',
                                8 => 'Seberapa sering Anda merasa perlu berusaha keras untuk melakukan segala hal?',
                                9 => 'Seberapa sering Anda merasa sangat sedih sehingga tidak ada yang dapat menghibur Anda?',
                                10 => 'Seberapa sering Anda merasa tidak berharga atau tidak berarti?',
                            ];
                            $k10_options = ['Tidak pernah', 'Jarang', 'Kadang-kadang', 'Hampir Sepanjang waktu', 'Sepanjang waktu'];
                            $old_k10 = old('asesmen_k10', []);
                        @endphp

                        <div class="space-y-6">
                            @foreach ($k10_questions as $index => $question)
                            <div class="border-b border-gray-100 pb-4 last:border-0">
                                <p class="font-semibold text-gray-800 mb-2">{{ $index }}. {{ $question }}</p>
                                <div class="grid grid-cols-2 md:grid-cols-5 gap-2">
                                     @foreach ($k10_options as $option)
                                        <label class="flex flex-col items-center justify-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition h-full text-center">
                                            <input type="radio" name="asesmen_k10[{{ $index - 1 }}]" value="{{ $option }}" 
                                                class="mb-2 text-emerald-600 focus:ring-emerald-500"
                                                {{ (isset($old_k10[$index - 1]) && $old_k10[$index - 1] == $option) ? 'checked' : '' }}>
                                            <span class="text-xs text-gray-600">{{ $option }}</span>
                                        </label>
                                     @endforeach
                                </div>
                                <x-input-error :messages="$errors->get('asesmen_k10.' . ($index - 1))" class="mt-1" />
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- ========================================================== --}}
                {{-- BAGIAN E: PERSETUJUAN --}}
                {{-- ========================================================== --}}
                <div class="bg-yellow-50 rounded-lg shadow border border-yellow-200 p-6">
                    <h3 class="font-bold text-yellow-800 mb-3 text-lg">Persetujuan Layanan (Informed Consent)</h3>
                    <ul class="list-disc list-inside text-sm text-yellow-900 mb-4 space-y-1">
                        <li>Saya bersedia terlibat aktif dalam proses konseling.</li>
                        <li>Identitas dan informasi saya dijamin <strong>RAHASIA</strong>.</li>
                    </ul>
                    <label class="flex items-start">
                        <input id="persetujuan" type="checkbox" name="persetujuan" value="1" 
                            class="mt-1 rounded text-emerald-600 border-gray-300 focus:ring-emerald-500">
                        <span class="ml-2 text-sm text-gray-800">
                            Saya telah membaca dan menyetujui pernyataan di atas.
                        </span>
                    </label>
                    <x-input-error :messages="$errors->get('persetujuan')" class="mt-2" />
                </div>

                {{-- BUTTONS --}}
                <div class="flex justify-between pt-4 pb-12">
                    <a href="{{ route('mahasiswa.riwayat.index') }}" class="px-6 py-2 bg-white border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition shadow-sm">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-2 bg-emerald-600 border border-transparent rounded-md font-bold text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-lg transform hover:-translate-y-0.5 transition">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>