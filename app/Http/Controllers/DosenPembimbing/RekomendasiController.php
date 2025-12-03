<?php

namespace App\Http\Controllers\DosenPembimbing;

use App\Http\Controllers\Controller;
use App\Models\Konseling;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RekomendasiController extends Controller
{
    /**
     * Menampilkan DAFTAR REKOMENDASI yang pernah diajukan (FIX LOGIC).
     */
    public function index()
    {
        // 1. Ambil data dosen login
        $dosen = Auth::user()->dosen;

        // 2. Ambil data konseling (khusus sumber_pengajuan = dosen_pa)
        $daftarRekomendasi = Konseling::where('id_dosen_wali', $dosen->email_dos)
            ->where('sumber_pengajuan', 'dosen_pa') // Hanya yang rekomendasi
            ->with(['mahasiswa.user', 'mahasiswa.prodi']) // Load data relasi
            ->latest('tgl_pengajuan')
            ->paginate(10);

        // 3. Tampilkan View Index (Bukan Redirect lagi)
        return view('dosen-pembimbing.rekomendasi.index', compact('daftarRekomendasi'));
    }

    /**
     * Menampilkan riwayat (Bisa pakai logic yang sama dengan index).
     */
    public function riwayat()
    {
        return $this->index(); 
    }

    /**
     * Menampilkan form rekomendasi dengan KEAMANAN KETAT.
     */
    public function create(Mahasiswa $mahasiswa)
    {
        $dosen = Auth::user()->dosen;

        // SECURITY CHECK: Pastikan mahasiswa ini benar-benar bimbingannya
        if ($mahasiswa->id_dosen_wali !== $dosen->email_dos) {
            abort(403, 'AKSES DITOLAK: Anda bukan Dosen Wali dari mahasiswa ini.');
        }

        return view('dosen-pembimbing.rekomendasi.create', compact('mahasiswa'));
    }

    /**
     * Menyimpan rekomendasi baru.
     */
    public function store(Request $request)
    {
        $dosenWali = Auth::user()->dosen;

        $request->validate([
            'nim_mahasiswa' => 'required|string|exists:mahasiswa,nim',
            'aspek_permasalahan' => 'required|array|min:1',
            'aspek_permasalahan.*' => 'string',
            'deskripsi_masalah' => 'required|string|min:10', 
            'harapan_pa' => 'required|string|min:10',
        ]);

        // SECURITY CHECK LAGI (Anti Tembak API/Postman)
        $targetMahasiswa = Mahasiswa::where('nim', $request->nim_mahasiswa)->firstOrFail();
        
        if ($targetMahasiswa->id_dosen_wali !== $dosenWali->email_dos) {
            abort(403, 'AKSI ILEGAL: Manipulasi data terdeteksi.');
        }

        // Simpan Data
        Konseling::create([
            'nim_mahasiswa' => $request->nim_mahasiswa,
            'id_dosen_wali' => $dosenWali->email_dos,
            'tgl_pengajuan' => Carbon::now(),
            'status_konseling' => 'Menunggu Kelengkapan Mahasiswa', // Status awal rekomendasi
            'sumber_pengajuan' => 'dosen_pa',
            
            // Data Detail
            'aspek_permasalahan' => $request->aspek_permasalahan,
            'permasalahan_segera' => $request->deskripsi_masalah, 
            'harapan_pa' => $request->harapan_pa,
            'permasalahan' => 'Rekomendasi Dosen PA: ' . $request->deskripsi_masalah, // Ringkasan
            'upaya_dilakukan' => '-',
        ]);

        return redirect()->route('dosen-pembimbing.rekomendasi.index')
                         ->with('success', 'Rekomendasi berhasil dibuat. Menunggu mahasiswa melengkapi data.');
    }

    // Method bawaan resource (kosongkan jika tidak dipakai)
    public function edit($id) {}
    public function update(Request $request, $id) {}
}