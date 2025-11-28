<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class WarekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Role 'warek' jika belum ada
        $roleWarek = Role::firstOrCreate(['name' => 'warek', 'guard_name' => 'web']);

        // 2. Buat User Dummy untuk Warek
        $emailWarek = 'warek@kampus.ac.id';
        
        $warekUser = User::firstOrCreate(
            ['email' => $emailWarek],
            [
                'name' => 'Ibu Wakil Rektor',
                'username' => 'warek', // <--- TAMBAHKAN INI JUGA
                'password' => Hash::make('password'), 
                'email_verified_at' => now(),
            ]
        );

        // 3. Assign Role 'warek'
        if (!$warekUser->hasRole('warek')) {
            $warekUser->assignRole($roleWarek);
            $this->command->info('Sukses: Role warek berhasil diberikan ke user ' . $emailWarek);
        } else {
            $this->command->warn('Info: User ' . $emailWarek . ' sudah memiliki role warek.');
        }
    }
}