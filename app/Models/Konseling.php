<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Konseling extends Model
{
    use HasFactory;

    protected $table = 'konseling';
    protected $primaryKey = 'id_konseling';
    public $timestamps = false;

    // ================== SEMUA KOLOM (LAMA & BARU) ==================
    protected $fillable = [
        // 1. Kolom Database Lama
        'nim_mahasiswa', 
        'id_dosen_wali', 
        'tgl_pengajuan', 
        'permasalahan',
        'status_konseling', 
        'rekomendation_dari', 
        'sumber_pengajuan',
        'harapan_konseling', 
        'alasan_penolakan',
        
        // 2. Kolom SOP Dosen Wali
        'aspek_permasalahan', 
        'permasalahan_segera', 
        'upaya_dilakukan', 
        'harapan_pa',
        
        // 3. Kolom Form Mahasiswa (Modern)
        'deskripsi_masalah',
        'tujuan_konseling', 
        'persetujuan_diberikan_pada', 
        'tipe_konseli',               
        'jenis_permasalahan',         
        'asesmen_k10',                
    ];

    protected $casts = [
        'tgl_pengajuan' => 'date',
        'aspek_permasalahan' => 'json',
        'jenis_permasalahan' => 'json', 
        'asesmen_k10' => 'json',        
    ];

    /**
     * Relasi ke Mahasiswa
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'nim_mahasiswa', 'nim');
    }
    
    /**
     * Relasi ke Jadwal Sesi (Banyak jadwal)
     */
    public function jadwalSesi(): HasMany
    {
        return $this->hasMany(JadwalKonseling::class, 'id_konseling', 'id_konseling');
    }

    /**
     * Relasi ke Dosen Wali
     */
    public function dosenWali(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'id_dosen_wali', 'email_dos');
    }

    /**
     * Relasi ke Hasil Konseling (FIX ERROR 500)
     * Menggunakan HasOneThrough: Konseling -> Jadwal -> Hasil
     */
    public function hasilKonseling(): HasOneThrough
    {
        return $this->hasOneThrough(
            HasilKonseling::class,      // Model Tujuan (Hasil)
            JadwalKonseling::class,     // Model Perantara (Jadwal)
            'id_konseling',             // FK di tabel Jadwal (menunjuk ke Konseling)
            'id_jadwal',                // FK di tabel Hasil (menunjuk ke Jadwal)
            'id_konseling',             // Local Key di tabel Konseling
            'id_jadwal'                 // Local Key di tabel Jadwal (Primary Key: id_jadwal) <--- PERBAIKAN DISINI
        );
    }
}