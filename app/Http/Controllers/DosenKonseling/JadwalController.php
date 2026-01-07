<?php

namespace App\Http\Controllers\DosenKonseling;

use App\Http\Controllers\Controller;
use App\Models\JadwalKonseling;
use App\Models\Konseling;
use App\Models\HasilKonseling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JadwalController extends Controller
{
    /**
     * Menampilkan daftar jadwal yang dimiliki Dosen Konseling.
     */
    public function index()
    {
        $dosen = Auth::user()->dosen;
        
        if (!$dosen) {
            abort(403, 'Profil Dosen tidak ditemukan.');
        }

        $dosenId = $dosen->id_dosen ?? $dosen->id;

        $jadwal = JadwalKonseling::where('id_dosen_konseling', $dosenId)
                                 ->whereDoesntHave('hasilKonseling')
                                 ->with('konseling.mahasiswa.user')
                                 ->orderBy('tgl_sesi', 'asc')
                                 ->orderBy('waktu_mulai', 'asc')
                                 ->get();

        return view('dosen-konseling.jadwal.index', compact('jadwal'));
    }

    public function create(Konseling $pengajuan)
    {
        if (!in_array($pengajuan->status_konseling, ['Disetujui', 'Butuh Sesi Lanjutan'])) {
            return redirect()->route('dosen-konseling.pengajuan.index')
                             ->with('error', 'Jadwal hanya bisa dibuat untuk kasus yang disetujui atau butuh sesi lanjutan.');
        }

        return view('dosen-konseling.jadwal.create', compact('pengajuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_konseling' => 'required|exists:konseling,id_konseling',
            'tanggal_konseling' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
            'metode_konseling' => 'required|string|in:Online,Offline',
            'lokasi' => 'nullable|string', 
        ]);

        try {
            $dosen = Auth::user()->dosen;
            $dosenId = $dosen->id_dosen ?? $dosen->id;

            $waktu_mulai = Carbon::parse($request->waktu_mulai)->format('H:i:s');
            $waktu_selesai = Carbon::parse($request->waktu_selesai)->format('H:i:s');

            JadwalKonseling::create([
                'id_konseling' => $request->id_konseling,
                'id_dosen_konseling' => $dosenId,
                'tgl_sesi' => $request->tanggal_konseling,
                'waktu_mulai' => $waktu_mulai,
                'waktu_selesai' => $waktu_selesai,
                'metode_konseling' => $request->metode_konseling,
                'lokasi' => $request->lokasi,
            ]);

            $konseling = Konseling::find($request->id_konseling);
            $konseling->status_konseling = 'Terjadwal';
            $konseling->save();

            return redirect()->route('dosen-konseling.jadwal.index')
                             ->with('success', 'Jadwal konseling berhasil dibuat.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan jadwal: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(JadwalKonseling $jadwal)
    {
         $dosen = Auth::user()->dosen;
         $dosenId = $dosen->id_dosen ?? $dosen->id;

         if ($jadwal->id_dosen_konseling != $dosenId) {
             abort(403, 'Anda tidak memiliki akses ke jadwal ini.');
         }
 
         return view('dosen-konseling.jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, JadwalKonseling $jadwal)
    {
        $dosen = Auth::user()->dosen;
        $dosenId = $dosen->id_dosen ?? $dosen->id;

        if ($jadwal->id_dosen_konseling != $dosenId) {
            abort(403);
        }

        $request->validate([
            'tanggal_konseling' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
            'metode_konseling' => 'required|string|in:Online,Offline',
            'lokasi' => 'nullable|string',
        ]);

        try {
            $waktu_mulai = Carbon::parse($request->waktu_mulai)->format('H:i:s');
            $waktu_selesai = Carbon::parse($request->waktu_selesai)->format('H:i:s');

            $jadwal->update([
                'tgl_sesi' => $request->tanggal_konseling,
                'waktu_mulai' => $waktu_mulai,
                'waktu_selesai' => $waktu_selesai,
                'metode_konseling' => $request->metode_konseling,
                'lokasi' => $request->lokasi,
            ]);

            return redirect()->route('dosen-konseling.jadwal.index')
                             ->with('success', 'Jadwal berhasil diperbarui.');
                             
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update jadwal: ' . $e->getMessage())->withInput();
        }
    }

    public function mulaiSesi(JadwalKonseling $jadwal)
    {
        $jadwal->load('konseling.mahasiswa.user');
        return view('dosen-konseling.jadwal.mulai-sesi', compact('jadwal'));
    }

    // ========== FITUR SIMPAN SESI (YANG DIPERBAIKI) ==========
    public function simpanSesi(Request $request, JadwalKonseling $jadwal)
    {
        // 1. Validasi Input (Harus sesuai dengan name di View mulai-sesi.blade.php)
        $request->validate([
            'hasil_konseling' => 'required|string|min:5',
            'rekomendasi' => 'nullable|string',
            'status_akhir' => 'required|in:Selesai,Butuh Sesi Lanjutan',
        ]);

        try {
            // 2. Simpan Hasil Konseling
            // Menggunakan updateOrCreate untuk mencegah duplikasi jika tombol ditekan 2x
            HasilKonseling::updateOrCreate(
                ['id_jadwal' => $jadwal->id_jadwal],
                [
                    'id_konseling' => $jadwal->id_konseling,
                    'tgl_konseling' => Carbon::now(),
                    'hasil_konseling' => $request->hasil_konseling,
                    'rekomendasi' => $request->rekomendasi,
                    // 'diagnosis' => $request->hasil_konseling, // Uncomment jika DB masih butuh kolom legacy
                ]
            );

            // 3. Update Status Sesi Jadwal -> Selesai
            // Asumsi ada kolom status_sesi di tabel jadwal_konseling (tambahkan jika belum ada di migration)
            // $jadwal->update(['status_sesi' => 'Selesai']); 

            // 4. Update Status Utama Konseling
            $konseling = $jadwal->konseling;
            $konseling->status_konseling = $request->status_akhir;
            $konseling->save();

            return redirect()->route('dosen-konseling.kasus.index')
                             ->with('success', 'Hasil sesi konseling berhasil disimpan dan status diperbarui.');

        } catch (\Exception $e) {
            // TANGKAP ERROR SQL: Ini akan memberi tahu kalau ada kolom database yang kurang
            return back()->with('error', 'Gagal menyimpan sesi: ' . $e->getMessage())->withInput();
        }
    }
}