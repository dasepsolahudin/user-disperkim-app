<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaduanController;
use Illuminate\Support\Facades\Auth;
use App\Models\Complaint;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\DashboardController;

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
Route::post('/language', [LanguageController::class, 'switchLang'])->name('language.switch');
Route::get('/pengaduan/{complaint}', [PengaduanController::class, 'show'])->name('pengaduan.show');
Route::resource('pengaduan', PengaduanController::class)->parameters(['pengaduan' => 'complaint']);
Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('setLanguage');

// Rute untuk Dashboard (Setelah Login)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rute untuk Peta
Route::get('/map', [MapController::class, 'index'])->middleware(['auth', 'verified'])->name('map');

// GRUP UNTUK PENGGUNA YANG SUDAH LOGIN
Route::middleware('auth')->group(function () {
    // Rute-rute untuk Complaints / Pengaduan
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::get('/complaints/create/{category}', [ComplaintController::class, 'showForm'])->name('complaints.form');
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');
    Route::get('/complaints/{complaint}/edit', [ComplaintController::class, 'edit'])->name('complaints.edit');
    Route::put('/complaints/{complaint}', [ComplaintController::class, 'update'])->name('complaints.update');
    Route::delete('/complaints/{complaint}', [ComplaintController::class, 'destroy'])->name('complaints.destroy');
    

    // Rute untuk Fitur Sampah (Trash)
    Route::get('/settings/trash/{id}/show', [SettingsController::class, 'showTrashed'])->name('settings.trash.show');
    Route::put('/settings/trash/{id}/restore', [SettingsController::class, 'restore'])->name('settings.trash.restore');
    Route::delete('/settings/trash/{id}/delete', [SettingsController::class, 'forceDelete'])->name('settings.trash.forceDelete');
    Route::delete('/settings/trash/empty', [SettingsController::class, 'emptyTrash'])->name('settings.trash.empty');

    // Rute Pengaturan (Settings)
    Route::get('/settings/{section?}', [App\Http\Controllers\SettingsController::class, 'edit'])->name('settings.edit');
    Route::delete('/settings', [SettingsController::class, 'destroy'])->name('settings.destroy');
    Route::post('/settings/photo', [SettingsController::class, 'updatePhoto'])->name('settings.photo.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->middleware('auth')->name('profile.updatePhoto');
    Route::patch('/settings/profile', [SettingsController::class, 'update'])->name('settings.profile.update');
    Route::patch('/settings/2fa', [SettingsController::class, 'updateTwoFactorAuthentication'])->name('settings.2fa.update');
    Route::delete('/settings/delete-account', [SettingsController::class, 'destroy'])->name('settings.account.destroy');
    Route::patch('/settings/notifications', [SettingsController::class, 'updateNotifications'])->name('settings.notifications.update');

    // Rute Pengaduan dari Sidebar
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
    Route::patch('/settings/notification-preferences', [SettingsController::class, 'updateNotificationPreferences'])->name('settings.updateNotificationPreferences');
});

// Rute autentikasi bawaan Laravel
require __DIR__.'/auth.php';

Route::get('/maps', function () {
    return view('maps');
});