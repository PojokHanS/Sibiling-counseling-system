<?php

namespace App\Http\Controllers\Warek;

use App\Http\Controllers\Controller;
use App\Models\KonselingDosen;
use Illuminate\Http\Request;

class KonselingController extends Controller
{
    /**
     * DASHBOARD UTAMA: Statistik & Overview.
     */
    public function dashboard()
    {
        // 1. Hitung Statistik
        $totalMasuk = KonselingDosen::count();
        
        $perluTindakan = KonselingDosen::where('status_konseling', 'Menunggu Verifikasi')->count();
        
        $jadwalAktif = KonselingDosen::where('status_konseling', 'Dijadwalkan')
            ->where('jadwal_konseling', '>=', now())
            ->count();

        $selesaiBulanIni = KonselingDosen::whereIn('status_konseling', ['Selesai', 'Ditolak'])
            ->whereMonth('updated_at', now()->month)
            ->count();

        // 2. Ambil 5 Aktivitas Terbaru (Gabungan masuk & selesai)
        $terbaru = KonselingDosen::with('user')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        return view('warek.dashboard', compact('totalMasuk', 'perluTindakan', 'jadwalAktif', 'selesaiBulanIni', 'terbaru'));
    }

    /**
     * INBOX: Hanya menampilkan status AKTIF (Menunggu & Dijadwalkan).
     */
    public function index()
    {
        $konseling = KonselingDosen::with('user')
            ->whereIn('status_konseling', ['Menunggu Verifikasi', 'Dijadwalkan']) // <-- FILTER AKTIF
            ->orderByRaw("FIELD(status_konseling, 'Menunggu Verifikasi', 'Dijadwalkan')")
            ->orderBy('created_at', 'asc') // Yang lama didahulukan biar cepat diproses
            ->paginate(10);

        return view('warek.konseling.index', compact('konseling'));
    }

    /**
     * RIWAYAT: Hanya menampilkan status SELESAI & DITOLAK.
     */
    public function riwayat()
    {
        $konseling = KonselingDosen::with('user')
            ->whereIn('status_konseling', ['Selesai', 'Ditolak']) // <-- FILTER RIWAYAT
            ->orderBy('updated_at', 'desc') // Yang baru selesai di atas
            ->paginate(10);

        return view('warek.konseling.riwayat', compact('konseling'));
    }

    public function show(KonselingDosen $konseling)
    {
        $konseling->load('user');
        return view('warek.konseling.show', compact('konseling'));
    }

    public function update(Request $request, KonselingDosen $konseling)
    {
        $request->validate([
            'status_konseling' => 'required|string',
            'catatan_warek' => 'required|string|min:5',
            'jadwal_konseling' => 'nullable|required_if:status_konseling,Dijadwalkan|date',
            'lokasi_konseling' => 'nullable|required_if:status_konseling,Dijadwalkan|string',
        ]);

        $konseling->update([
            'status_konseling' => $request->status_konseling,
            'catatan_warek' => $request->catatan_warek,
            'jadwal_konseling' => $request->jadwal_konseling,
            'lokasi_konseling' => $request->lokasi_konseling,
        ]);

        // Redirect cerdas: Kalau statusnya Selesai/Ditolak, arahkan ke Riwayat. Kalau masih proses, ke Index.
        if (in_array($request->status_konseling, ['Selesai', 'Ditolak'])) {
            return redirect()->route('warek.konseling.riwayat')
                ->with('success', 'Kasus telah diselesaikan dan dipindahkan ke Riwayat.');
        }

        return redirect()->route('warek.konseling.index')
            ->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}