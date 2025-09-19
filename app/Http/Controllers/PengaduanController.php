<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ComplaintResponded;

class PengaduanController extends Controller
{
    /**
     * Menampilkan daftar pengaduan milik pengguna.
     */
    public function index(): View
    {
        $complaints = Complaint::where('user_id', auth()->id())->latest()->paginate(10);
        // Menggunakan view yang sudah ada untuk complaints
return view('pengaduan.index', compact('complaints'));
    }

    /**
     * Menampilkan halaman untuk memilih kategori pengaduan.
     */
    public function create(): View
    {
        // Menggunakan view yang sudah ada untuk complaints
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
        // Menggunakan view yang sudah ada untuk complaints
        return view('complaints.form', compact('category'));
    }

    /**
     * Menyimpan pengaduan baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
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

        $complaint = Complaint::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'location_text' => $validated['location_text'],
            'status' => 'Baru',
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                $path = $photoFile->store('complaint-photos', 'public');
                $complaint->photos()->create(['path' => $path]);
            }
        }

        if ($request->hasFile('ktp_photo')) {
            $user = Auth::user();
            if ($user->ktp_photo) {
                Storage::disk('public')->delete($user->ktp_photo);
            }
            $ktpPath = $request->file('ktp_photo')->store('ktp-photos', 'public');
            $user->update(['ktp_photo' => $ktpPath]);
        }

        return redirect()->route('pengaduan.index')->with('success', 'Laporan Anda berhasil dikirim!');
    }

    /**
     * Menampilkan detail pengaduan.
     */
    public function show(Complaint $complaint): View
    {
        if ($complaint->user_id !== auth()->id() && !Auth::user()->is_admin) {
            abort(403);
        }
        return view('complaints.show', compact('complaint'));
    }

    /**
     * Menampilkan formulir untuk mengedit pengaduan.
     */
    public function edit(Complaint $complaint): View
    {
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
        if ($complaint->user_id !== auth()->id()) {
            abort(403, 'Anda tidak diizinkan untuk mengedit laporan ini.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location_text' => 'nullable|string|max:255',
            'photos' => 'nullable|array|min:3',
            'photos.*' => 'image|max:2048',
        ], ['photos.min' => 'Jika ingin mengganti foto, unggah minimal 3 foto baru.']);

        $complaint->update($validated);

        if ($request->hasFile('photos')) {
            foreach ($complaint->photos as $photo) {
                Storage::disk('public')->delete($photo->path);
            }
            $complaint->photos()->delete();

            foreach ($request->file('photos') as $photoFile) {
                $path = $photoFile->store('complaint-photos', 'public');
                $complaint->photos()->create(['path' => $path]);
            }
        }

        return redirect()->route('pengaduan.index')->with('success', 'Laporan berhasil diperbarui!');
    }

    /**
     * Menghapus pengaduan (memindahkannya ke Sampah).
     */
    public function destroy(Complaint $complaint): RedirectResponse
    {
        if ($complaint->user_id !== auth()->id()) {
            abort(403, 'Anda tidak diizinkan untuk menghapus laporan ini.');
        }
        
        $complaint->delete();

        $complaint->user->notify(new ComplaintResponded($complaint));

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dipindahkan ke Sampah.');
    }
}
