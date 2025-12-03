<?php

namespace App\Http\Controllers\DosenPembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Dosen;

class MahasiswaBimbinganController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Pastikan User punya data Dosen
        if (!$user->dosen) {
            return redirect()->route('dashboard')->with('error', 'Profil Dosen tidak ditemukan.');
        }

        $dosen = $user->dosen;

        // Query Mahasiswa Bimbingan
        // Kita ambil relasi 'mahasiswaWali' yang sudah kita buat di Model Dosen
        $query = $dosen->mahasiswaWali()
                       ->with('user', 'prodi'); // Eager load user & prodi

        // Filter Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                  ->orWhereHas('user', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Pagination
        $mahasiswaBimbingan = $query->orderBy('nim', 'asc')->paginate(10);

        // Arahkan ke view yang benar (folder structure)
        return view('dosen-pembimbing.mahasiswa.index', compact('mahasiswaBimbingan'));
    }
}