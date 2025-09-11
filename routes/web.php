<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaduanController; // <-- Tambahkan ini biar lebih rapi
use Illuminate\Support\Facades\Auth;
use App\Models\Complaint;
use App\Http\Controllers\UserController;


// Rute untuk Halaman Utama
Route::get('/', [HomepageController::class, 'index']);

// Rute-rute yang berhubungan dengan UserController
Route::get('/register', [UserController::class, 'create']);
Route::post('/register', [UserController::class, 'store']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}/edit', [UserController::class, 'edit']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);
Route::get('/', [HomepageController::class, 'index'])->name('homepage');
Route::get('/pengaduan/{complaint}', [PengaduanController::class, 'show'])->name('pengaduan.show');

// Rute untuk Dashboard (Setelah Login)
Route::get('/dashboard', function () {
    $user = Auth::user();

    $stats = [
        'total'       => Complaint::where('user_id', $user->id)->count(),
        'in_progress' => Complaint::where('user_id', $user->id)->where('status', 'pending')->count(),
        'completed'   => Complaint::where('user_id', $user->id)->whereIn('status', ['approved', 'rejected'])->count(),
    ];

    return view('dashboard', [
        'stats' => $stats,
        'user'  => $user,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// GRUP UNTUK PENGGUNA YANG SUDAH LOGIN
Route::middleware('auth')->group(function () {
    // Complaints
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::get('/complaints/create/{category}', [ComplaintController::class, 'showForm'])->name('complaints.form');
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pengaduan (menu sidebar)
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
});

// Admin Group
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});

// Rute autentikasi bawaan Laravel
require __DIR__.'/auth.php';
