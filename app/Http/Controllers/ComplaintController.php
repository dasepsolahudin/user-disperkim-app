<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View; // <-- Tambahkan ini

class ComplaintController extends Controller
{
    /**
     * Menampilkan daftar pengaduan milik pengguna.
     */
    public function index(): View
    {
        $complaints = Auth::user()->complaints()->latest()->get();

        return view('complaints.index', compact('complaints'));
    }
    
    /**
     * Menampilkan form untuk membuat pengaduan.
     */
    public function create()
    {
        return view('complaints.create');
    }

    /**
     * Menyimpan pengaduan baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // 2. Buat pengaduan baru
        Complaint::create([
            'user_id' => Auth::id(), // Ambil ID user yang sedang login
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => 'pending', // Status default
        ]);

        // 3. Arahkan kembali ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Laporan Anda berhasil dikirim!');
    }
}