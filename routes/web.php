<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\Admin\RoleAssignmentController;
use App\Http\Controllers\PublicController;

// Dosen Konseling Feature Controllers
use App\Http\Controllers\DosenKonseling\PengajuanController;
use App\Http\Controllers\DosenKonseling\JadwalController;
use App\Http\Controllers\DosenKonseling\KasusController;

// Dosen Pembimbing Feature Controllers
use App\Http\Controllers\DosenPembimbing\MahasiswaBimbinganController;
use App\Http\Controllers\DosenPembimbing\RekomendasiController;

// Mahasiswa Feature Controllers
use App\Http\Controllers\Mahasiswa\PengajuanController as MahasiswaPengajuanController;
use App\Http\Controllers\Mahasiswa\RiwayatController as MahasiswaRiwayatController;

// Controller Fitur Lanjutan
use App\Http\Controllers\Warek\KonselingController as WarekKonselingController;
use App\Http\Controllers\Dosen\CurhatController as CurhatDosenController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ================== PUBLIC ROUTES ==================
Route::controller(PublicController::class)->group(function () {
    Route::get('/', 'welcome')->name('welcome');
    Route::get('/landasan-hukum', 'landasanHukum')->name('public.landasan');
    Route::get('/tentang-kami', 'tentangKami')->name('public.tentang');
});

// ================== MAIN DASHBOARD ==================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ======================== ADMIN ROUTES ========================
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('dosen', DosenController::class);
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::get('assign-roles', [RoleAssignmentController::class, 'index'])->name('roles.index');
    Route::get('assign-roles/{user}/edit', [RoleAssignmentController::class, 'edit'])->name('roles.edit');
    Route::put('assign-roles/{user}', [RoleAssignmentController::class, 'update'])->name('roles.update');
});

// ======================== WAREK ROUTES ========================
Route::middleware(['auth', 'verified', 'role:warek'])->prefix('warek')->name('warek.')->group(function () {
    Route::get('/dashboard', [WarekKonselingController::class, 'dashboard'])->name('dashboard');
    Route::get('/konseling', [WarekKonselingController::class, 'index'])->name('konseling.index');
    Route::get('/riwayat', [WarekKonselingController::class, 'riwayat'])->name('konseling.riwayat');
    Route::get('/konseling/{konseling}', [WarekKonselingController::class, 'show'])->name('konseling.show');
    Route::put('/konseling/{konseling}', [WarekKonselingController::class, 'update'])->name('konseling.update');
});

// ======================== DOSEN CURHAT ROUTES ========================
Route::middleware(['auth', 'verified'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/curhat', [CurhatDosenController::class, 'index'])->name('curhat.index');
    Route::get('/curhat/riwayat', [CurhatDosenController::class, 'riwayat'])->name('curhat.riwayat');
    Route::get('/curhat/create', [CurhatDosenController::class, 'create'])->name('curhat.create'); 
    Route::post('/curhat', [CurhatDosenController::class, 'store'])->name('curhat.store');
    Route::get('/curhat/{konseling}', [CurhatDosenController::class, 'show'])->name('curhat.show');
});

// ================== DOSEN KONSELING ROUTES ==================
Route::middleware(['auth', 'verified', 'role:dosen_konseling'])->prefix('dosen-konseling')->name('dosen-konseling.')->group(function () {
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/{pengajuan}', [PengajuanController::class, 'show'])->name('pengajuan.show');
    Route::put('/pengajuan/{pengajuan}/status', [PengajuanController::class, 'updateStatus'])->name('pengajuan.updateStatus');

    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/create/{pengajuan}', [JadwalController::class, 'create'])->name('jadwal.create');
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    
    // --- UPDATE FITUR: EDIT JADWAL ---
    Route::get('/jadwal/{jadwal}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal/{jadwal}', [JadwalController::class, 'update'])->name('jadwal.update');
    // ---------------------------------

    Route::get('/jadwal/{jadwal}/mulai-sesi', [JadwalController::class, 'mulaiSesi'])->name('jadwal.mulaiSesi');
    Route::post('/jadwal/{jadwal}/simpan-sesi', [JadwalController::class, 'simpanSesi'])->name('jadwal.simpanSesi');

    Route::get('/kasus', [KasusController::class, 'index'])->name('kasus.index');
    Route::get('/kasus/{konseling}', [KasusController::class, 'show'])->name('kasus.show');
});

// ================== DOSEN PEMBIMBING ROUTES ==================
Route::middleware(['auth', 'verified', 'role:dosen_pembimbing'])->prefix('dosen-pembimbing')->name('dosen-pembimbing.')->group(function () {
    Route::get('/mahasiswa', [MahasiswaBimbinganController::class, 'index'])->name('mahasiswa');
    Route::get('/rekomendasi', [RekomendasiController::class, 'index'])->name('rekomendasi.index');
    Route::get('/rekomendasi/create/{mahasiswa}', [RekomendasiController::class, 'create'])->name('rekomendasi.create');
    Route::post('/rekomendasi', [RekomendasiController::class, 'store'])->name('rekomendasi.store');
    Route::get('/rekomendasi/{rekomendasi}/edit', [RekomendasiController::class, 'edit'])->name('rekomendasi.edit');
    Route::put('/rekomendasi/{rekomendasi}', [RekomendasiController::class, 'update'])->name('rekomendasi.update');
    Route::get('/riwayat-rekomendasi', [RekomendasiController::class, 'riwayat'])->name('rekomendasi.riwayat');
});

// ================== MAHASISWA ROUTES ==================
Route::middleware(['auth', 'verified', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/pengajuan/create', [MahasiswaPengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan', [MahasiswaPengajuanController::class, 'store'])->name('pengajuan.store');
    Route::get('/pengajuan/{konseling}/lengkapi', [MahasiswaPengajuanController::class, 'lengkapi'])->name('pengajuan.lengkapi');
    Route::put('/pengajuan/{konseling}/lengkapi', [MahasiswaPengajuanController::class, 'updateLengkapan'])->name('pengajuan.updateLengkapan');
    Route::get('/pengajuan/{konseling}/edit', [MahasiswaPengajuanController::class, 'edit'])->name('pengajuan.edit');
    Route::put('/pengajuan/{konseling}', [MahasiswaPengajuanController::class, 'update'])->name('pengajuan.update');
    Route::get('/riwayat', [MahasiswaRiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{konseling}', [MahasiswaRiwayatController::class, 'show'])->name('riwayat.show');
});

require __DIR__.'/auth.php';