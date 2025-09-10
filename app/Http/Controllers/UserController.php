<?php

namespace App\Http\Controllers;

use App\Models\User; // <-- Import model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // <-- Import untuk enkripsi password

class UserController extends Controller
{
    // Fungsi untuk menampilkan form
    public function create()
    {
        return view('register');
    }

    // Fungsi untuk menyimpan data baru
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Simpan data ke tabel 'users'
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password di-enkripsi
        ]);

        // Arahkan kembali ke halaman lain dengan pesan sukses
        return redirect('/')->with('success', 'Registrasi berhasil!');
    }
    // Fungsi untuk menampilkan semua user
public function index()
{
    $users = User::all(); // <-- Mengambil semua data dari tabel users

    return view('users', ['users' => $users]); // <-- Mengirim data ke view
}

// Fungsi untuk menampilkan halaman form edit
public function edit(User $user)
{
    // Laravel akan otomatis mencari user berdasarkan ID di URL
    return view('user_edit', ['user' => $user]);
}

// Fungsi untuk meng-update data di database
public function update(Request $request, User $user)
{
    // Validasi
    $request->validate([
        'name' => 'required|string|max:255',
        // Email harus unik, tapi abaikan email user yang sedang diedit
        'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
    ]);

    // Update data
    $user->name = $request->name;
    $user->email = $request->email;
    $user->save();

    return redirect('/users')->with('success', 'Data pengguna berhasil diperbarui!');
}

// Fungsi untuk menghapus user
public function destroy(User $user)
{
    $user->delete();
    return redirect('/users')->with('success', 'Data pengguna berhasil dihapus!');
}
}
