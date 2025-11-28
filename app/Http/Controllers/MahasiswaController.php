<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Menampilkan daftar mahasiswa.
     */
    public function index(Request $request)
    {
        // Load relasi prodi agar tidak query berulang (N+1 Problem)
        $query = Mahasiswa::query()->with('prodi'); 

        // Logika Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nm_mhs', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Urutkan berdasarkan Nama
        $mahasiswa = $query->orderBy('nm_mhs', 'asc')->paginate(10);

        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    /**
     * Menampilkan Form Tambah (Jika diperlukan nanti)
     */
    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    /**
     * MENAMPILKAN DETAIL LENGKAP MAHASISWA [FITUR BARU]
     */
    public function show(Mahasiswa $mahasiswa)
    {
        // Load relasi prodi dan dosen wali biar datanya lengkap di view
        $mahasiswa->load(['prodi', 'dosenWali']);
        
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Menampilkan Form Edit
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    // Method store, update, destroy bisa ditambahkan sesuai kebutuhan...
}