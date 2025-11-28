<aside
    :class="{
        'w-64': open,
        'w-20': !open,
        'translate-x-0': mobileOpen,
        '-translate-x-full': !mobileOpen
    }"
    class="sidebar-modern text-white sidebar-transition flex flex-col z-50 h-screen offcanvas lg:relative lg:translate-x-0 lg:h-auto">

    <div class="flex items-center justify-between p-6 h-20 flex-shrink-0 border-b border-white/10">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                <span class="text-green-600 font-bold text-lg">S</span>
            </div>
            <span x-show="open" class="logo-text text-xl font-bold">SIBILING</span>
        </div>

        <button @click="open=!open" class="p-2 rounded-lg hover:bg-white/10 transition hidden lg:flex">
            <svg class="h-5 w-5 icon-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      :d="open ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'"></path>
            </svg>
        </button>
        <button @click="mobileOpen=false" class="p-2 rounded-lg hover:bg-white/10 transition lg:hidden">
            <svg class="h-5 w-5 icon-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <nav class="mt-4 px-4 space-y-1 flex-grow overflow-y-auto sidebar-scroll">
        {{-- 1. DASHBOARD (UMUM) --}}
        <a href="{{ route('dashboard') }}"
           @click="showLoading('{{ route('dashboard') }}')"
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('dashboard') ? 'menu-active' : '' }}">
            <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
            <span x-show="open" class="ml-3">Dashboard</span>
        </a>

        {{-- 2. MENU LAYANAN CURHAT (UNTUK SEMUA DOSEN) --}}
        @if(Auth::user()->dosen && !Auth::user()->hasRole('warek'))
        {{-- Menu Aktif --}}
        <a href="{{ route('dosen.curhat.index') }}"
           @click="showLoading('{{ route('dosen.curhat.index') }}')"
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('dosen.curhat.index') ? 'menu-active' : '' }}">
            <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
            <span x-show="open" class="ml-3">Konseling Aktif</span>
        </a>
        
        {{-- Menu Riwayat (BARU) --}}
        <a href="{{ route('dosen.curhat.riwayat') }}"
           @click="showLoading('{{ route('dosen.curhat.riwayat') }}')"
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('dosen.curhat.riwayat') ? 'menu-active' : '' }}">
            <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M13 3a9 9 0 0 0-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42A8.954 8.954 0 0 0 13 21a9 9 0 0 0 0-18zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/></svg>
            <span x-show="open" class="ml-3">Arsip Riwayat</span>
        </a>
        @endif

        {{-- 3. MENU KOTAK MASUK CURHAT (UNTUK WAREK) --}}
        @role('warek')
        {{-- Inbox Aktif --}}
        <a href="{{ route('warek.konseling.index') }}"
           @click="showLoading('{{ route('warek.konseling.index') }}')"
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('warek.konseling.index') ? 'menu-active' : '' }}">
            <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H4.99c-1.11 0-1.98.89-1.98 2L3 19c0 1.1.88 2 1.99 2H19c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 12h-4c0 1.66-1.35 3-3 3s-3-1.34-3-3H4.99V5H19v10z"/></svg>
            <span x-show="open" class="ml-3">Inbox Masuk</span>
        </a>

        {{-- Riwayat Selesai (BARU) --}}
        <a href="{{ route('warek.konseling.riwayat') }}"
           @click="showLoading('{{ route('warek.konseling.riwayat') }}')"
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('warek.konseling.riwayat') ? 'menu-active' : '' }}">
            <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M19 5v14H5V5h14m0-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/><path d="M10 17l5-5-1.41-1.41L10 14.17 7.91 12.09 6.5 13.5z"/></svg>
            <span x-show="open" class="ml-3">Arsip Selesai</span>
        </a>
        @endrole

        {{-- 4. MENU ADMIN --}}
        @role('admin')
        <div x-show="open" class="px-4 py-2 mt-2 text-xs font-semibold text-green-200 uppercase tracking-wider">
            Administrator
        </div>
        <a href="{{ route('admin.dosen.index') }}"
           @click="showLoading('{{ route('admin.dosen.index') }}')"
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('admin.dosen.*') ? 'menu-active' : '' }}">
            <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            <span x-show="open" class="ml-3">Manajemen Dosen</span>
        </a>
        <a href="{{ route('admin.mahasiswa.index') }}"
           @click="showLoading('{{ route('admin.mahasiswa.index') }}')"
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('admin.mahasiswa.*') ? 'menu-active' : '' }}">
            <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M12 5.9c1.16 0 2.1.94 2.1 2.1s-.94 2.1-2.1 2.1S9.9 9.16 9.9 8s.94-2.1 2.1-2.1m0 9c2.97 0 6.1 1.46 6.1 2.1v1.1H5.9V17c0-.64 3.13-2.1 6.1-2.1M12 4C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 9c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z"/></svg>
            <span x-show="open" class="ml-3">Manajemen Mahasiswa</span>
        </a>
        <a href="{{ route('admin.roles.index') }}"
           @click="showLoading('{{ route('admin.roles.index') }}')"
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('admin.roles.*') ? 'menu-active' : '' }}">
            <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M19.43 12.98c.04-.32.07-.64.07-.98s-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.3-.61-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61-.25-1.17-.59-1.69-.98l-2.49-1c-.23-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98s.03.66.07.98l-2.11 1.65c-.19-.15-.24-.42-.12-.64l2 3.46c.12.22.39.3.61.22l2.49-1c.52.4 1.08.73 1.69.98l-.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59-1.69-.98l2.49 1c.23.09.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zM12 15.5c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z"/></svg>
            <span x-show="open" class="ml-3">Manajemen Role</span>
        </a>
        @endrole

        {{-- 5. MENU DOSEN PEMBIMBING --}}
        @role('dosen_pembimbing')
        <div x-show="open" class="px-4 py-2 mt-2 text-xs font-semibold text-green-200 uppercase tracking-wider">
            Pembimbing Akademik
        </div>
        <a href="{{ route('dosen-pembimbing.mahasiswa') }}"
           @click="showLoading('{{ route('dosen-pembimbing.mahasiswa') }}')"
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('dosen-pembimbing.mahasiswa') ? 'menu-active' : '' }}">
            <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
            <span x-show="open" class="ml-3">Mahasiswa Bimbingan</span>
        </a>
        <a href="{{ route('dosen-pembimbing.rekomendasi.index') }}"
           @click="showLoading('{{ route('dosen-pembimbing.rekomendasi.index') }}')"
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('dosen-pembimbing.rekomendasi.*') ? 'menu-active' : '' }}">
            <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v-2h-2z"/></svg>
            <span x-show="open" class="ml-3">Rekomendasi</span>
        </a>
        @endrole

        {{-- 6. MENU DOSEN KONSELING --}}
        @role('dosen_konseling')
        <div x-show="open" class="px-4 py-2 mt-2 text-xs font-semibold text-green-200 uppercase tracking-wider">
            Konselor
        </div>
        <a href="{{ route('dosen-konseling.pengajuan.index') }}"
           @click="showLoading('{{ route('dosen-konseling.pengajuan.index') }}')"
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('dosen-konseling.pengajuan.*') ? 'menu-active' : '' }}">
            <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V6h5.17l2 2H20v10z"/></svg>
            <span x-show="open" class="ml-3">Pengajuan</span>
        </a>
        <a href="{{ route('dosen-konseling.jadwal.index') }}"
           @click="showLoading('{{ route('dosen-konseling.jadwal.index') }}')"
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('dosen-konseling.jadwal.*') ? 'menu-active' : '' }}">
            <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg>
            <span x-show="open" class="ml-3">Jadwal Saya</span>
        </a>
        <a href="{{ route('dosen-konseling.kasus.index') }}"
           @click="showLoading('{{ route('dosen-konseling.kasus.index') }}')"
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('dosen-konseling.kasus.*') ? 'menu-active' : '' }}">
            <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm12 4h-2v2h2V9zm0 4h-2v2h2v-2zm-4-4H9v2h2V9zm0 4H9v2h2v-2z"/></svg>
            <span x-show="open" class="ml-3">Riwayat Kasus</span>
        </a>
        @endrole

        {{-- 7. MENU MAHASISWA --}}
        @role('mahasiswa')
        <a href="{{ route('mahasiswa.pengajuan.create') }}"
           @click="showLoading('{{ route('mahasiswa.pengajuan.create') }}')"
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('mahasiswa.pengajuan.create') ? 'menu-active' : '' }}">
            <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
            <span x-show="open" class="ml-3">Ajukan Konseling</span>
        </a>
        <a href="{{ route('mahasiswa.riwayat.index') }}"
           @click="showLoading('{{ route('mahasiswa.riwayat.index') }}')"
           class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('mahasiswa.riwayat.*') ? 'menu-active' : '' }}">
            <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M13 3a9 9 0 0 0-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42A8.954 8.954 0 0 0 13 21a9 9 0 0 0 0-18zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/></svg>
            <span x-show="open" class="ml-3">Riwayat Konseling</span>
        </a>
        @endrole
    </nav>

    <div class="p-4 flex-shrink-0 border-t border-white/10">
        <div x-data="{ dd:false }" class="relative">
            <button @click="dd=!dd" class="w-full flex items-center justify-between p-3 bg-white/10 rounded-xl hover:bg-white/15 transition">
                <div class="flex items-center min-w-0">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-green-600 font-bold text-sm">{{ strtoupper(substr(Auth::user()->name,0,2)) }}</span>
                    </div>
                    <div x-show="open" class="ml-3 text-left min-w-0 flex-1">
                        <p class="text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-white/70 truncate -mt-1">{{ Auth::user()->email }}</p>
                        <div class="role-badge inline-block">
                            @foreach(Auth::user()->roles as $role)
                                {{ ucfirst(str_replace('_',' ',$role->name)) }}
                            @endforeach
                        </div>
                    </div>
                </div>
                <svg x-show="open" class="w-4 h-4 flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>

            <div x-show="dd" @click.away="dd=false"
                 x-transition
                 class="absolute bottom-full left-0 w-full mb-2 user-dropdown rounded-xl shadow-lg overflow-hidden"
                 style="display:none;">
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                    <svg class="h-4 w-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50">
                        <svg class="h-4 w-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>