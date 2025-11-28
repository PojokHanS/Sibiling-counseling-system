<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KonselingDosen extends Model
{
    use HasFactory;

    // Nama tabel eksplisit karena tidak mengikuti konvensi plural standar Laravel (konseling_dosens)
    protected $table = 'konseling_dosen';

    // Primary Key sesuai migrasi
    protected $primaryKey = 'id_konseling_dosen';

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'email_dosen',
        'tgl_pengajuan',
        'status_konseling',
        'tipe_konseli',
        'deskripsi_masalah',
        'tujuan_konseling',
        'asesmen_mandiri', // Akan disimpan dalam format JSON
        'catatan_warek',
        'jadwal_konseling',
        'lokasi_konseling',
    ];

    // Casting tipe data agar otomatis dikonversi oleh Laravel
    protected function casts(): array
    {
        return [
            'tgl_pengajuan' => 'datetime',
            'jadwal_konseling' => 'datetime',
            'asesmen_mandiri' => 'array', // Otomatis ubah JSON di database jadi Array PHP
        ];
    }

    /**
     * Relasi: Konseling ini milik siapa?
     * Menghubungkan email_dosen di tabel ini ke email di tabel users
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email_dosen', 'email');
    }
}