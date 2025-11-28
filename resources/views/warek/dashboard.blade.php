<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Executive Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- WELCOME SECTION --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-2xl font-extrabold text-gray-900">
                        Selamat Datang, Ibu Wakil Rektor!
                    </h3>
                    <p class="mt-2 text-gray-500 max-w-2xl">
                        Berikut adalah ringkasan aktivitas konseling dosen & staf akademik. Anda memiliki <span class="font-bold text-indigo-600">{{ $perluTindakan }} pengajuan baru</span> yang menunggu verifikasi.
                    </p>
                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('warek.konseling.index') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-md transition flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Buka Inbox
                        </a>
                        <a href="{{ route('warek.konseling.riwayat') }}" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 text-sm font-bold rounded-xl transition flex items-center">
                            Lihat Arsip
                        </a>
                    </div>
                </div>
                {{-- Hiasan Background --}}
                <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-indigo-50 to-transparent pointer-events-none"></div>
                <svg class="absolute right-10 top-10 w-32 h-32 text-indigo-100 opacity-50" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/></svg>
            </div>

            {{-- STATS GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                {{-- Card 1 --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-bold text-gray-400 uppercase">Menunggu Verifikasi</h4>
                        <span class="p-2 bg-yellow-50 text-yellow-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $perluTindakan }}</p>
                    <p class="text-xs text-gray-500 mt-1">Perlu tindakan segera</p>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-bold text-gray-400 uppercase">Jadwal Aktif</h4>
                        <span class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $jadwalAktif }}</p>
                    <p class="text-xs text-gray-500 mt-1">Sesi mendatang</p>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-bold text-gray-400 uppercase">Selesai (Bulan Ini)</h4>
                        <span class="p-2 bg-green-50 text-green-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $selesaiBulanIni }}</p>
                    <p class="text-xs text-gray-500 mt-1">Kasus ditangani</p>
                </div>

                {{-- Card 4 --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-bold text-gray-400 uppercase">Total Masuk</h4>
                        <span class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </span>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $totalMasuk }}</p>
                    <p class="text-xs text-gray-500 mt-1">Akumulasi semua waktu</p>
                </div>
            </div>

            {{-- RECENT ACTIVITY --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-800">Aktivitas Terbaru</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($terbaru as $item)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                            <div class="flex items-center gap-4">
                                {{-- Status Icon --}}
                                <div class="flex-shrink-0">
                                    @if($item->status_konseling == 'Menunggu Verifikasi')
                                        <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                    @elseif($item->status_konseling == 'Selesai')
                                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $item->user->name ?? 'Dosen' }}</p>
                                    <p class="text-xs text-gray-500">Status: {{ $item->status_konseling }} &bull; {{ $item->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('warek.konseling.show', $item->id_konseling_dosen) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Lihat</a>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center text-gray-400 text-sm">
                            Belum ada aktivitas tercatat.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>