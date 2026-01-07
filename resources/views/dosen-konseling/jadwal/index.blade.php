<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Konseling Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- FIX: Gunakan variabel $jadwal (bukan $jadwalKonseling) --}}
                    @if($jadwal->isEmpty())
                        <div class="text-center py-10">
                            <p class="text-gray-500">Belum ada jadwal konseling yang aktif.</p>
                            <div class="mt-4">
                                <a href="{{ route('dosen-konseling.pengajuan.index') }}" class="text-indigo-600 hover:underline">
                                    Cek Pengajuan Masuk &rarr;
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi / Link</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    {{-- FIX: Loop menggunakan $jadwal --}}
                                    @foreach($jadwal as $sesi)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-gray-900">
                                                    {{ \Carbon\Carbon::parse($sesi->tgl_sesi)->translatedFormat('l, d M Y') }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }} - 
                                                    {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $sesi->konseling->mahasiswa->user->name ?? 'Mahasiswa' }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $sesi->konseling->mahasiswa->nim ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $sesi->metode_konseling == 'Online' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                    {{ $sesi->metode_konseling }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($sesi->metode_konseling == 'Online')
                                                    {{-- Link meeting bisa ditambahkan jika ada kolomnya, untuk sekarang pakai placeholder atau lokasi --}}
                                                    <span class="text-blue-600">Online Meeting</span>
                                                @else
                                                    {{ $sesi->lokasi }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center gap-3">
                                                {{-- Tombol Mulai --}}
                                                <a href="{{ route('dosen-konseling.jadwal.mulaiSesi', $sesi->id_jadwal) }}" 
                                                   class="text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-1.5 rounded-md text-xs transition">
                                                    Mulai Sesi
                                                </a>

                                                {{-- Tombol Edit --}}
                                                <a href="{{ route('dosen-konseling.jadwal.edit', $sesi->id_jadwal) }}" 
                                                   class="text-gray-500 hover:text-amber-600 transition"
                                                   title="Ubah Jadwal">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- Pagination jika diperlukan (tapi karena pakai get() di controller, ini manual dulu atau hapus links() kalau bukan paginate) --}}
                        {{-- <div class="mt-4">{{ $jadwal->links() }}</div> --}}
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>