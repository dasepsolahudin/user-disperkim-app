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
    // app/Http/Controllers/ComplaintController.php

public function store(Request $request): RedirectResponse
{
    // 1. Validasi input
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category' => 'required|string|in:rutilahu,infrastruktur,tata_kota,air_bersih_sanitasi',
        'location_text' => 'nullable|string|max:255',
        'photos' => 'required|array', // Pastikan 'photos' adalah array
        'photos.*' => 'image|max:2048', // Validasi setiap file dalam array 'photos'
        'ktp_photo' => 'nullable|image|max:2048',
    ]);

    // 2. Buat data pengaduan tanpa foto terlebih dahulu
    $complaint = Complaint::create([
        'user_id' => Auth::id(),
        'title' => $validated['title'],
        'description' => $validated['description'],
        'category' => $validated['category'],
        'location_text' => $validated['location_text'],
        'status' => 'Baru',
    ]);

    // 3. Loop dan simpan setiap foto aduan
    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $photoFile) {
            $path = $photoFile->store('complaint-photos', 'public');
            $complaint->photos()->create(['path' => $path]); // Buat record baru di complaint_photos
        }
    }

    // 4. Handle upload foto KTP (jika ada) dan update profil user
    if ($request->hasFile('ktp_photo')) {
        $user = Auth::user();
        if ($user->ktp_photo) {
            Storage::disk('public')->delete($user->ktp_photo);
        }
        $ktpPath = $request->file('ktp_photo')->store('ktp-photos', 'public');
        $user->update(['ktp_photo' => $ktpPath]);
    }

    // 5. Arahkan kembali
    return redirect()->route('pengaduan.index')->with('success', 'Laporan Anda berhasil dikirim!');
}}

        return view('complaints.show', compact('complaint'));
    