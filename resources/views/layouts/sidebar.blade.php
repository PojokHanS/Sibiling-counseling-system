<aside
    :class="{
        'translate-x-0': mobileOpen,
        '-translate-x-full': !mobileOpen,
        'w-72': sidebarOpen,
        'w-20': !sidebarOpen
    }"
    class="fixed inset-y-0 left-0 z-50 flex flex-col bg-gradient-to-b from-[#047857] to-[#064e3b] text-white transition-all duration-300 ease-in-out shadow-2xl lg:static lg:translate-x-0 border-r border-white/10">

    {{-- 1. SIDEBAR HEADER (LOGO) --}}
    <div class="h-20 flex items-center justify-center relative border-b border-white/10 shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 overflow-hidden px-4 transition-all duration-300">
            {{-- Logo Container --}}
            <div class="relative flex items-center justify-center w-10 h-10 bg-white rounded-xl shadow-lg ring-2 ring-white/20 shrink-0 transform transition hover:scale-105">
                <img src="{{ asset('images/logo-ubbg.png') }}" alt="Logo" class="w-7 h-7 object-contain">
            </div>
            
            {{-- Text SIBILING (Hanya muncul jika sidebar terbuka) --}}
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition ease-out duration-200 delay-100"
                 x-transition:enter-start="opacity-0 -translate-x-2"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 class="flex flex-col">
                <span class="text-xl font-extrabold tracking-tight text-white leading-none drop-shadow-md">SIBILING</span>
                <span class="text-[10px] text-emerald-200 font-medium tracking-widest uppercase mt-0.5">App v2.0</span>
            </div>
        </a>

        {{-- Toggle Button (Desktop Only) --}}
        <button @click="sidebarOpen = !sidebarOpen" 
                class="absolute -right-3 top-1/2 -translate-y-1/2 bg-white text-emerald-700 p-1 rounded-full shadow-md border border-emerald-100 hover:bg-emerald-50 transition hidden lg:flex z-50">
            <svg class="w-4 h-4 transition-transform duration-300" :class="{'rotate-180': !sidebarOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
    </div>

    {{-- 2. NAVIGATION MENU --}}
    <nav class="flex-1 overflow-y-auto px-3 py-6 space-y-1 custom-scrollbar">
        
        {{-- Helper function untuk class item menu --}}
        @php
            function getMenuClass($routeName) {
                $isActive = request()->routeIs($routeName);
                $base = "group flex items-center px-3 py-3 rounded-xl transition-all duration-200 relative overflow-hidden mb-1 ";
                $active = "bg-white/10 text-white shadow-inner font-bold border-l-4 border-yellow-400";
                $inactive = "text-emerald-100 hover:bg-white/5 hover:text-white hover:translate-x-1";
                return $base . ($isActive ? $active : $inactive);
            }
        @endphp

        {{-- DASHBOARD --}}
        <a href="{{ route('dashboard') }}" class="{{ getMenuClass('dashboard') }}" title="Dashboard">
            <svg class="w-6 h-6 shrink-0 transition-colors {{ request()->routeIs('dashboard') ? 'text-yellow-400' : 'text-emerald-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Dashboard</span>
            
            {{-- Glow Effect Active --}}
            @if(request()->routeIs('dashboard'))
                <div class="absolute inset-0 bg-yellow-400/5 pointer-events-none"></div>
            @endif
        </a>

        {{-- MENU ROLE: DOSEN (CURHAT) --}}
        @if(Auth::user()->dosen && !Auth::user()->hasRole('warek'))
            <div x-show="sidebarOpen" class="mt-6 mb-2 px-3 text-[10px] font-bold text-emerald-300/80 uppercase tracking-widest">
                Layanan Dosen
            </div>
            
            <a href="{{ route('dosen.curhat.index') }}" class="{{ getMenuClass('dosen.curhat.index') }}">
                <svg class="w-6 h-6 shrink-0 {{ request()->routeIs('dosen.curhat.index') ? 'text-yellow-400' : 'text-emerald-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Konseling Masuk</span>
            </a>
            <a href="{{ route('dosen.curhat.riwayat') }}" class="{{ getMenuClass('dosen.curhat.riwayat') }}">
                <svg class="w-6 h-6 shrink-0 {{ request()->routeIs('dosen.curhat.riwayat') ? 'text-yellow-400' : 'text-emerald-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Riwayat Arsip</span>
            </a>
        @endif

        {{-- MENU ROLE: MAHASISWA --}}
        @role('mahasiswa')
            <div x-show="sidebarOpen" class="mt-6 mb-2 px-3 text-[10px] font-bold text-emerald-300/80 uppercase tracking-widest">
                Mahasiswa
            </div>
            
            <a href="{{ route('mahasiswa.pengajuan.create') }}" class="{{ getMenuClass('mahasiswa.pengajuan.*') }}">
                <svg class="w-6 h-6 shrink-0 {{ request()->routeIs('mahasiswa.pengajuan.*') ? 'text-yellow-400' : 'text-emerald-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Buat Pengajuan</span>
            </a>
            <a href="{{ route('mahasiswa.riwayat.index') }}" class="{{ getMenuClass('mahasiswa.riwayat.*') }}">
                <svg class="w-6 h-6 shrink-0 {{ request()->routeIs('mahasiswa.riwayat.*') ? 'text-yellow-400' : 'text-emerald-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Riwayat Saya</span>
            </a>
        @endrole

        {{-- MENU ROLE: DOSEN KONSELING --}}
        @role('dosen_konseling')
            <div x-show="sidebarOpen" class="mt-6 mb-2 px-3 text-[10px] font-bold text-emerald-300/80 uppercase tracking-widest">
                Konselor / BK
            </div>
            <a href="{{ route('dosen-konseling.pengajuan.index') }}" class="{{ getMenuClass('dosen-konseling.pengajuan.*') }}">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Pengajuan Baru</span>
            </a>
            <a href="{{ route('dosen-konseling.jadwal.index') }}" class="{{ getMenuClass('dosen-konseling.jadwal.*') }}">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Jadwal Sesi</span>
            </a>
            <a href="{{ route('dosen-konseling.kasus.index') }}" class="{{ getMenuClass('dosen-konseling.kasus.*') }}">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Data Kasus</span>
            </a>
        @endrole

        {{-- MENU ROLE: DOSEN PEMBIMBING --}}
        @role('dosen_pembimbing')
            <div x-show="sidebarOpen" class="mt-6 mb-2 px-3 text-[10px] font-bold text-emerald-300/80 uppercase tracking-widest">
                Dosen PA
            </div>
            <a href="{{ route('dosen-pembimbing.mahasiswa') }}" class="{{ getMenuClass('dosen-pembimbing.mahasiswa') }}">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Mahasiswa Bimbingan</span>
            </a>
            <a href="{{ route('dosen-pembimbing.rekomendasi.index') }}" class="{{ getMenuClass('dosen-pembimbing.rekomendasi.*') }}">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Rekomendasi</span>
            </a>
        @endrole

        {{-- MENU ROLE: ADMIN --}}
        @role('admin')
            <div x-show="sidebarOpen" class="mt-6 mb-2 px-3 text-[10px] font-bold text-emerald-300/80 uppercase tracking-widest">
                Administrator
            </div>
            <a href="{{ route('admin.dosen.index') }}" class="{{ getMenuClass('admin.dosen.*') }}">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Data Dosen</span>
            </a>
            <a href="{{ route('admin.mahasiswa.index') }}" class="{{ getMenuClass('admin.mahasiswa.*') }}">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Data Mahasiswa</span>
            </a>
            <a href="{{ route('admin.roles.index') }}" class="{{ getMenuClass('admin.roles.*') }}">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Role User</span>
            </a>
        @endrole
        
        {{-- MENU ROLE: WAREK --}}
        @role('warek')
            <div x-show="sidebarOpen" class="mt-6 mb-2 px-3 text-[10px] font-bold text-emerald-300/80 uppercase tracking-widest">
                Warek
            </div>
            <a href="{{ route('warek.konseling.index') }}" class="{{ getMenuClass('warek.konseling.index') }}">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Inbox Laporan</span>
            </a>
            <a href="{{ route('warek.konseling.riwayat') }}" class="{{ getMenuClass('warek.konseling.riwayat') }}">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Arsip Selesai</span>
            </a>
        @endrole

    </nav>

    {{-- 3. USER PROFILE (BOTTOM) --}}
    <div class="border-t border-white/10 bg-black/10 shrink-0">
        <div x-data="{ openProfile: false }" class="relative">
            <button @click="openProfile = !openProfile" class="w-full flex items-center p-4 hover:bg-white/10 transition-colors duration-200 outline-none">
                <div class="relative">
                    <img class="w-9 h-9 rounded-full object-cover border-2 border-emerald-300" 
                         src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6ee7b7&color=064e3b" 
                         alt="Avatar">
                    <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-400 border-2 border-emerald-900 rounded-full"></div>
                </div>
                
                <div x-show="sidebarOpen" class="ml-3 text-left overflow-hidden transition-opacity duration-200">
                    <p class="text-sm font-bold text-white truncate max-w-[150px]">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-emerald-200 uppercase tracking-wide truncate">
                         @foreach(Auth::user()->roles as $role)
                            {{ str_replace('_', ' ', $role->name) }}
                        @endforeach
                    </p>
                </div>
                
                <div x-show="sidebarOpen" class="ml-auto">
                    <svg class="w-4 h-4 text-emerald-300 transition-transform duration-200" :class="{'rotate-180': openProfile}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                </div>
            </button>

            {{-- Dropdown Profile --}}
            <div x-show="openProfile" 
                 @click.away="openProfile = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                 x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                 class="absolute bottom-full left-2 right-2 mb-2 bg-white rounded-xl shadow-xl border border-gray-100 py-1 overflow-hidden z-50 origin-bottom">
                
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profile Saya
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition border-t border-gray-100">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>

<style>
    /* Custom Scrollbar for Sidebar */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.4); }
</style>