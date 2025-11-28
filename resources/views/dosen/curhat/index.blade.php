<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Layanan Konseling Dosen & Staf') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-700">Riwayat & Status Pengajuan</h3>
                <a href="{{ route('dosen.curhat.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                    + Ajukan Konseling Baru
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">Berhasil!</strong> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if($riwayat->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pengajuan</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai ajukan konseling jika Anda membutuhkan bantuan.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Topik Masalah</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal & Lokasi</th> <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan Warek</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($riwayat as $item)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                {{ $item->created_at->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                                {{ Str::limit($item->deskripsi_masalah, 40) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusClass = match($item->status_konseling) {
                                                        'Menunggu Verifikasi' => 'bg-yellow-100 text-yellow-800',
                                                        'Dijadwalkan' => 'bg-blue-100 text-blue-800',
                                                        'Selesai' => 'bg-green-100 text-green-800',
                                                        'Ditolak' => 'bg-red-100 text-red-800',
                                                        default => 'bg-gray-100 text-gray-800'
                                                    };
                                                @endphp
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $statusClass }}">
                                                    {{ $item->status_konseling }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-700">
                                                @if($item->status_konseling === 'Dijadwalkan' && $item->jadwal_konseling)
                                                    <div class="flex flex-col">
                                                        <span class="font-bold text-blue-600">
                                                            {{ \Carbon\Carbon::parse($item->jadwal_konseling)->format('d M Y, H:i') }} WIB
                                                        </span>
                                                        <span class="text-xs text-gray-500 flex items-center mt-1">
                                                            📍 {{ $item->lokasi_konseling }}
                                                        </span>
                                                    </div>
                                                @elseif($item->status_konseling === 'Selesai')
                                                    <span class="text-green-600 text-xs">Sesi Selesai</span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 italic">
                                                "{{ $item->catatan_warek ?? 'Belum ada respon' }}"
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $riwayat->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>