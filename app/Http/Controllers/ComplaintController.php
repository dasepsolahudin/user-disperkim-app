<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComplaintRequest; 
use App\Models\Complaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        // Mengambil data pengaduan yang dimiliki oleh user yang sedang login,
        // diurutkan dari yang terbaru, dan ditampilkan dengan paginasi.
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
        // Memastikan kategori yang dipilih valid sebelum menampilkan formulir.
        if (!in_array($category, ['rutilahu', 'infrastruktur', 'tata_kota', 'air_bersih_sanitasi'])) {
            abort(404);
        }
        return view('complaints.form', ['category' => $category]);
    }

    /**
     * Menyimpan pengaduan baru yang disubmit dari formulir.
     */
    public function store(StoreComplaintRequest $request): RedirectResponse
    {
        // 1. Validasi sudah ditangani secara otomatis oleh 'StoreComplaintRequest'.
        //    $validated() akan mengembalikan semua data yang lolos validasi.
        $validated = $request->validated();

        // ---- PERBAIKAN LOGIKA PENYIMPANAN FOTO KTP ----
        // 2. Proses upload foto KTP terlebih dahulu untuk mendapatkan path filenya.
        //    Ini dilakukan sebelum membuat record complaint agar path bisa ikut disimpan.
        $ktpPath = null;
        if ($request->hasFile('foto_ktp')) { // Pastikan nama input sesuai dengan form ('foto_ktp')
            $ktpPath = $request->file('foto_ktp')->store('ktp-photos', 'public');
        }

        // 3. Gabungkan semua data yang akan disimpan ke database.
        //    - $validated berisi semua data dari form (judul, deskripsi, alamat, dll).
        //    - user_id, status, dan path foto KTP ditambahkan secara manual.
        $dataToStore = array_merge($validated, [
            'user_id' => Auth::id(),
            'status' => 'Baru', // Status default untuk setiap pengaduan baru
            'foto_ktp' => $ktpPath, // Menyimpan path foto KTP ke tabel 'complaints'
        ]);
        
        // 4. Buat record pengaduan utama di database menggunakan data yang sudah digabung.
        $complaint = Complaint::create($dataToStore);

        // 5. Proses upload foto-foto bukti (logika ini sudah benar).
        //    Looping untuk menyimpan setiap file foto bukti yang diunggah.
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                $path = $photoFile->store('complaint-photos', 'public');
                // Menyimpan path foto ke tabel 'complaint_photos' yang berelasi
                // dengan pengaduan yang baru saja dibuat.
                $complaint->photos()->create(['path' => $path]);
            }
        }

        // 6. Alihkan pengguna ke halaman daftar pengaduan dengan pesan sukses.
        //    Menggunakan route 'pengaduan.index' agar konsisten.
        return redirect()->route('pengaduan.index')->with('success', 'Laporan Anda berhasil dikirim dan akan segera kami proses!');
    }

    /**
     * Menampilkan detail dari satu pengaduan spesifik.
     */
    public function show(Complaint $complaint): View
    {
        // Memastikan pengguna yang mengakses adalah pemilik pengaduan.
        $this->authorize('view', $complaint);

        return view('complaints.show', compact('complaint'));
    }

    /**
     * Menampilkan form untuk mengedit pengaduan.
     */
    public function edit(Complaint $complaint): View
    {
        $this->authorize('update', $complaint);
        return view('complaints.edit', compact('complaint'));
    }

    /**
     * Memperbarui data pengaduan di database.
     */
    public function update(Request $request, Complaint $complaint): RedirectResponse
    {
        $this->authorize('update', $complaint);
        
        // (Tambahkan validasi dan logika update Anda di sini jika diperlukan)
        // Contoh:
        // $validated = $request->validate([...]);
        // $complaint->update($validated);

        return redirect()->route('complaints.show', $complaint)->with('success', 'Pengaduan berhasil diperbarui.');
    }

    /**
     * Menghapus pengaduan dari database (soft delete).
     */
    public function destroy(Complaint $complaint): RedirectResponse
    {
        $this->authorize('delete', $complaint);
        
        $complaint->delete();
        
        return redirect()->route('complaints.index')->with('success', 'Pengaduan berhasil dihapus.');
    }
}
