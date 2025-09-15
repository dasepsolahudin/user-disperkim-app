<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TrashController extends Controller
{
    /**
     * Menampilkan daftar pengaduan yang ada di sampah.
     */
    public function index(): View
    {
        $trashedComplaints = Complaint::onlyTrashed()
                                      ->where('user_id', Auth::id())
                                      ->latest('deleted_at')
                                      ->paginate(10);

        return view('settings.trash', compact('trashedComplaints'));
    }

    /**
     * Menampilkan detail pengaduan yang ada di sampah.
     */
    public function show(string $id): View
    {
        $complaint = Complaint::onlyTrashed()->where('user_id', Auth::id())->findOrFail($id);
        return view('complaints.show', compact('complaint'));
    }

    /**
     * Memulihkan pengaduan dari sampah.
     */
    public function restore(string $id): RedirectResponse
    {
        $complaint = Complaint::onlyTrashed()->where('user_id', Auth::id())->findOrFail($id);
        $complaint->restore();

        return redirect()->route('trash.index')->with('success', 'Pengaduan berhasil dipulihkan.');
    }

    /**
     * Menghapus pengaduan secara permanen.
     */
    public function forceDelete(string $id): RedirectResponse
    {
        $complaint = Complaint::onlyTrashed()->where('user_id', Auth::id())->findOrFail($id);

        foreach ($complaint->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
        }

        $complaint->forceDelete();
        return redirect()->route('trash.index')->with('success', 'Pengaduan berhasil dihapus permanen.');
    }

    /**
     * Mengosongkan semua item dari sampah.
     */
    public function emptyTrash(): RedirectResponse
    {
        $trashedComplaints = Complaint::onlyTrashed()->where('user_id', Auth::id())->get();

        foreach ($trashedComplaints as $complaint) {
            foreach ($complaint->photos as $photo) {
                Storage::disk('public')->delete($photo->path);
            }
            $complaint->forceDelete();
        }

        return redirect()->route('trash.index')->with('success', 'Sampah berhasil dikosongkan.');
    }
}