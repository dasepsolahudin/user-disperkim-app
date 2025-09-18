<?php

namespace App\Http\Controllers;

// ---- PERUBAHAN DI SINI ----
// Menggunakan Form Request khusus untuk validasi saat menyimpan data.
use App\Http\Requests\StoreComplaintRequest; 
use App\Models\Complaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request; // Tetap digunakan untuk metode 'update' jika ada
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ComplaintController extends Controller
{

    use AuthorizesRequests;
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
        // Logika ini tetap sama
        if (!in_array($category, ['rutilahu', 'infrastruktur', 'tata_kota', 'air_bersih_sanitasi'])) {
            abort(404);
        }
        return view('complaints.form', ['category' => $category]);
    }

    /**
     * Menyimpan pengaduan baru yang disubmit dari formulir.
     */
    // ---- PERBAIKAN UTAMA #2: MENGGUNAKAN FORM REQUEST ----
    public function store(StoreComplaintRequest $request): RedirectResponse
    {
        // Blok validasi yang panjang sudah dipindahkan ke StoreComplaintRequest.
        // Controller menjadi jauh lebih bersih.
        $validated = $request->validated();

        // Membuat data pengaduan utama di database
        $complaint = Complaint::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'status' => 'Baru',
        ]));

        // Memproses dan menyimpan foto bukti jika ada yang di-upload
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                $path = $photoFile->store('complaint-photos', 'public');
                $complaint->photos()->create(['path' => $path]);
            }
        }

        // Memproses foto KTP jika ada yang di-upload
        if ($request->hasFile('ktp_photo')) {
            $user = Auth::user();
            if ($user->ktp_photo) {
                Storage::disk('public')->delete($user->ktp_photo);
            }
            $ktpPath = $request->file('ktp_photo')->store('ktp-photos', 'public');
            $user->update(['ktp_photo' => $ktpPath]);
        }

        return redirect()->route('complaints.index')->with('success', 'Laporan Anda berhasil dikirim dan akan segera diproses!');
    }

    /**
     * Menampilkan detail dari satu pengaduan spesifik.
     */
    public function show(Complaint $complaint): View
    {
        // Pengecekan otorisasi menggunakan trait yang baru ditambahkan
        $this->authorize('view', $complaint);

        return view('complaints.show', compact('complaint'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint): View
    {
        // ---- PERBAIKAN UTAMA #1: MENGGUNAKAN POLICY ----
        $this->authorize('update', $complaint);

        // Anda perlu membuat view 'complaints.edit' jika ingin menggunakan ini.
        return view('complaints.edit', compact('complaint'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complaint $complaint): RedirectResponse
    {
        // ---- PERBAIKAN UTAMA #1: MENGGUNAKAN POLICY ----
        $this->authorize('update', $complaint);
        
        // (Tambahkan validasi dan logika update Anda di sini jika diperlukan)
        // Contoh:
        // $validated = $request->validate([...]);
        // $complaint->update($validated);

        return redirect()->route('complaints.show', $complaint)->with('success', 'Pengaduan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint): RedirectResponse
    {
        // ---- PERBAIKAN UTAMA #1: MENGGUNAKAN POLICY ----
        $this->authorize('delete', $complaint);
        
        $complaint->delete();
        
        return redirect()->route('complaints.index')->with('success', 'Pengaduan berhasil dihapus.');
    }
}