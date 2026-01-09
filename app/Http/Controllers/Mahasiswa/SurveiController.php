<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Konseling;
use App\Models\SurveiKepuasanMahasiswa;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;

class SurveiController extends Controller
{
    /**
     * Menampilkan Form Survei (Hanya jika Status Selesai & Belum isi survei)
     */
    public function create(Konseling $konseling)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        // 1. Cek Kepemilikan
        if ($konseling->nim_mahasiswa !== $mahasiswa->nim) {
            abort(403, 'Akses Ditolak. Ini bukan data konseling Anda.');
        }

        // 2. Cek Status Konseling
        if ($konseling->status_konseling !== 'Selesai') {
            return redirect()->route('mahasiswa.riwayat.index')
                ->with('error', 'Survei hanya dapat diisi setelah konseling dinyatakan SELESAI oleh Dosen.');
        }

        // 3. Cek Apakah Sudah Pernah Isi?
        if ($konseling->surveiKepuasan()->exists()) {
            return redirect()->route('mahasiswa.riwayat.show', $konseling->id_konseling)
                ->with('info', 'Anda sudah mengisi survei untuk sesi ini.');
        }

        return view('mahasiswa.survei.create', compact('konseling', 'mahasiswa'));
    }

    /**
     * Menyimpan Jawaban Survei
     */
    public function store(Request $request, Konseling $konseling)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        if ($konseling->nim_mahasiswa !== $mahasiswa->nim || $konseling->status_konseling !== 'Selesai') {
            abort(403);
        }

        $request->validate([
            'pemahaman_baru' => 'required|string|min:10',
            'perasaan'       => 'required|string|min:10',
            'tindakan'       => 'required|string|min:10',
            'tanggung_jawab' => 'required|string|min:10',
        ]);

        SurveiKepuasanMahasiswa::create([
            'id_konseling'   => $konseling->id_konseling,
            'pemahaman_baru' => $request->pemahaman_baru,
            'perasaan'       => $request->perasaan,
            'tindakan'       => $request->tindakan,
            'tanggung_jawab' => $request->tanggung_jawab,
        ]);

        return redirect()->route('mahasiswa.riwayat.show', $konseling->id_konseling)
            ->with('success', 'Terima kasih! Survei evaluasi berhasil disimpan. Silakan unduh bukti survei Anda.');
    }

    /**
     * Generate & Download Word Document (.docx) dari Template
     */
    public function download(Konseling $konseling)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        // Validasi Akses
        if ($konseling->nim_mahasiswa !== $mahasiswa->nim) {
            abort(403);
        }

        $survei = $konseling->surveiKepuasan;
        if (!$survei) {
            return redirect()->back()->with('error', 'Data survei tidak ditemukan.');
        }

        // 1. Lokasi Template Master (Pastikan file ini ada!)
        // Nama file disesuaikan dengan yang kamu edit: 'template_survei.docx'
        $templatePath = storage_path('app/templates/template_survei.docx');

        // Cek apakah file template ada
        if (!file_exists($templatePath)) {
            abort(500, 'File template surat tidak ditemukan di server (storage/app/templates/template_survei.docx). Pastikan Anda sudah mengupload file Word yang sudah diedit ke folder tersebut.');
        }

        try {
            // 2. Proses Template
            $templateProcessor = new TemplateProcessor($templatePath);

            // --- DATA UTAMA ---
            $templateProcessor->setValue('nama', $mahasiswa->user->name);
            $templateProcessor->setValue('nim', $mahasiswa->nim);
            $templateProcessor->setValue('prodi', $mahasiswa->prodi->nama_prodi ?? '-');
            
            // --- DATA TAMBAHAN (Sesuai Form Asli) ---
            $templateProcessor->setValue('email', $mahasiswa->email ?? '-');
            $templateProcessor->setValue('nohp', $mahasiswa->no_hp ?? '-');
            
            // Format TTL (Tempat, d F Y) - Asumsi ada kolom tempat_lahir, kalau tidak ada pakai default
            $tempat = $mahasiswa->tempat_lahir ?? 'Banda Aceh'; 
            $tglLahir = $mahasiswa->tgl_lahir ? Carbon::parse($mahasiswa->tgl_lahir)->translatedFormat('d F Y') : '-';
            $templateProcessor->setValue('ttl', "$tempat, $tglLahir");
            
            $templateProcessor->setValue('alamat', $mahasiswa->alamat ?? '-'); // Pastikan ada kolom alamat di DB, atau kosongkan jika null

            // Format Tanggal Surat (Hari ini)
            $tanggalIndo = Carbon::now()->translatedFormat('d F Y');
            $templateProcessor->setValue('tanggal', $tanggalIndo);

            // --- JAWABAN ESAI ---
            // Menggunakan fixNewLines() agar enter di textarea terbaca di Word
            $templateProcessor->setValue('jawaban_1', str_replace("\n", "<w:br/>", $survei->pemahaman_baru));
            $templateProcessor->setValue('jawaban_2', str_replace("\n", "<w:br/>", $survei->perasaan));
            $templateProcessor->setValue('jawaban_3', str_replace("\n", "<w:br/>", $survei->tindakan));
            $templateProcessor->setValue('jawaban_4', str_replace("\n", "<w:br/>", $survei->tanggung_jawab));

            // 4. Simpan ke File Temporary
            $fileName = 'Bukti_Evaluasi_' . $mahasiswa->nim . '_' . $konseling->id_konseling . '.docx';
            $tempPath = storage_path('app/public/' . $fileName);
            
            $templateProcessor->saveAs($tempPath);

            // 5. Download & Hapus File Temp setelah dikirim
            return response()->download($tempPath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses dokumen: ' . $e->getMessage());
        }
    }
}