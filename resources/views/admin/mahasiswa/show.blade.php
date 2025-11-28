<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Biodata Lengkap Mahasiswa') }}
            </h2>
            <a href="{{ route('admin.mahasiswa.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- SECTION 1: HEADER & STATUS --}}
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col md:flex-row items-start gap-6">
                {{-- Foto / Avatar Dummy --}}
                <div class="flex-shrink-0">
                    <div class="w-32 h-32 rounded-xl bg-gray-100 flex items-center justify-center border-4 border-white shadow-sm overflow-hidden">
                        @if($mahasiswa->jk == 'P')
                            <svg class="w-20 h-20 text-pink-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        @else
                            <svg class="w-20 h-20 text-blue-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        @endif
                    </div>
                </div>
                
                {{-- Nama & Info Utama --}}
                <div class="flex-1 w-full">
                    <div class="flex flex-col md:flex-row justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $mahasiswa->nm_mhs }}</h1>
                            <p class="text-lg text-indigo-600 font-mono font-medium mt-1">{{ $mahasiswa->nim }}</p>
                        </div>
                        <span class="mt-2 md:mt-0 px-4 py-1 bg-green-100 text-green-800 text-sm font-bold rounded-full border border-green-200">
                            Status: {{ $mahasiswa->stat_mhs ?? 'Aktif' }}
                        </span>
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-gray-100 pt-4">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold">Program Studi</p>
                            <p class="font-semibold text-gray-800">{{ $mahasiswa->prodi->nama_prodi ?? $mahasiswa->id_prodi }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold">Angkatan</p>
                            <p class="font-semibold text-gray-800">{{ $mahasiswa->angkatan }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold">Dosen Wali (PA)</p>
                            <div class="font-semibold text-indigo-700">
                                {{-- PERBAIKAN: Cek apakah relasi ketemu --}}
                                @if($mahasiswa->dosenWali)
                                    {{ $mahasiswa->dosenWali->nm_dos }} 
                                    <br>
                                    <span class="text-xs text-gray-500 font-normal">
                                        NIDN: {{ $mahasiswa->dosenWali->nidn ?? '-' }} | Email: {{ $mahasiswa->dosenWali->email_dos }}
                                    </span>
                                @else
                                    <span class="text-red-500 italic">
                                        Data Dosen Tidak Ditemukan <br> 
                                        (ID Terdaftar: {{ $mahasiswa->id_dosen_wali ?? '-' }})
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: GRID DETAIL DATA --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- CARD 1: DATA PRIBADI --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden h-full">
                    <div class="bg-gray-50 px-6 py-3 border-b border-gray-200 flex items-center">
                        <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <h3 class="font-bold text-gray-700">Data Pribadi</h3>
                    </div>
                    <div class="p-6 space-y-4 text-sm">
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">Tempat Lahir</span>
                            <span class="col-span-2 font-medium text-gray-900">{{ $mahasiswa->tmpt_lahir ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">Tanggal Lahir</span>
                            <span class="col-span-2 font-medium text-gray-900">{{ $mahasiswa->tgl_lahir ? $mahasiswa->tgl_lahir->format('d F Y') : '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">Jenis Kelamin</span>
                            <span class="col-span-2 font-medium text-gray-900">{{ $mahasiswa->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">Agama</span>
                            <span class="col-span-2 font-medium text-gray-900">ID: {{ $mahasiswa->id_agama ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">NIK / KTP</span>
                            <span class="col-span-2 font-medium text-gray-900">{{ $mahasiswa->no_ktp ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">Kewarganegaraan</span>
                            <span class="col-span-2 font-medium text-gray-900">{{ $mahasiswa->kewarganegaraan ?? 'ID' }}</span>
                        </div>
                    </div>
                </div>

                {{-- CARD 2: KONTAK & ALAMAT --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden h-full">
                    <div class="bg-gray-50 px-6 py-3 border-b border-gray-200 flex items-center">
                        <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <h3 class="font-bold text-gray-700">Kontak & Domisili</h3>
                    </div>
                    <div class="p-6 space-y-4 text-sm">
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">No. Handphone</span>
                            <span class="col-span-2 font-medium text-gray-900">{{ $mahasiswa->no_hp ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">Email</span>
                            <span class="col-span-2 font-medium text-gray-900">{{ $mahasiswa->email ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">Jalan / Alamat</span>
                            <span class="col-span-2 font-medium text-gray-900">{{ $mahasiswa->jln ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">Desa / Kelurahan</span>
                            <span class="col-span-2 font-medium text-gray-900">{{ $mahasiswa->nm_desa ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">Kecamatan</span>
                            <span class="col-span-2 font-medium text-gray-900">{{ $mahasiswa->id_wil_kecamatan ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">Jenis Tinggal</span>
                            <span class="col-span-2 font-medium text-gray-900">ID: {{ $mahasiswa->id_jns_tinggal ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- CARD 3: DATA AKADEMIK --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden h-full">
                    <div class="bg-gray-50 px-6 py-3 border-b border-gray-200 flex items-center">
                        <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path></svg>
                        <h3 class="font-bold text-gray-700">Detail Akademik</h3>
                    </div>
                    <div class="p-6 space-y-4 text-sm">
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">Jalur Masuk</span>
                            <span class="col-span-2 font-medium text-gray-900">{{ $mahasiswa->id_jlr_masuk ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">Tanggal Masuk</span>
                            <span class="col-span-2 font-medium text-gray-900">{{ $mahasiswa->tgl_masuk_kuliah ? $mahasiswa->tgl_masuk_kuliah->format('d M Y') : '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">Semester Masuk</span>
                            <span class="col-span-2 font-medium text-gray-900">{{ $mahasiswa->smt_masuk ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">Minat & Bakat</span>
                            <span class="col-span-2 font-medium text-gray-900 italic">"{{ $mahasiswa->minat_bakat ?? '-' }}"</span>
                        </div>
                    </div>
                </div>

                {{-- CARD 4: LATAR BELAKANG SEKOLAH --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden h-full">
                    <div class="bg-gray-50 px-6 py-3 border-b border-gray-200 flex items-center">
                        <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <h3 class="font-bold text-gray-700">Asal Sekolah</h3>
                    </div>
                    <div class="p-6 space-y-4 text-sm">
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">Nama Sekolah</span>
                            <span class="col-span-2 font-medium text-gray-900">{{ $mahasiswa->nm_sekolah_asal ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">Tahun Ijazah</span>
                            <span class="col-span-2 font-medium text-gray-900">{{ $mahasiswa->thn_ijazah_asal ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <span class="text-gray-500">NISN</span>
                            <span class="col-span-2 font-medium text-gray-900">{{ $mahasiswa->nisn ?? '-' }}</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- SECTION 3: DATA ORANG TUA (FULL WIDTH) --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-3 border-b border-gray-200 flex items-center">
                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <h3 class="font-bold text-gray-700">Data Orang Tua / Wali</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-10">
                    {{-- AYAH --}}
                    <div>
                        <h4 class="text-sm font-bold text-gray-400 uppercase mb-4 border-b pb-2">Data Ayah</h4>
                        <div class="space-y-3 text-sm">
                            <p class="flex justify-between"><span class="text-gray-500">Nama:</span> <span class="font-medium text-gray-900">{{ $mahasiswa->nm_ayah ?? '-' }}</span></p>
                            <p class="flex justify-between"><span class="text-gray-500">NIK:</span> <span class="font-medium text-gray-900">{{ $mahasiswa->no_ktp_ayah ?? '-' }}</span></p>
                            <p class="flex justify-between"><span class="text-gray-500">Pekerjaan:</span> <span class="font-medium text-gray-900">ID: {{ $mahasiswa->id_pekerjaan_ayah ?? '-' }}</span></p>
                            <p class="flex justify-between"><span class="text-gray-500">Penghasilan:</span> <span class="font-medium text-gray-900">ID: {{ $mahasiswa->id_penghasilan_ayah ?? '-' }}</span></p>
                            <p class="flex justify-between"><span class="text-gray-500">Pendidikan:</span> <span class="font-medium text-gray-900">ID: {{ $mahasiswa->id_jenjang_pendidikan_ayah ?? '-' }}</span></p>
                        </div>
                    </div>

                    {{-- IBU --}}
                    <div>
                        <h4 class="text-sm font-bold text-gray-400 uppercase mb-4 border-b pb-2">Data Ibu</h4>
                        <div class="space-y-3 text-sm">
                            <p class="flex justify-between"><span class="text-gray-500">Nama:</span> <span class="font-medium text-gray-900">{{ $mahasiswa->nm_ibu_kandung ?? '-' }}</span></p>
                            <p class="flex justify-between"><span class="text-gray-500">NIK:</span> <span class="font-medium text-gray-900">{{ $mahasiswa->no_ktp_ibu ?? '-' }}</span></p>
                            <p class="flex justify-between"><span class="text-gray-500">Pekerjaan:</span> <span class="font-medium text-gray-900">ID: {{ $mahasiswa->id_pekerjaan_ibu ?? '-' }}</span></p>
                            <p class="flex justify-between"><span class="text-gray-500">Penghasilan:</span> <span class="font-medium text-gray-900">ID: {{ $mahasiswa->id_penghasilan_ibu ?? '-' }}</span></p>
                            <p class="flex justify-between"><span class="text-gray-500">Pendidikan:</span> <span class="font-medium text-gray-900">ID: {{ $mahasiswa->id_jenjang_pendidikan_ibu ?? '-' }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>