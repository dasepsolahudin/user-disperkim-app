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
    // app/Http/Controllers/PengaduanController.php

// ... (kode lain biarkan saja)

public function store(Request $request): RedirectResponse
{
    // Pastikan nama input di sini sesuai dengan yang ada di formulir
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category' => 'required|string|in:rutilahu,infrastruktur,tata_kota,air_bersih_sanitasi',
        'kabupaten' => 'required|string|max:100',
        'kecamatan' => 'required|string|max:100',
        'desa' => 'required|string|max:100',
        'kampung' => 'required|string|max:100',
        'rt' => 'required|string|max:5', // Pastikan nama input sesuai dengan form
        'rw' => 'required|string|max:5', // Pastikan nama input sesuai dengan form
        'phone_number' => 'nullable|string|max:20',
        'location_text' => 'nullable|string',
        'photos' => 'required|array|min:1',
        'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120',
        'ktp_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
    ], [
        'photos.min' => 'Anda harus mengunggah minimal 1 foto aduan.',
        'ktp_photo.required' => 'Foto KTP wajib diunggah untuk verifikasi.',
    ]);

    // Simpan foto KTP
    $ktpPath = $request->file('ktp_photo')->store('ktp-photos', 'public');

    // Buat pengaduan baru
    $complaint = Complaint::create(array_merge($validated, [
        'user_id' => Auth::id(),
        'status' => 'Baru',
        'district' => $validated['kabupaten'],
        'sub_district' => $validated['kecamatan'],
        'village' => $validated['desa'],
        'ktp_photo' => $ktpPath,
    ]));

    // Simpan foto-foto pengaduan
    foreach ($request->file('photos') as $photoFile) {
        $path = $photoFile->store('complaint-photos', 'public');
        $complaint->photos()->create(['path' => $path]);
    }
    
    return redirect()->route('pengaduan.index')->with('success', 'Laporan Anda berhasil dikirim!');
}

// ... (method show() dan lainnya biarkan seperti semula, sudah benar)
    /**
     * Menampilkan detail pengaduan.
     */
    public function show(Complaint $complaint): View
    {
        if ($complaint->user_id !== auth()->id() && !Auth::user()->is_admin) {
            abort(403);
        }
        return view('pengaduan.show', compact('complaint'));
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