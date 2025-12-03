<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight hidden">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    {{-- STYLE INJECTION (Copy dari Dashboard biar konsisten) --}}
    <style>
        :root {
            --primary-green: #2E8B57;
            --primary-light: #3CB371;
            --primary-dark: #23865F;
        }
        .bg-shapes { position: fixed; inset: 0; z-index: 0; overflow: hidden; pointer-events: none; }
        .shape-top-right { position: absolute; top: -10%; right: -5%; width: 50%; height: 50%; background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-green) 100%); border-bottom-left-radius: 50% 40%; opacity: 0.08; animation: float 8s ease-in-out infinite; }
        .shape-bottom-left { position: absolute; bottom: -10%; left: -5%; width: 50%; height: 50%; background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%); border-top-right-radius: 50% 40%; opacity: 0.08; animation: float 10s ease-in-out infinite reverse; }
        @keyframes float { 0%, 100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-20px) rotate(1deg); } }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
            border-radius: 1rem;
        }
        .text-gradient {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-green) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
    </style>

    <div class="bg-shapes">
        <div class="shape-top-right"></div>
        <div class="shape-bottom-left"></div>
    </div>

    <div class="py-12 relative z-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-800">Pengaturan Akun</h1>
                <p class="text-gray-500">Kelola informasi pribadi dan keamanan akun Anda.</p>
            </div>

            <div class="p-4 sm:p-8 glass-card">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 glass-card">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-red-50 border border-red-100 rounded-xl shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
