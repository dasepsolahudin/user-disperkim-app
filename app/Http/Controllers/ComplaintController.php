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
     * Menampilkan daftar pengaduan milik pengguna yang sedang login.
     */
    public function index(): View
    {
        $complaints = Auth::user()->complaints()->latest()->paginate(10);
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
     * Menampilkan formulir pengaduan berdasarkan kategori yang dipilih.
     */
    public function showForm(string $category): View
    {
        // Pastikan kategori valid sebelum menampilkan form
        if (!in_array($category, ['rutilahu', 'infrastruktur', 'tata_kota', 'air_bersih_sanitasi'])) {
            abort(404);
        }
        return view('complaints.form', ['category' => $category]);
    }

    /**
     * Menyimpan pengaduan baru yang disubmit dari formulir.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi semua input dari formulir baru
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:rutilahu,infrastruktur,tata_kota,air_bersih_sanitasi',
            'priority' => 'required|string|in:Rendah,Sedang,Tinggi',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'sub_district' => 'nullable|string|max:255', // Untuk Kampung/RW
            'location_text' => 'required|string', // Untuk Alamat Detail
            'description' => 'required|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // Maksimal 5MB per foto
            'ktp_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Maksimal 5MB
        ]);

        // 2. Membuat data pengaduan utama di database
        $complaint = Complaint::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'category' => $validated['category'],
            'priority' => $validated['priority'],
            'city' => $validated['city'],
            'district' => $validated['district'],
            'village' => $validated['village'],
            'sub_district' => $validated['sub_district'],
            'location_text' => $validated['location_text'],
            'description' => $validated['description'],
            'status' => 'Baru', // Status default saat pengaduan dibuat
        ]);

        // 3. Memproses dan menyimpan foto bukti jika ada yang di-upload
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                $path = $photoFile->store('complaint-photos', 'public');
                $complaint->photos()->create(['path' => $path]);
            }
        }

        // 4. Memproses foto KTP jika ada yang di-upload
        if ($request->hasFile('ktp_photo')) {
            $user = Auth::user();
            // Hapus foto KTP lama jika ada untuk menghemat penyimpanan
            if ($user->ktp_photo) {
                Storage::disk('public')->delete($user->ktp_photo);
            }
            $ktpPath = $request->file('ktp_photo')->store('ktp-photos', 'public');
            $user->update(['ktp_photo' => $ktpPath]);
        }

        // 5. Mengarahkan pengguna kembali ke daftar pengaduan dengan pesan sukses
        return redirect()->route('complaints.index')->with('success', 'Laporan Anda berhasil dikirim dan akan segera diproses!');
    }

    /**
     * Menampilkan detail dari satu pengaduan spesifik.
     */
    public function show(Complaint $complaint): View
    {
        // Otorisasi: Pastikan pengguna hanya bisa melihat pengaduannya sendiri
        if ($complaint->user_id !== Auth::id()) {
            abort(403, 'ANDA TIDAK DIIZINKAN MENGAKSES HALAMAN INI');
        }
        return view('complaints.show', compact('complaint'));
    }

    /**
     * Show the form for editing the specified resource.
     * (Jika Anda memerlukan fungsionalitas edit di masa depan)
     */
    public function edit(Complaint $complaint)
    {
        // Otorisasi
        if ($complaint->user_id !== Auth::id()) {
            abort(403);
        }
        // return view('complaints.edit', compact('complaint'));
    }

    /**
     * Update the specified resource in storage.
     * (Jika Anda memerlukan fungsionalitas update di masa depan)
     */
    public function update(Request $request, Complaint $complaint)
    {
        // Otorisasi dan logika update
    }

    /**
     * Remove the specified resource from storage.
     * (Jika Anda memerlukan fungsionalitas hapus di masa depan)
     */
    public function destroy(Complaint $complaint)
    {
        // Otorisasi dan logika hapus
        if ($complaint->user_id !== Auth::id()) {
            abort(403);
        }
        $complaint->delete();
        return redirect()->route('complaints.index')->with('success', 'Pengaduan berhasil dihapus.');
    }
}