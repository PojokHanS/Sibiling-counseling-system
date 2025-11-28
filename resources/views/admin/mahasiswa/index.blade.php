<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Data Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER TOOLS --}}
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                
                {{-- Info Total --}}
                <div class="text-sm text-gray-500 font-medium">
                    Total Mahasiswa: <span class="font-bold text-indigo-600">{{ $mahasiswa->total() }}</span>
                </div>
                
                {{-- Search Bar --}}
                <form method="GET" action="{{ route('admin.mahasiswa.index') }}" class="w-full md:w-1/2 flex gap-2">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Cari Nama, NIM, atau Email..." 
                            class="pl-10 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition text-sm font-bold">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.mahasiswa.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition text-sm font-bold border border-gray-300">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- TABEL DATA --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Program Studi</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Angkatan</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($mahasiswa as $mhs)
                                <tr class="hover:bg-gray-50 transition">
                                    {{-- Kolom Mahasiswa --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold">
                                                    {{ strtoupper(substr($mhs->nm_mhs, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900">{{ $mhs->nm_mhs }}</div>
                                                <div class="text-xs text-gray-500 font-mono">NIM: {{ $mhs->nim }}</div>
                                                <div class="text-xs text-gray-400">{{ $mhs->email ?? 'Email belum diisi' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    {{-- Kolom Prodi (FIXED) --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- Tampilkan nama prodi dari relasi, kalau kosong tampilkan kode aslinya --}}
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">
                                            {{ $mhs->prodi->nama_prodi ?? ($mhs->id_prodi . ' (Kode)') }}
                                        </span>
                                    </td>

                                    {{-- Kolom Angkatan --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $mhs->angkatan ?? '-' }}
                                    </td>

                                    {{-- Kolom Aksi --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        {{-- Tombol Lihat --}}
                                        <a href="{{ route('admin.mahasiswa.show', $mhs->nim) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-bold mr-3 border border-indigo-200 px-3 py-1 rounded hover:bg-indigo-50 transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Lihat
                                        </a>
                                        {{-- Tombol Edit (Opsional jika dibutuhkan) --}}
                                        {{-- <a href="{{ route('admin.mahasiswa.edit', $mhs->nim) }}" class="text-gray-400 hover:text-gray-600">Edit</a> --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                            <p class="font-medium">Data mahasiswa tidak ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 bg-white border-t border-gray-100">
                    {{ $mahasiswa->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>