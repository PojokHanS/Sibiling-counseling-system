<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveiKepuasanMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'survei_kepuasan_mahasiswa';

    protected $fillable = [
        'id_konseling',
        'pemahaman_baru',
        'perasaan',
        'tindakan',
        'tanggung_jawab',
    ];

    /**
     * Relasi balik ke Konseling
     */
    public function konseling(): BelongsTo
    {
        return $this->belongsTo(Konseling::class, 'id_konseling', 'id_konseling');
    }
}