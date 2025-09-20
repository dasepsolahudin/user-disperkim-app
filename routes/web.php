<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TrashController;

/*
|--------------------------------------------------------------------------
| Rute Publik (Dapat Diakses Siapa Saja)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomepageController::class, 'index'])->name('homepage');

// Rute untuk mengganti bahasa
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('setLanguage');


/*
|--------------------------------------------------------------------------
| Rute Autentikasi (Login, Register, dll.)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| Rute yang Memerlukan Login
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard & Peta
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/map', [MapController::class, 'index'])->name('map');

    // Pencarian
    Route::get('/search', [SearchController::class, 'results'])->name('search');

    // Notifikasi
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    

    // Halaman Daftar & Detail Pengaduan (Menggunakan Controller yang berbeda)
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/{complaint}', [PengaduanController::class, 'show'])->name('pengaduan.show');

    // CRUD untuk Laporan/Pengaduan (Complaints)
    Route::resource('complaints', ComplaintController::class);
    Route::get('/complaints/create/{category}', [ComplaintController::class, 'showForm'])->name('complaints.form');

    // Pengaturan Akun (Profile & Settings)
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/{section?}', [SettingsController::class, 'edit'])->name('edit');
        Route::patch('/profile', [SettingsController::class, 'update'])->name('profile.update');
        Route::post('/photo', [SettingsController::class, 'updatePhoto'])->name('photo.update');
        Route::patch('/2fa', [SettingsController::class, 'updateTwoFactorAuthentication'])->name('2fa.update');

        Route::patch('/notifications', [SettingsController::class, 'updateNotifications'])->name('notifications.update');
        Route::delete('/delete-account', [SettingsController::class, 'destroy'])->name('account.destroy');

        // Fitur Sampah (Trash)
        Route::get('/trash/{id}/show', [TrashController::class, 'show'])->name('trash.show');
        Route::put('/trash/{id}/restore', [TrashController::class, 'restore'])->name('trash.restore');
        Route::delete('/trash/{id}/delete', [TrashController::class, 'forceDelete'])->name('trash.forceDelete');
        Route::delete('/trash/empty', [TrashController::class, 'emptyTrash'])->name('trash.empty');
    });

    // Rute Khusus Admin
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', AdminUserController::class)->except(['create', 'store', 'show']);

        Route::resource('complaints', App\Http\Controllers\ComplaintController::class);

    });

});