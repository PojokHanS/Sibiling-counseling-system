<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * Relasi ke Program Studi
     */
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id_prodi');
    }

    /**
     * Relasi ke Dosen Wali (Pembimbing Akademik)
     * PERBAIKAN: Hubungkan ke 'email_dos' karena ID yang disimpan adalah Email
     */
    public function dosenWali(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'id_dosen_wali', 'email_dos');
    }
}