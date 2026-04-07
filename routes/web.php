<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrasiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegistrasiController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrasiController::class, 'register']);

// Admin Auth Routes
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::get('/admin', function () {
    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('admin.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/aspirasi/create', [AspirasiController::class, 'create'])->name('aspirasi.create');
    Route::post('/aspirasi', [AspirasiController::class, 'store'])->name('aspirasi.store');
    Route::get('/aspirasi/my', [AspirasiController::class, 'myAspirasi'])->name('aspirasi.my');
    Route::get('/aspirasi/{id}', [AspirasiController::class, 'show'])->name('aspirasi.show');
    Route::get('/aspirasi/{id}/edit', [AspirasiController::class, 'edit'])->name('aspirasi.edit');
    Route::put('/aspirasi/{id}', [AspirasiController::class, 'update'])->name('aspirasi.update');
    Route::delete('/aspirasi/{id}', [AspirasiController::class, 'destroy'])->name('aspirasi.destroy');
});

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/aspirasi', [AdminController::class, 'listAspirasi'])->name('aspirasi-list');
    Route::get('/aspirasi/{id}', [AdminController::class, 'detailAspirasi'])->name('aspirasi-detail');
    Route::patch('/aspirasi/{id}/status', [AdminController::class, 'updateStatus'])->name('aspirasi-update-status');
    Route::put('/aspirasi/{id}/feedback', [AdminController::class, 'addFeedback'])->name('aspirasi-add-feedback');
    Route::get('/laporan/tanggal', [AdminController::class, 'laporanPerTanggal'])->name('laporan-tanggal');
    Route::get('/laporan/bulan', [AdminController::class, 'laporanPerBulan'])->name('laporan-bulan');
    Route::get('/laporan/siswa', [AdminController::class, 'laporanPerSiswa'])->name('laporan-siswa');
    Route::get('/laporan/kategori', [AdminController::class, 'laporanPerKategori'])->name('laporan-kategori');
});
