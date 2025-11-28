<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            Edit Jabatan: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                <div class="p-8">
                    
                    <form action="{{ route('admin.roles.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- INFO USER --}}
                        <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold mr-3">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-6 border-gray-100">

                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Pilih Jabatan (Role)
                            </h3>
                            
                            <div class="space-y-4">
                                {{-- Role Warek (HIGHLIGHT) --}}
                                <label class="flex items-start p-4 border border-yellow-200 bg-yellow-50 rounded-lg cursor-pointer hover:bg-yellow-100 transition">
                                    <div class="flex items-center h-5 mt-1">
                                        <input id="warek" name="roles[]" value="warek" type="checkbox" 
                                            {{ $user->hasRole('warek') ? 'checked' : '' }}
                                            class="focus:ring-yellow-500 h-5 w-5 text-yellow-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3">
                                        <span class="block text-sm font-bold text-yellow-800">Wakil Rektor (Warek)</span>
                                        <span class="block text-xs text-yellow-700 mt-1">
                                            Dosen ini akan memiliki akses dashboard eksekutif dan kotak masuk laporan curhat.
                                        </span>
                                    </div>
                                </label>

                                {{-- Role Dosen Konseling --}}
                                <label class="flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                    <div class="flex items-center h-5 mt-1">
                                        <input id="dosen_konseling" name="roles[]" value="dosen_konseling" type="checkbox" 
                                            {{ $user->hasRole('dosen_konseling') ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-5 w-5 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3">
                                        <span class="block text-sm font-bold text-gray-700">Dosen Konseling (Konselor)</span>
                                        <span class="block text-xs text-gray-500 mt-1">
                                            Menangani kasus konseling mahasiswa.
                                        </span>
                                    </div>
                                </label>

                                {{-- Role Dosen Pembimbing --}}
                                <label class="flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                    <div class="flex items-center h-5 mt-1">
                                        <input id="dosen_pembimbing" name="roles[]" value="dosen_pembimbing" type="checkbox" 
                                            {{ $user->hasRole('dosen_pembimbing') ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-5 w-5 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3">
                                        <span class="block text-sm font-bold text-gray-700">Dosen Pembimbing (Wali)</span>
                                        <span class="block text-xs text-gray-500 mt-1">
                                            Memberikan rekomendasi untuk mahasiswa bimbingan.
                                        </span>
                                    </div>
                                </label>

                                {{-- Role Admin (Hati-hati) --}}
                                <label class="flex items-start p-4 border border-red-200 bg-red-50 rounded-lg cursor-pointer hover:bg-red-100 transition mt-4">
                                    <div class="flex items-center h-5 mt-1">
                                        <input id="admin" name="roles[]" value="admin" type="checkbox" 
                                            {{ $user->hasRole('admin') ? 'checked' : '' }}
                                            class="focus:ring-red-500 h-5 w-5 text-red-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3">
                                        <span class="block text-sm font-bold text-red-800">Administrator System</span>
                                        <span class="block text-xs text-red-700 mt-1">
                                            HAK AKSES PENUH. Hanya berikan kepada IT atau penanggung jawab sistem.
                                        </span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 gap-3">
                            <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm font-bold hover:bg-gray-50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg shadow-md transition">
                                Simpan Perubahan Jabatan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>