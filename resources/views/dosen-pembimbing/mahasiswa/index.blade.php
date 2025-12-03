<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hidden">
            {{ __('Mahasiswa Bimbingan Saya') }}
        </h2>
    </x-slot>

    {{-- INJECT STYLE WELCOME (EMERALD THEME) --}}
    <style>
        @import url('https://fonts.bunny.net/css?family=inter:400,500,600,700,800');
        :root {
            --primary-green: #2E8B57;
            --primary-light: #3CB371;
            --primary-dark: #23865F;
            --bg-cream: #FFFCF9;
        }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-cream); }
        
        .bg-shapes { position: fixed; inset: 0; z-index: 0; overflow: hidden; pointer-events: none; }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border-radius: 1rem;
        }
        
        /* Header Table Gradient Hijau */
        .emerald-header {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
        }
        
        /* Tombol Aksi */
        .btn-emerald {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
            color: white; transition: all 0.3s;
        }
        .btn-emerald:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(46, 139, 87, 0.3); }
    </style>

    {{-- BACKGROUND ANIMASI --}}
    <div class="bg-shapes">
        <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-gradient-to-br from-emerald-100 to-transparent rounded-bl-full opacity-40"></div>
        <div class="absolute bottom-0 left-0 w-1/3 h-1/3 bg-gradient-to-tr from-green-100 to-transparent rounded-tr-full opacity-40"></div>
    </div>

    <div class="py-12 relative z-10 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- SEARCH & FILTER BAR (Glassmorphism) --}}
            <div class="glass-card p-5 mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-emerald-100 rounded-lg text-emerald-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Data Mahasiswa Bimbingan</h3>
                        <p class="text-xs text-gray-500">Total Mahasiswa: <span class="font-bold text-emerald-600">{{ $mahasiswaBimbingan->total() }}</span></p>
                    </div>
                </div>
                
                <form method="GET" action="{{ route('dosen-pembimbing.mahasiswa') }}" class="w-full md:w-1/2 flex gap-2">
                    <div class="relative w-full">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm"
                            placeholder="Cari Nama / NIM...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                    <button type="submit" class="px-5 py-2 btn-emerald rounded-lg font-medium text-sm shadow-sm">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('dosen-pembimbing.mahasiswa') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm flex items-center">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- TABLE CARD --}}
            <div class="glass-card overflow-hidden">
                <div class="emerald-header px-6 py-4">
                    <h3 class="text-white font-bold text-sm uppercase tracking-wider flex items-center gap-2">
                        Daftar Anak Wali
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Identitas Mahasiswa</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Akademik</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kontak</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse ($mahasiswaBimbingan as $mhs)
                                <tr class="hover:bg-emerald-50/30 transition duration-150 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover border-2 border-emerald-100 group-hover:border-emerald-300 transition" 
                                                     src="https://ui-avatars.com/api/?name={{ urlencode($mhs->user->name) }}&background=2E8B57&color=fff&size=128" 
                                                     alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-800">{{ $mhs->user->name }}</div>
                                                <div class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full inline-block mt-1 border border-gray-200">
                                                    {{ $mhs->nim }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-700 font-medium">{{ $mhs->prodi->nama_prodi ?? '-' }}</div>
                                        <div class="text-xs text-emerald-600 font-medium mt-0.5">Angkatan {{ $mhs->angkatan ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col gap-1">
                                            @if($mhs->no_hp)
                                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $mhs->no_hp) }}" target="_blank" class="text-xs flex items-center text-emerald-700 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 px-2 py-1 rounded-md w-fit transition">
                                                    <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.628 1.213 2.827c.149.199 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                                    {{ $mhs->no_hp }}
                                                </a>
                                            @else
                                                <span class="text-xs text-gray-400 italic">No HP tidak ada</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="{{ route('dosen-pembimbing.rekomendasi.create', $mhs->nim) }}" 
                                           class="inline-flex items-center px-4 py-1.5 border border-emerald-600 rounded-full text-xs font-bold text-emerald-700 hover:bg-emerald-50 hover:text-emerald-800 transition shadow-sm">
                                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Rekomendasi
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="bg-gray-100 p-4 rounded-full mb-3">
                                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                            </div>
                                            <p class="text-gray-500 font-medium">Belum ada data mahasiswa bimbingan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                @if($mahasiswaBimbingan->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        {{ $mahasiswaBimbingan->withQueryString()->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>