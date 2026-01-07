<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilKonseling extends Model
{
    use HasFactory;

    protected $table = 'hasil_konseling';
    protected $primaryKey = 'id_hasil';
    public $timestamps = false;

    // FIX: Tambahkan semua kolom baru agar bisa disimpan
    protected $fillable = [
        'id_jadwal',
        'id_konseling',
        'tgl_konseling',
        'hasil_konseling', // <--- INI YANG HILANG SEBELUMNYA
        'rekomendasi',
        'diagnosis',      // Legacy
        'prognosis',      // Legacy
        'evaluasi',       // Legacy
    ];

    protected $casts = [
        'tgl_konseling' => 'datetime',
    ];

    public function jadwalKonseling(): BelongsTo
    {
        return $this->belongsTo(JadwalKonseling::class, 'id_jadwal', 'id_jadwal');
    }
}