<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'tgl_lahir' => 'date',
            'tgl_masuk_kuliah' => 'date',
            'tgl_sk_yudisium' => 'date',
        ];
    }

    /**
     * Relasi ke User (Akun Login)
     * PENTING: Menghubungkan data mahasiswa ke tabel users via email.
     */
    public function user(): BelongsTo
    {
        // Parameter: (Model Tujuan, Foreign Key di tabel ini, Owner Key di tabel tujuan)
        return $this->belongsTo(User::class, 'email', 'email');
    }

    /**
     * Relasi ke Program Studi
     */
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id_prodi');
    }

    /**
     * Relasi ke Dosen Wali (Pembimbing Akademik)
     */
    public function dosenWali(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'id_dosen_wali', 'email_dos');
    }
}