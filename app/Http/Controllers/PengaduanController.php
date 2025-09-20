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
    // 1. TAMBAHKAN VALIDASI UNTUK ALAMAT DAN UBAH 'ktp_photo'
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category' => 'required|string|in:rutilahu,infrastruktur,tata_kota,air_bersih_sanitasi',
        
        // Data Alamat Lengkap
        'kabupaten' => 'required|string|max:100',
        'kecamatan' => 'required|string|max:100',
        'desa' => 'required|string|max:100',
        'kampung' => 'required|string|max:100',
        'rt_rw' => 'required|string|max:10',

        'photos' => 'required|array|min:1', // Minimal 1 foto sudah cukup
        'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048', // KTP wajib diisi
    ], [
        'photos.min' => 'Anda harus mengunggah minimal 1 foto aduan.',
        // ... pesan error lainnya ...
        'foto_ktp.required' => 'Foto KTP wajib diunggah untuk verifikasi.',
    ]);

    // 2. PROSES FOTO KTP TERLEBIH DAHULU
    $ktpPath = null;
    if ($request->hasFile('foto_ktp')) {
        $ktpPath = $request->file('foto_ktp')->store('ktp-photos', 'public');
    }

    // 3. SIMPAN SEMUA DATA KE DATABASE COMPLAINTS
    $complaint = Complaint::create([
        'user_id' => Auth::id(),
        'title' => $validated['title'],
        'description' => $validated['description'],
        'category' => $validated['category'],
        'status' => 'Baru',

        // Data alamat yang disimpan
        'kabupaten' => $validated['kabupaten'],
        'kecamatan' => $validated['kecamatan'],
        'desa' => $validated['desa'],
        'kampung' => $validated['kampung'],
        'rt_rw' => $validated['rt_rw'],

        // Path foto KTP yang disimpan
        'foto_ktp' => $ktpPath,
    ]);

    // 4. SIMPAN FOTO-FOTO PENGADUAN (ini sudah benar)
    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $photoFile) {
            $path = $photoFile->store('complaint-photos', 'public');
            $complaint->photos()->create(['path' => $path]);
        }
    }
    
    // 5. HAPUS LOGIKA LAMA YANG MENYIMPAN KTP KE USER
    // Bagian di bawah ini sudah tidak diperlukan lagi dan harus dihapus.
    /*
    if ($request->hasFile('ktp_photo')) {
        ... (HAPUS BLOK INI) ...
    }
    */

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