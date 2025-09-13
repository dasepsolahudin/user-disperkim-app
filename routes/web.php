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
use App\Http\Controllers\SettingsController;

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
// ...
Route::middleware('auth')->group(function () {
    // Rute-rute untuk Complaints / Pengaduan
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::get('/complaints/create/{category}', [ComplaintController::class, 'showForm'])->name('complaints.form');
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');
    Route::get('/complaints/{complaint}/edit', [ComplaintController::class, 'edit'])->name('complaints.edit');
    Route::put('/complaints/{complaint}', [ComplaintController::class, 'update'])->name('complaints.update');
    Route::delete('/complaints/{complaint}', [ComplaintController::class, 'destroy'])->name('complaints.destroy'); // Tambahkan rute ini

    // ... rute lainnya
// ...

    

    // Rute Pengaturan (Sebelumnya Profil)
    Route::get('/settings/{section?}', [App\Http\Controllers\SettingsController::class, 'edit'])->name('settings.edit');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::delete('/settings', [SettingsController::class, 'destroy'])->name('settings.destroy');
    Route::post('/settings/photo', [SettingsController::class, 'updatePhoto'])->name('settings.photo.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])
    ->middleware('auth')
    ->name('profile.updatePhoto');

    // --- RUTE PENGATURAN (SETTINGS) ---
    // Semua rute pengaturan dikonsolidasikan di sini agar rapi.
    Route::get('/settings/{section?}', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::patch('/settings/profile', [SettingsController::class, 'update'])->name('settings.profile.update');
    Route::post('/settings/photo', [SettingsController::class, 'updatePhoto'])->name('settings.photo.update');
    
    // PERBAIKAN: Nama rute ini diubah agar sesuai dengan yang dipanggil oleh form.
    Route::patch('/settings/notifications', [SettingsController::class, 'updateNotifications'])->name('settings.notifications.update');
    
    Route::delete('/settings/delete-account', [SettingsController::class, 'destroy'])->name('settings.account.destroy');

    // Pengaduan (menu sidebar)
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::get('/pengaduan/{id}/edit', [PengaduanController::class, 'edit'])->name('pengaduan.edit');
Route::put('/pengaduan/{id}', [PengaduanController::class, 'update'])->name('pengaduan.update');
Route::resource('pengaduan', \App\Http\Controllers\PengaduanController::class);


});

// Admin Group
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});


Route::prefix('pengaturan')->group(function () {
    Route::get('/profil', [SettingController::class, 'profile'])->name('settings.profile');
    Route::get('/keamanan', [SettingController::class, 'security'])->name('settings.security');
    });
// Rute autentikasi bawaan Laravel
require __DIR__.'/auth.php';

