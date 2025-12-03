<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KonselingDosen;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Konseling;        
use App\Models\JadwalKonseling;  
use Carbon\Carbon;               

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Jika Admin -> Tetap pisah karena dunianya beda
        if ($user->hasRole('admin')) {
            $totalDosen = Dosen::count();
            $totalMahasiswa = Mahasiswa::count();
            $totalUsers = User::count();
            return view('admin.dashboard', compact('totalDosen', 'totalMahasiswa', 'totalUsers'));
        }

        // 2. Jika Warek -> Tetap pisah
        if ($user->hasRole('warek')) {
            return redirect()->route('warek.dashboard');
        }

        // 3. Jika Mahasiswa -> Tetap pisah
        if ($user->hasRole('mahasiswa')) {
            $konselingTerakhir = null;
            if ($user->mahasiswa) {
                $konselingTerakhir = Konseling::where('nim_mahasiswa', $user->mahasiswa->nim)
                                            ->latest('tgl_pengajuan')->first();
            }
            return view('mahasiswa.dashboard', compact('konselingTerakhir'));
        }

        // 4. LOGIKA "SUPER DOSEN" (Menghandle Multi-Role)
        // Kita siapkan variabel default (kosong) biar nggak error kalau role-nya nggak lengkap
        $data = [
            // Data Konselor
            'isKonselor' => false,
            'jumlahPengajuanBaru' => 0,
            'jadwalHariIni' => 0,
            
            // Data Pembimbing Akademik (PA)
            'isPA' => false,
            'totalMahasiswaBimbingan' => 0,

            // Data Pribadi (Dosen Curhat) - Selalu ada
            'totalCurhat' => 0,
            'dalamProses' => 0,
            'selesai' => 0,
            'jadwalTerdekat' => null,
        ];

        // A. Cek Role Konselor
        if ($user->hasRole('dosen_konseling')) {
            $data['isKonselor'] = true;
            $data['jumlahPengajuanBaru'] = Konseling::where('status_konseling', 'Menunggu Verifikasi')->count();
            $data['jadwalHariIni'] = JadwalKonseling::where('tgl_sesi', Carbon::now()->format('Y-m-d'))
                                            ->where('status_sesi', 'dijadwalkan')->count();
        }

        // B. Cek Role Pembimbing Akademik
        if ($user->hasRole('dosen_pembimbing')) {
            $data['isPA'] = true;
            $dosen = Dosen::where('email_dos', $user->email)->first(); // Cari data dosen via email user
            if ($dosen) {
                 $data['totalMahasiswaBimbingan'] = Mahasiswa::where('id_dosen_wali', $dosen->nidn)->count();
            }
        }

        // C. Data Dosen Biasa (Curhat ke Warek) - Semua dosen punya hak ini
        if ($user->dosen) { // Cek relasi ke tabel dosen
            $data['totalCurhat'] = KonselingDosen::where('email_dosen', $user->email)->count();
            $data['dalamProses'] = KonselingDosen::where('email_dosen', $user->email)
                            ->whereIn('status_konseling', ['Menunggu Verifikasi', 'Dijadwalkan'])->count();
            $data['selesai'] = KonselingDosen::where('email_dosen', $user->email)
                            ->where('status_konseling', 'Selesai')->count();
            $data['jadwalTerdekat'] = KonselingDosen::where('email_dosen', $user->email)
                            ->where('status_konseling', 'Dijadwalkan')
                            ->whereNotNull('jadwal_konseling')
                            ->where('jadwal_konseling', '>=', now())
                            ->orderBy('jadwal_konseling', 'asc')->first();
        }

        // Return ke SATU View Dosen yang sudah dimodifikasi
        return view('dosen.dashboard', $data);
    }
}