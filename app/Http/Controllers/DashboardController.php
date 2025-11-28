<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KonselingDosen;
use App\Models\Dosen;      // Import Model Dosen
use App\Models\Mahasiswa;  // Import Model Mahasiswa
use App\Models\User;       // <-- TAMBAHAN PENTING: Import Model User

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Jika Admin -> Dashboard Admin
        if ($user->hasRole('admin')) {
            // --- DATA STATISTIK ADMIN ---
            $totalDosen = Dosen::count();
            $totalMahasiswa = Mahasiswa::count();
            $totalUsers = User::count(); // <-- INI YANG KURANG TADI
            
            // Kirim semua data ke view
            return view('admin.dashboard', compact('totalDosen', 'totalMahasiswa', 'totalUsers'));
        }

        // 2. Jika Warek -> Dashboard Warek
        if ($user->hasRole('warek')) {
            return redirect()->route('warek.dashboard');
        }

        // 3. Jika Dosen Konseling -> Dashboard Konselor
        if ($user->hasRole('dosen_konseling')) {
            return view('dosen-konseling.dashboard');
        }

        // 4. Jika Dosen Pembimbing -> Dashboard PA
        if ($user->hasRole('dosen_pembimbing')) {
            return view('dosen-pembimbing.dashboard');
        }

        // 5. Jika Mahasiswa -> Dashboard Mahasiswa
        if ($user->hasRole('mahasiswa')) {
            return view('mahasiswa.dashboard');
        }

        // 6. Jika Dosen Biasa (Punya data di tabel dosen) -> Dashboard Dosen Umum
        if ($user->dosen) {
            $totalCurhat = KonselingDosen::where('email_dosen', $user->email)->count();
            $dalamProses = KonselingDosen::where('email_dosen', $user->email)
                            ->whereIn('status_konseling', ['Menunggu Verifikasi', 'Dijadwalkan'])
                            ->count();
            $selesai = KonselingDosen::where('email_dosen', $user->email)
                            ->where('status_konseling', 'Selesai')
                            ->count();
            
            $jadwalTerdekat = KonselingDosen::where('email_dosen', $user->email)
                            ->where('status_konseling', 'Dijadwalkan')
                            ->whereNotNull('jadwal_konseling')
                            ->where('jadwal_konseling', '>=', now())
                            ->orderBy('jadwal_konseling', 'asc')
                            ->first();

            return view('dosen.dashboard', compact('totalCurhat', 'dalamProses', 'selesai', 'jadwalTerdekat'));
        }

        // 7. User Umum / Lainnya (Fallback)
        return view('dashboard'); 
    }
}