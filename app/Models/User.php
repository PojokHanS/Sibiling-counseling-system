<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'username', // <--- TAMBAHKAN INI BRO
        'email',
        'password',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ... sisa method relasi di bawah (dosen, mahasiswa, konselingDosen) BIARKAN TETAP SAMA ...
    public function dosen(): HasOne
    {
        return $this->hasOne(Dosen::class, 'email_dos', 'email');
    }

    public function mahasiswa(): HasOne
    {
        return $this->hasOne(Mahasiswa::class, 'email', 'email');
    }

    public function konselingDosen(): HasMany
    {
        return $this->hasMany(KonselingDosen::class, 'email_dosen', 'email');
    }
}