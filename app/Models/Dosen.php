<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // Cukup satu kali saja

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $primaryKey = 'nidn'; // Primary Key tabel dosen biasanya NIDN
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    /**
     * Relasi ke User (Login)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email_dos', 'email');
    }

    /**
     * Relasi: Dosen memiliki BANYAK Mahasiswa Bimbingan (Anak Wali)
     */
    public function mahasiswaWali(): HasMany
    {
        // Parameter: (Model Tujuan, FK di tabel Mahasiswa, Local Key di tabel Dosen)
        // Kita hubungkan id_dosen_wali (di mhs) dengan email_dos (di dosen)
        return $this->hasMany(Mahasiswa::class, 'id_dosen_wali', 'email_dos');
    }
}