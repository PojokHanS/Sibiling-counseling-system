<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Prodi; // Pastikan punya model Prodi

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Matikan Foreign Key Check biar aman
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Bersihkan tabel (biar tidak duplikat saat seeding ulang)
        DB::table('prodi')->truncate();

        // Data yang sudah dibersihkan dan dipetakan dari SQL lama ke Tabel Baru
        // Format: [id_prodi, nm_prodi, id_jenjang_pendidikan]
        $dataProdi = [
            ['id_prodi' => '14201', 'nm_prodi' => 'Keperawatan', 'id_jenjang_pendidikan' => '30'],
            ['id_prodi' => '14901', 'nm_prodi' => 'Pendidikan Profesi Ners', 'id_jenjang_pendidikan' => '31'],
            ['id_prodi' => '15201', 'nm_prodi' => 'Kebidanan', 'id_jenjang_pendidikan' => '30'],
            ['id_prodi' => '15401', 'nm_prodi' => 'Kebidanan', 'id_jenjang_pendidikan' => '22'],
            ['id_prodi' => '15901', 'nm_prodi' => 'Pendidikan Profesi Bidan', 'id_jenjang_pendidikan' => '31'],
            ['id_prodi' => '55201', 'nm_prodi' => 'Ilmu Komputer', 'id_jenjang_pendidikan' => '30'],
            ['id_prodi' => '79219', 'nm_prodi' => 'Pendidikan Bahasa dan Sastra Aceh', 'id_jenjang_pendidikan' => '30'],
            ['id_prodi' => '84202', 'nm_prodi' => 'Pendidikan Matematika', 'id_jenjang_pendidikan' => '30'],
            ['id_prodi' => '84208', 'nm_prodi' => 'Pendidikan Ilmu Pengetahuan Alam', 'id_jenjang_pendidikan' => '30'],
            ['id_prodi' => '85201', 'nm_prodi' => 'Pendidikan Jasmani', 'id_jenjang_pendidikan' => '30'],
            ['id_prodi' => '86109', 'nm_prodi' => 'Penjaminan Mutu Pendidikan', 'id_jenjang_pendidikan' => '35'],
            ['id_prodi' => '86122', 'nm_prodi' => 'Pendidikan Dasar', 'id_jenjang_pendidikan' => '35'],
            ['id_prodi' => '86206', 'nm_prodi' => 'Pendidikan Guru Sekolah Dasar', 'id_jenjang_pendidikan' => '30'],
            ['id_prodi' => '86207', 'nm_prodi' => 'Pendidikan Guru Pendidikan Anak Usia Dini', 'id_jenjang_pendidikan' => '30'],
            ['id_prodi' => '86904', 'nm_prodi' => 'Pendidikan Profesi Guru', 'id_jenjang_pendidikan' => '31'],
            ['id_prodi' => '88201', 'nm_prodi' => 'Pendidikan Bahasa Indonesia', 'id_jenjang_pendidikan' => '30'],
            ['id_prodi' => '88203', 'nm_prodi' => 'Pendidikan Bahasa Inggris', 'id_jenjang_pendidikan' => '30'],
            ['id_prodi' => '88217', 'nm_prodi' => 'Pendidikan Seni Pertunjukan', 'id_jenjang_pendidikan' => '30'],
        ];

        foreach ($dataProdi as $prodi) {
            // Gunakan Query Builder untuk insert (Lebih cepat dan aman dari Model events)
            DB::table('prodi')->insert([
                'id_prodi' => $prodi['id_prodi'],
                'nm_prodi' => $prodi['nm_prodi'],
                'id_jenjang_pendidikan' => $prodi['id_jenjang_pendidikan'],
                // Kolom created_at/updated_at tidak perlu karena timestamps false di model/migrasi tidak ada
            ]);
        }

        // Hidupkan kembali Foreign Key Check
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('Data Prodi berhasil di-seed dengan sukses!');
    }
}