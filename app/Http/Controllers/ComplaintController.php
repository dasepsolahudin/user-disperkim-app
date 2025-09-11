<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ComplaintController extends Controller
{
    // ... method index tetap sama ...

    /**
     * Menampilkan halaman untuk memilih kategori pengaduan.
     */
    public function create(): View
    {
        return view('complaints.create');
    }

    /**
     * TAMBAHAN: Menampilkan formulir pengaduan berdasarkan kategori.
     */
    public function showForm(string $category): View
    {
        // Daftar kategori yang valid untuk keamanan
        $allowedCategories = ['rutilahu', 'infrastruktur', 'tata_kota', 'air_bersih_sanitasi'];
        if (!in_array($category, $allowedCategories)) {
            abort(404);
        }

        return view('complaints.form', compact('category'));
    }

    /**
     * DIPERBARUI: Menyimpan pengaduan baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:rutilahu,infrastruktur,tata_kota,air_bersih_sanitasi', // Validasi kategori
        ]);

        // 2. Buat pengaduan baru
        Complaint::create([
            'user_id' => Auth::id(),
            'category' => $validated['category'], // Simpan kategori
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => 'pending',
        ]);

        // 3. Arahkan kembali ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Laporan Anda berhasil dikirim!');
    }
}