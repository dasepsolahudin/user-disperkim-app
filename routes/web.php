<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomepageController; // <-- BARIS INI PENTING
use App\Http\Controllers\ComplaintController; // <-- Kita tambahkan ini juga untuk nanti
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth; // Tambahkan ini jika belum ada
use App\Models\Complaint;            // Tambahkan ini jika belum ada

// Rute untuk Halaman Utama
Route::get('/', [HomepageController::class, 'index']);

// Rute-rute yang berhubungan dengan UserController (sudah ada sebelumnya)
Route::get('/register', [UserController::class, 'create']);
Route::post('/register', [UserController::class, 'store']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}/edit', [UserController::class, 'edit']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);

// Rute untuk Dashboard (Setelah Login)
Route::get('/dashboard', function () {
    $user = Auth::user();

    // Ambil statistik khusus untuk user yang login
    $stats = [
        'total' => Complaint::where('user_id', $user->id)->count(),
        'in_progress' => Complaint::where('user_id', $user->id)->where('status', 'Pengerjaan')->count(),
        'completed' => Complaint::where('user_id', $user->id)->where('status', 'Selesai')->count(),
    ];

    return view('dashboard', ['stats' => $stats]);
})->middleware(['auth', 'verified'])->name('dashboard');

// GRUP UNTUK PENGGUNA YANG SUDAH LOGIN
Route::middleware('auth')->group(function () {
    // Rute untuk menampilkan form buat pengaduan
    Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Ini memuat semua rute autentikasi (login, logout, dll)
require __DIR__.'/auth.php';