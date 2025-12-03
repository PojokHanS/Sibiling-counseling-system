<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hidden">
            {{ __('Daftar Rekomendasi Konseling') }}
        </h2>
    </x-slot>

    {{-- THEME STYLE --}}
    <style>
        @import url('https://fonts.bunny.net/css?family=inter:400,500,600,700,800');
        :root { --primary-green: #2E8B57; --primary-dark: #23865F; --bg-cream: #FFFCF9; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-cream); }
        .bg-shapes { position: fixed; inset: 0; z-index: 0; overflow: hidden; pointer-events: none; }
        .glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.6); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); border-radius: 1rem; }
        .emerald-header { background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%); }
    </style>

    <div class="bg-shapes">
        <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-gradient-to-br from-emerald-100 to-transparent rounded-bl-full opacity-40"></div>
        <div class="absolute bottom-0 left-0 w-1/3 h-1/3 bg-gradient-to-tr from-green-100 to-transparent rounded-tr-full opacity-40"></div>
    </div>

    <div class="py-12 relative z-10 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- HEADER SECTION --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-emerald-100 rounded-xl text-emerald-700">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Daftar Rekomendasi</h1>
                        <p class="text-sm text-gray-500">Kelola dan pantau status rekomendasi konseling yang Anda ajukan.</p>
                    </div>
                </div>
                
                <a href="{{ route('dosen-pembimbing.mahasiswa') }}" class="px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-green-600 text-white rounded-lg font-bold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Buat Rekomendasi Baru
                </a>
            </div>

            {{-- TABLE CARD --}}
            <div class="glass-card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Ajuan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Permasalahan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse ($daftarRekomendasi as $item)
                                <tr class="hover:bg-emerald-50/30 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover border border-emerald-100" 
                                                     src="https://ui-avatars.com/api/?name={{ urlencode($item->mahasiswa->user->name) }}&background=2E8B57&color=fff" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-800">{{ $item->mahasiswa->user->name }}</div>
                                                <div class="text-xs text-gray-500 font-mono">{{ $item->nim_mahasiswa }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-700">{{ $item->tgl_pengajuan->translatedFormat('d F Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusClass = match($item->status_konseling) {
                                                'Menunggu Kelengkapan Mahasiswa' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                'Menunggu Verifikasi' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'Dijadwalkan' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                                'Selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                                'Ditolak' => 'bg-red-100 text-red-800 border-red-200',
                                                default => 'bg-gray-100 text-gray-600'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $statusClass }}">
                                            {{ $item->status_konseling }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-600 truncate max-w-xs" title="{{ $item->permasalahan }}">
                                            {{ $item->permasalahan }}
                                        </p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p class="mt-2 text-sm font-medium">Belum ada rekomendasi yang diajukan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($daftarRekomendasi->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        {{ $daftarRekomendasi->withQueryString()->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>