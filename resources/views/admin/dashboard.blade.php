<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Administrator') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- SECTION 1: WELCOME BANNER (DARK THEME) --}}
            <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl shadow-lg p-8 text-white relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h3 class="text-3xl font-extrabold flex items-center gap-3">
                            Halo, Admin {{ Auth::user()->name }}! 
                            <span class="text-3xl">🚀</span>
                        </h3>
                        <p class="mt-2 text-gray-300 max-w-xl text-sm md:text-base">
                            Anda memiliki akses penuh untuk mengelola data pengguna, dosen, mahasiswa, dan pengaturan hak akses sistem.
                        </p>
                    </div>
                    {{-- Tombol Logout Cepat (Opsional) --}}
                    {{-- <div class="hidden md:block">
                        <span class="px-4 py-2 bg-white/10 rounded-lg text-sm font-mono border border-white/20">
                            System Status: Online 🟢
                        </span>
                    </div> --}}
                </div>
                
                {{-- Dekorasi Background Abstrak --}}
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-indigo-500 opacity-20 rounded-full blur-2xl"></div>
            </div>

            {{-- SECTION 2: STATISTIK DATA (3 KOLOM) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Card 1: Total User --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center hover:shadow-md transition">
                    <div class="p-4 rounded-full bg-indigo-50 text-indigo-600 mr-5">
                        {{-- Icon Users --}}
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Total User Akun</p>
                        <p class="text-3xl font-black text-gray-900">{{ number_format($totalUsers) }}</p>
                    </div>
                </div>

                {{-- Card 2: Total Dosen --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center hover:shadow-md transition">
                    <div class="p-4 rounded-full bg-blue-50 text-blue-600 mr-5">
                        {{-- Icon Academic/Dosen --}}
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Data Dosen</p>
                        <p class="text-3xl font-black text-gray-900">{{ number_format($totalDosen) }}</p>
                    </div>
                </div>

                {{-- Card 3: Total Mahasiswa --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex items-center hover:shadow-md transition">
                    <div class="p-4 rounded-full bg-green-50 text-green-600 mr-5">
                        {{-- Icon Graduate/Mahasiswa --}}
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Data Mahasiswa</p>
                        <p class="text-3xl font-black text-gray-900">{{ number_format($totalMahasiswa) }}</p>
                    </div>
                </div>

            </div>

            {{-- SECTION 3: MENU PENGELOLAAN CEPAT (QUICK ACTIONS) --}}
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4 ml-1">Menu Pengelolaan Cepat</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    {{-- Action 1: Role --}}
                    <a href="{{ route('admin.roles.index') }}" class="group bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:border-indigo-500 hover:ring-1 hover:ring-indigo-500 transition cursor-pointer relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600 mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-1">Role & Jabatan</h4>
                            <p class="text-sm text-gray-500">Atur Admin, Warek, Dosen Konseling, dll.</p>
                        </div>
                        {{-- Arrow Icon on Hover --}}
                        <div class="absolute top-6 right-6 opacity-0 group-hover:opacity-100 transition-opacity transform group-hover:translate-x-1">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </a>

                    {{-- Action 2: Dosen --}}
                    <a href="{{ route('admin.dosen.index') }}" class="group bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:border-blue-500 hover:ring-1 hover:ring-blue-500 transition cursor-pointer relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-1">Manajemen Dosen</h4>
                            <p class="text-sm text-gray-500">Kelola data induk dosen dan staf.</p>
                        </div>
                    </a>

                    {{-- Action 3: Mahasiswa --}}
                    <a href="{{ route('admin.mahasiswa.index') }}" class="group bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:border-green-500 hover:ring-1 hover:ring-green-500 transition cursor-pointer relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600 mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-1">Manajemen Mahasiswa</h4>
                            <p class="text-sm text-gray-500">Kelola data induk mahasiswa.</p>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>