<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleAssignmentController extends Controller
{
    /**
     * Menampilkan daftar Dosen untuk manajemen Role.
     */
    public function index(Request $request)
    {
        // Query Dasar: Ambil User yang punya data di tabel 'dosen' (Relasi 'dosen' ada di Model User)
        // Kita juga load 'roles' biar tidak query berulang di view
        $query = User::has('dosen')->with('roles');

        // Fitur Pencarian (Search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Ambil data dengan pagination (10 per halaman)
        $users = $query->paginate(10);

        return view('admin.roles.index', compact('users'));
    }

    /**
     * Menampilkan form edit role user tertentu.
     */
    public function edit(User $user)
    {
        // Ambil semua role yang tersedia untuk ditampilkan di checkbox
        $roles = Role::all();
        return view('admin.roles.edit', compact('user', 'roles'));
    }

    /**
     * Menyimpan perubahan role.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array'
        ]);

        // Sinkronisasi Role (Hapus yang lama, pasang yang baru sesuai checkbox)
        // Jika tidak ada yang dicentang, rolenya jadi kosong (User biasa)
        $user->syncRoles($request->input('roles', []));

        return redirect()->route('admin.roles.index')
            ->with('success', 'Jabatan pengguna berhasil diperbarui.');
    }
}