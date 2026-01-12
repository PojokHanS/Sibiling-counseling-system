<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function landasanHukum()
    {
        // Data Dokumen SK & SOP
        $dokumen = [
            [
                'judul' => 'SOP Layanan Bimbingan Konseling',
                'nomor' => 'SOP-0001/UPBK/IX/2025',
                'tahun' => '2025',
                'deskripsi' => 'Pedoman standar alur pendaftaran, pelaksanaan konseling, hingga evaluasi. Wajib dibaca oleh mahasiswa sebelum mengajukan konseling.',
                'file' => 'sop-bk-2025.pdf', 
                'kategori' => 'SOP'
            ],
            [
                'judul' => 'Kebijakan Pengelolaan & Fungsi UPBK',
                'nomor' => '0470/131013/RKT/SK/IX/2025',
                'tahun' => '2025',
                'deskripsi' => 'Landasan operasional yang mengatur jenis pelayanan (Pribadi, Sosial, Akademik, Karir) serta tugas dan fungsi konselor di UBBG.',
                'file' => 'sk-kebijakan-2025.pdf',
                'kategori' => 'SK Rektor'
            ],
            [
                'judul' => 'SK Pembentukan Unit Layanan Kesehatan & BK',
                'nomor' => '1740/131013/SK/V/2021',
                'tahun' => '2021',
                'deskripsi' => 'Surat Keputusan pendirian resmi Unit Layanan Kesehatan dan Bimbingan Konseling sebagai wadah konsultasi preventif dan kuratif.',
                'file' => 'sk-pembentukan-2021.pdf',
                'kategori' => 'SK Rektor'
            ],
        ];

        return view('public.landasan-hukum', compact('dokumen'));
    }

    public function tentangKami()
    {
        $aboutWeb = [
            'judul' => 'Menghubungkan Hati, Menyelesaikan Masalah',
            'deskripsi' => 'SiBiling (Sistem Bimbingan Konseling) hadir sebagai respons digital terhadap kebutuhan kesehatan mental di lingkungan UBBG. Kami percaya bahwa setiap mahasiswa berhak mendapatkan akses layanan konseling yang privat, mudah, dan profesional tanpa stigma.',
            'visi' => 'Mewujudkan civitas akademika UBBG yang sehat mental, berkarakter, dan prestatif melalui layanan konseling yang terintegrasi.'
        ];

        // --- DATA TIM PENGEMBANG ---
        $tim = [
            [
                'nama' => 'Gempur Budi Anarki',
                'role' => 'Back End Developer',
                'prodi' => 'S1 Ilmu Komputer',
                'foto' => 'images/gempur.png', 
                'bio' => 'Bertanggung jawab merancang arsitektur server yang kokoh, keamanan data, serta memastikan logika sistem berjalan efisien dan stabil.',
                'github' => 'https://github.com/gempurbudianarki',
            ],
            [
                'nama' => 'Muhamad Adzky Maulana',
                'role' => 'Front End Developer',
                'prodi' => 'S1 Ilmu Komputer',
                'foto' => 'images/adzky.png', 
                'bio' => 'Mengubah desain menjadi antarmuka web yang responsif, interaktif, dan memastikan pengalaman pengguna (UX) yang mulus di berbagai perangkat.',
                'github' => 'https://github.com/kyyyyyykyyy', 
            ],
            [
                'nama' => 'Farhan Alfarisi',
                'role' => 'UI/UX Designer',
                'prodi' => 'S1 Ilmu Komputer',
                'foto' => 'images/farhan.png', 
                'bio' => 'Menciptakan desain visual yang estetis dan intuitif, menjembatani kebutuhan pengguna dengan solusi tampilan yang modern dan mudah dipahami.',
                'github' => 'https://github.com/PojokHanS',
            ],
        ];

        return view('public.tentang-kami', compact('aboutWeb', 'tim'));
    }
}
