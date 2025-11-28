<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    {{-- General Dashboard --}}
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- === [TAMBAHAN BARU] MENU UMUM UNTUK SEMUA DOSEN === --}}
                    {{-- Logika: Jika user terdaftar di tabel 'dosen', tampilkan menu ini --}}
                    {{-- Ini akan muncul untuk Dosen Biasa, Dosen Wali, Konseling, dll --}}
                    @if(Auth::user()->dosen)
                        <x-nav-link :href="route('dosen.curhat.index')" :active="request()->routeIs('dosen.curhat.*')">
                            {{ __('Layanan Curhat') }}
                        </x-nav-link>
                    @endif
                    {{-- ================================================= --}}

                    {{-- === MENU UNTUK MAHASISWA === --}}
                    @role('mahasiswa')
                        <x-nav-link :href="route('mahasiswa.riwayat.index')" :active="request()->routeIs('mahasiswa.riwayat.*')">
                            {{ __('Riwayat Konseling') }}
                        </x-nav-link>
                    @endrole

                    {{-- === MENU UNTUK ADMIN === --}}
                    @role('admin')
                        <x-nav-link :href="route('admin.dosen.index')" :active="request()->routeIs('admin.dosen.*')">
                            {{ __('Manajemen Dosen') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.mahasiswa.index')" :active="request()->routeIs('admin.mahasiswa.*')">
                            {{ __('Manajemen Mahasiswa') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                            {{ __('User Roles') }}
                        </x-nav-link>
                    @endrole
                    
                    {{-- === MENU UNTUK DOSEN KONSELING === --}}
                    @role('dosen_konseling')
                        <x-nav-link :href="route('dosen-konseling.pengajuan.index')" :active="request()->routeIs('dosen-konseling.pengajuan.*')">
                            {{ __('Pengajuan Masuk') }}
                        </x-nav-link>
                         <x-nav-link :href="route('dosen-konseling.jadwal.index')" :active="request()->routeIs('dosen-konseling.jadwal.*')">
                            {{ __('Jadwal Saya') }}
                        </x-nav-link>
                         <x-nav-link :href="route('dosen-konseling.kasus.index')" :active="request()->routeIs('dosen-konseling.kasus.*')">
                            {{ __('Riwayat Kasus') }}
                        </x-nav-link>
                    @endrole

                    {{-- === MENU UNTUK DOSEN PEMBIMBING === --}}
                    @role('dosen_pembimbing')
                         <x-nav-link :href="route('dosen-pembimbing.mahasiswa')" :active="request()->routeIs('dosen-pembimbing.mahasiswa')">
                            {{ __('Mahasiswa Bimbingan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('dosen-pembimbing.rekomendasi.index')" :active="request()->routeIs('dosen-pembimbing.rekomendasi.*')">
                            {{ __('Rekomendasi Saya') }}
                        </x-nav-link>
                    @endrole

                    {{-- === [TAMBAHAN BARU] MENU UNTUK WAREK === --}}
                    @role('warek')
                        <x-nav-link :href="route('warek.konseling.index')" :active="request()->routeIs('warek.konseling.*')">
                            {{ __('Kotak Masuk Curhat') }}
                        </x-nav-link>
                    @endrole
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            {{-- === [TAMBAHAN BARU] MENU MOBILE UMUM UNTUK SEMUA DOSEN === --}}
            @if(Auth::user()->dosen)
                <x-responsive-nav-link :href="route('dosen.curhat.index')" :active="request()->routeIs('dosen.curhat.*')">
                    {{ __('Layanan Curhat') }}
                </x-responsive-nav-link>
            @endif
            {{-- ======================================================= --}}

            {{-- === MENU RESPONSIVE UNTUK MAHASISWA === --}}
            @role('mahasiswa')
                <x-responsive-nav-link :href="route('mahasiswa.riwayat.index')" :active="request()->routeIs('mahasiswa.riwayat.*')">
                    {{ __('Riwayat Konseling') }}
                </x-responsive-nav-link>
            @endrole

            {{-- === MENU RESPONSIVE UNTUK ADMIN === --}}
            @role('admin')
                <x-responsive-nav-link :href="route('admin.dosen.index')" :active="request()->routeIs('admin.dosen.*')">
                    {{ __('Manajemen Dosen') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.mahasiswa.index')" :active="request()->routeIs('admin.mahasiswa.*')">
                    {{ __('Manajemen Mahasiswa') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                    {{ __('User Roles') }}
                </x-responsive-nav-link>
            @endrole

            {{-- === MENU RESPONSIVE UNTUK DOSEN KONSELING === --}}
            @role('dosen_konseling')
                <x-responsive-nav-link :href="route('dosen-konseling.pengajuan.index')" :active="request()->routeIs('dosen-konseling.pengajuan.*')">
                    {{ __('Pengajuan Masuk') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('dosen-konseling.jadwal.index')" :active="request()->routeIs('dosen-konseling.jadwal.*')">
                    {{ __('Jadwal Saya') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('dosen-konseling.kasus.index')" :active="request()->routeIs('dosen-konseling.kasus.*')">
                    {{ __('Riwayat Kasus') }}
                </x-responsive-nav-link>
            @endrole

            {{-- === MENU RESPONSIVE UNTUK DOSEN PEMBIMBING === --}}
            @role('dosen_pembimbing')
                <x-responsive-nav-link :href="route('dosen-pembimbing.mahasiswa')" :active="request()->routeIs('dosen-pembimbing.mahasiswa')">
                    {{ __('Mahasiswa Bimbingan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('dosen-pembimbing.rekomendasi.index')" :active="request()->routeIs('dosen-pembimbing.rekomendasi.*')">
                    {{ __('Rekomendasi Saya') }}
                </x-responsive-nav-link>
            @endrole

            {{-- === [TAMBAHAN BARU] MENU RESPONSIVE WAREK === --}}
            @role('warek')
                <x-responsive-nav-link :href="route('warek.konseling.index')" :active="request()->routeIs('warek.konseling.*')">
                    {{ __('Kotak Masuk Curhat') }}
                </x-responsive-nav-link>
            @endrole
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>