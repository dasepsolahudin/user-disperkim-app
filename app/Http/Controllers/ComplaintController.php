<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Menampilkan daftar pengaduan milik pengguna.
     */
    public function index(): View
    {
        $complaints = Complaint::where('user_id', auth()->id())->latest()->paginate(10);
        return view('complaints.index', compact('complaints'));
    }

    /**
     * Menampilkan halaman untuk memilih kategori pengaduan.
     */
    public function create(): View
    {
        return view('complaints.create');
    }

    /**
     * Menampilkan formulir pengaduan berdasarkan kategori.
     */
    public function showForm(string $category): View
    {
        $allowedCategories = ['rutilahu', 'infrastruktur', 'tata_kota', 'air_bersih_sanitasi'];
        if (!in_array($category, $allowedCategories)) {
            abort(404);
        }

        return view('complaints.form', compact('category'));
    }

    /**
     * Menyimpan pengaduan baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi semua input termasuk file
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:rutilahu,infrastruktur,tata_kota,air_bersih_sanitasi',
            'location_text' => 'nullable|string|max:255',
            // --- PERUBAHAN DI SINI ---
            // Aturan 'mimes' dihapus, aturan 'image' sudah cukup untuk memvalidasi file gambar umum.
            'photo' => 'required|image|max:2048', // Foto aduan wajib, maks 2MB
            'ktp_photo' => 'nullable|image|max:2048', // Foto KTP opsional, maks 2MB
        ]);

        $complaintData = $validated;
        $complaintData['user_id'] = Auth::id();
        $complaintData['status'] = 'Baru';

        // 2. Handle upload foto aduan
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('complaint-photos', 'public');
            $complaintData['photo'] = $path;
        }

        // 3. Simpan data pengaduan
        Complaint::create($complaintData);

        // 4. Handle upload foto KTP (jika ada) dan update profil user
        if ($request->hasFile('ktp_photo')) {
            $user = Auth::user();
            
            if ($user->ktp_photo) {
                Storage::disk('public')->delete($user->ktp_photo);
            }

            $ktpPath = $request->file('ktp_photo')->store('ktp-photos', 'public');
            $user->update(['ktp_photo' => $ktpPath]);
        }

        // 5. Arahkan kembali ke daftar pengaduan dengan pesan sukses
        return redirect()->route('complaints.index')->with('success', 'Laporan Anda berhasil dikirim!');
        if ($complaint->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak');
        }

        return view('complaints.show', compact('complaint'));
    }
}