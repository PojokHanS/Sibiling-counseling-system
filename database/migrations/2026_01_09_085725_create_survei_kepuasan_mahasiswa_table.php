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
        Schema::create('survei_kepuasan_mahasiswa', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel konseling (PK: id_konseling integer)
            $table->unsignedInteger('id_konseling')->unique(); 
            $table->foreign('id_konseling')
                  ->references('id_konseling')
                  ->on('konseling')
                  ->onDelete('cascade');

            // 4 Pertanyaan Esai sesuai Dokumen
            $table->text('pemahaman_baru'); // Pengetahuan baru yg diperoleh
            $table->text('perasaan');       // Perasaan setelah layanan
            $table->text('tindakan');       // Tindakan yang akan dilakukan
            $table->text('tanggung_jawab'); // Tanggung jawab setelah layanan

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survei_kepuasan_mahasiswa');
    }
};