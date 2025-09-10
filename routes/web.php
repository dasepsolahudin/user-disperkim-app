<?php

use App\Http\Controllers\HomepageController; // <-- Tambahkan ini
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// Route untuk menampilkan halaman form registrasi
Route::get('/register', [UserController::class, 'create']);

// Route untuk memproses data dari form
Route::post('/register', [UserController::class, 'store']);

// Route untuk menampilkan semua pengguna
Route::get('/users', [UserController::class, 'index']);

// Route untuk menampilkan form edit
Route::get('/users/{user}/edit', [UserController::class, 'edit']);

// Route untuk memproses update data
Route::put('/users/{user}', [UserController::class, 'update']);

// Route untuk menghapus data
Route::delete('/users/{user}', [UserController::class, 'destroy']);

// Ganti dengan ini
Route::get('/', [HomepageController::class, 'index']);
