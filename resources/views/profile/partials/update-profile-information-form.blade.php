<section>
    <header>
        <h2 class="text-lg font-bold text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui foto profil, nama, dan informasi kontak Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- Tambahkan enctype="multipart/form-data" WAJIB buat upload file --}}
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- FOTO PROFIL DENGAN PREVIEW (ALPINE JS) --}}
        <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
            <input type="file" class="hidden" x-ref="photo" name="avatar"
                   x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);
                   " />

            <x-input-label for="photo" value="{{ __('Foto Profil') }}" />

            <div class="mt-2 flex items-center gap-4">
                <div class="mt-2" x-show="! photoPreview">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="rounded-full h-20 w-20 object-cover border-2 border-emerald-500 shadow-md">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2E8B57&color=ffffff&size=128" alt="{{ $user->name }}" class="rounded-full h-20 w-20 object-cover border-2 border-emerald-500 shadow-md">
                    @endif
                </div>

                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full h-20 w-20 bg-cover bg-no-repeat bg-center border-2 border-emerald-500 shadow-md"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Pilih Foto Baru') }}
                </button>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        {{-- NAMA --}}
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full focus:ring-emerald-500 focus:border-emerald-500" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- EMAIL --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full focus:ring-emerald-500 focus:border-emerald-500 bg-gray-100" :value="old('email', $user->email)" readonly />
            <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah untuk keamanan sistem.</p>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        {{-- NO HP (KHUSUS MAHASISWA) --}}
        @if($user->hasRole('mahasiswa') && $user->mahasiswa)
        <div>
            <x-input-label for="no_hp" :value="__('No. HP / WhatsApp')" />
            <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full focus:ring-emerald-500 focus:border-emerald-500" :value="old('no_hp', $user->mahasiswa->no_hp)" placeholder="0812xxxx" />
            <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
        </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500">{{ __('Simpan Perubahan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-600 font-bold"
                >{{ __('Berhasil Disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>