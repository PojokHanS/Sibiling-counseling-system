<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KonselingDosen;
use Illuminate\Support\Facades\Auth;

class CurhatController extends Controller
{
    /**
     * AKTIF: Menampilkan pengajuan yang sedang berjalan.
     */
    public function index()
    {
        $riwayat = KonselingDosen::where('email_dosen', Auth::user()->email)
            ->whereIn('status_konseling', ['Menunggu Verifikasi', 'Dijadwalkan']) // <-- FILTER AKTIF
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dosen.curhat.index', compact('riwayat'));
    }

    /**
     * ARSIP: Menampilkan pengajuan yang sudah selesai.
     */
    public function riwayat()
    {
        $riwayat = KonselingDosen::where('email_dosen', Auth::user()->email)
            ->whereIn('status_konseling', ['Selesai', 'Ditolak']) // <-- FILTER ARSIP
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Kita pakai view yang sama (index) tapi datanya beda, atau view khusus.
        // Biar gampang, kita pakai view khusus biar judulnya beda.
        return view('dosen.curhat.riwayat', compact('riwayat'));
    }

    public function create()
    {
        return view('dosen.curhat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi_masalah' => 'required|string|min:20',
            'tujuan_konseling' => 'required|string|min:10',
            'tipe_konseli' => 'required|string',
        ]);

        KonselingDosen::create([
            'email_dosen' => Auth::user()->email,
            'tgl_pengajuan' => now(),
            'status_konseling' => 'Menunggu Verifikasi',
            'tipe_konseli' => $request->tipe_konseli,
            'deskripsi_masalah' => $request->deskripsi_masalah,
            'tujuan_konseling' => $request->tujuan_konseling,
        ]);

        return redirect()->route('dosen.curhat.index')
            ->with('success', 'Pengajuan konseling berhasil dikirim.');
    }
    /**
     * Menampilkan Detail Satu Pengajuan (Untuk melihat hasil).
     */
    public function show(KonselingDosen $konseling)
    {
        // KEAMANAN PENTING:
        // Pastikan Dosen hanya bisa melihat data miliknya sendiri!
        if ($konseling->email_dosen !== Auth::user()->email) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE DATA INI.');
        }

        return view('dosen.curhat.show', compact('konseling'));
    }
}