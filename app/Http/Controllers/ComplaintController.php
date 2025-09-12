<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
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

    public function destroy(\App\Models\Complaint $complaint)
{
    $complaint->delete();

    return redirect()->route('complaints.index')
                     ->with('success', 'Pengaduan berhasil dihapus.');
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
        // 1. Validasi Input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:rutilahu,infrastruktur,tata_kota,air_bersih_sanitasi',
            'location_text' => 'nullable|string|max:255',
            'photos' => 'required|array|min:3', 
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'ktp_photo' => 'nullable|image|max:2048',
        ], [
            'photos.min' => 'Anda harus mengunggah minimal 3 foto aduan.',
            'photos.*.image' => 'Semua file yang diunggah harus berupa gambar.',
            'photos.*.mimes' => 'Format gambar yang diizinkan adalah jpeg, png, jpg, atau gif.',
        ]);

        // 2. Buat data pengaduan utama
        $complaint = Complaint::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'location_text' => $validated['location_text'],
            'status' => 'Baru',
        ]);

        // 3. Proses dan simpan setiap foto yang diunggah
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                $path = $photoFile->store('complaint-photos', 'public');
                $complaint->photos()->create(['path' => $path]);
            }
        }

        // 4. Proses foto KTP jika ada
        if ($request->hasFile('ktp_photo')) {
            $user = Auth::user();
            if ($user->ktp_photo) {
                Storage::disk('public')->delete($user->ktp_photo);
            }
            $ktpPath = $request->file('ktp_photo')->store('ktp-photos', 'public');
            $user->update(['ktp_photo' => $ktpPath]);
        }

        // 5. Arahkan kembali pengguna dengan pesan sukses
        return redirect()->route('complaints.index')->with('success', 'Laporan Anda berhasil dikirim!');
    }
    
    /**
     * Menampilkan detail pengaduan.
     */
    public function show(Complaint $complaint): View
    {
        // Memastikan pengguna hanya bisa melihat pengaduannya sendiri
        if ($complaint->user_id !== auth()->id()) {
            abort(403);
        }
        return view('complaints.show', compact('complaint'));
    }

    // ==========================================================
    // FUNGSI BARU UNTUK EDIT DAN UPDATE
    // ==========================================================

    /**
     * Menampilkan formulir untuk mengedit pengaduan.
     */
    public function edit(Complaint $complaint): View
    {
        // Memastikan hanya pemilik yang bisa mengakses halaman edit
        if ($complaint->user_id !== auth()->id()) {
            abort(403, 'Anda tidak diizinkan untuk mengedit laporan ini.');
        }

        return view('complaints.edit', compact('complaint'));
    }

    /**
     * Memperbarui pengaduan di database.
     */
    public function update(Request $request, Complaint $complaint): RedirectResponse
    {
        // Memastikan hanya pemilik yang bisa memperbarui laporan
        if ($complaint->user_id !== auth()->id()) {
            abort(403, 'Anda tidak diizinkan untuk mengedit laporan ini.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location_text' => 'nullable|string|max:255',
            // Foto tidak wajib saat update, tapi jika ada harus array
            'photos' => 'nullable|array|min:3',
            'photos.*' => 'image|max:2048',
        ], [
            'photos.min' => 'Jika ingin mengganti foto, unggah minimal 3 foto baru.',
        ]);

        // Update data teks pada pengaduan
        $complaint->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location_text' => $validated['location_text'],
        ]);

        // Cek jika ada foto baru yang diunggah
        if ($request->hasFile('photos')) {
            // 1. Hapus semua foto lama dari storage
            foreach ($complaint->photos as $photo) {
                Storage::disk('public')->delete($photo->path);
            }
            // 2. Hapus relasi foto lama dari database
            $complaint->photos()->delete();

            // 3. Unggah dan simpan foto yang baru
            foreach ($request->file('photos') as $photoFile) {
                $path = $photoFile->store('complaint-photos', 'public');
                $complaint->photos()->create(['path' => $path]);
            }
        }

        return redirect()->route('complaints.index')->with('success', 'Laporan berhasil diperbarui!');
    }
}