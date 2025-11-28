<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('konseling_dosen', function (Blueprint $table) {
            // Primary Key
            $table->id('id_konseling_dosen');
            
            // Identitas Pengaju (Dosen) - Menggunakan Email sesuai request
            $table->string('email_dosen')->index(); 
            
            // Tanggal Pengajuan
            $table->dateTime('tgl_pengajuan')->useCurrent();
            
            // Status Konseling
            // Opsi: 'Menunggu Verifikasi', 'Dijadwalkan', 'Selesai', 'Ditolak'
            $table->string('status_konseling')->default('Menunggu Verifikasi');
            
            // Data Konseling (Kita samakan strukturnya dengan mahasiswa biar standar)
            $table->string('tipe_konseli')->default('Dosen'); // Default Dosen
            $table->text('deskripsi_masalah'); // Cerita masalahnya
            $table->text('tujuan_konseling'); // Harapan dari konseling
            
            // Asesmen Mental (Opsional buat dosen, tapi bagus kalau ada)
            // Kita simpan sebagai JSON biar fleksibel kalau pertanyaannya beda
            $table->json('asesmen_mandiri')->nullable(); 
            
            // Feedback / Respon dari Warek (Pengganti rekomendasi dosen wali)
            $table->text('catatan_warek')->nullable();
            
            // Penjadwalan (Opsional, diisi nanti saat disetujui)
            $table->dateTime('jadwal_konseling')->nullable();
            $table->string('lokasi_konseling')->nullable();
            
            // Timestamps (created_at, updated_at)
            $table->timestamps();
            
            // Foreign Key Constraint (Opsional tapi Recommended)
            // Menjaga agar email yang masuk benar-benar ada di tabel users
            // Kalau user dihapus, data konseling ikut kehapus (cascade) atau tetap ada
            $table->foreign('email_dosen')
                  ->references('email')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konseling_dosen');
    }
};