<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query Dasar
        $query = Dosen::query();

        // Logika Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // PERBAIKAN: Gunakan 'nm_dos' sesuai database
                $q->where('nm_dos', 'like', "%{$search}%")
                  ->orWhere('nidn', 'like', "%{$search}%")
                  ->orWhere('email_dos', 'like', "%{$search}%");
            });
        }

        // Urutkan dan Paginate (PERBAIKAN: order by nm_dos)
        $dosen = $query->orderBy('nm_dos', 'asc')->paginate(10);

        return view('admin.dosen.index', compact('dosen'));
    }

    public function create()
    {
        return view('admin.dosen.create');
    }

    public function edit(Dosen $dosen)
    {
        return view('admin.dosen.edit', compact('dosen'));
    }

    public function destroy(Dosen $dosen)
    {
        $dosen->delete();
        return redirect()->route('admin.dosen.index')->with('success', 'Data dosen berhasil dihapus.');
    }
    
    // Method store dan update bisa ditambahkan nanti sesuai kebutuhan form
}