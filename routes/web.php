<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController as AdminUserController;
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
        'in_progress' => Complaint::where('user_id', $user->id)->where('status', 'pending')->count(),
        'completed' => Complaint::where('user_id', $user->id)->whereIn('status', ['approved', 'rejected'])->count(),
    ];

    return view('dashboard', [
        'stats' => $stats,
        'user'  => $user, // kirim juga user ke view kalau perlu
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');



// GRUP UNTUK PENGGUNA YANG SUDAH LOGIN
Route::middleware('auth')->group(function () {
    // Rute untuk menampilkan form buat pengaduan
    Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store'); // <-- TAMBAHKAN INI
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index'); // <-- TAMBAHKAN INI
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::get('/complaints/create/{category}', [ComplaintController::class, 'showForm'])->name('complaints.form');
    
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});
// Ini memuat semua rute autentikasi (login, logout, dll)
require __DIR__.'/auth.php';