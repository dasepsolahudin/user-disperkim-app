<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Complaint;
use Illuminate\Support\Facades\Redirect; // Pastikan Redirect di-import

class SettingsController extends Controller
{
    /**
     * Menampilkan halaman pengaturan dengan section yang aktif.
     */
    public function edit(Request $request, $section = 'profile'): View
    {
        // PERBAIKAN: Tambahkan 'trash' ke daftar halaman yang valid
        $validPages = ['profile', 'security', 'notifications', 'appearance', 'delete', 'trash'];
        if (!in_array($section, $validPages)) {
            $section = 'profile';
        }

        $data = [
            'user' => $request->user(),
            'section' => $section,
        ];

        // PERBAIKAN: Jika section adalah 'trash', ambil data pengaduan dari sampah
        if ($section === 'trash') {
            $data['trashedComplaints'] = Complaint::onlyTrashed()
                ->where('user_id', $request->user()->id)
                ->latest('deleted_at')
                ->paginate(10, ['*'], 'trash_page');
        }

        return view('settings.edit', $data);
    }

    /**
     * Memperbarui informasi profil pengguna.
     * CATATAN: Mengubah nama fungsi 'update' menjadi 'updateProfile' agar lebih jelas
     */
    public function updateProfile(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return redirect()->route('settings.edit', 'profile')->with('status', 'profile-updated');
    }

    /**
     * Memperbarui foto profil pengguna.
     */
    public function updatePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = $request->user();

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $path = $request->file('photo')->store('profile-photos', 'public');
        $user->forceFill(['photo' => $path])->save();

        return back()->with('status', 'photo-updated');
    }

    /**
     * Memperbarui preferensi notifikasi pengguna.
     */
    public function updateNotifications(Request $request): RedirectResponse
    {
        $request->validate([
            'notifications_new_complaint' => 'sometimes|boolean',
            'notifications_complaint_updated' => 'sometimes|boolean',
            'notifications_via_email' => 'sometimes|boolean',
        ]);

        $user = $request->user();

        $preferences = $user->notification_preferences ?? [];
        $preferences['new_complaint'] = $request->has('notifications_new_complaint');
        $preferences['complaint_updated'] = $request->has('notifications_complaint_updated');
        $preferences['via_email'] = $request->has('notifications_via_email');

        $user->notification_preferences = $preferences;
        $user->save();
        
        return back()->with('status', 'notification-preferences-updated');
    }

    /**
     * Menghapus akun pengguna.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/');
    }

    // ==========================================================
    // FUNGSI-FUNGSI BARU UNTUK FITUR SAMPAH
    // ==========================================================

    /**
     * Menampilkan detail pengaduan yang ada di sampah.
     */
    public function showTrashed(string $id): View
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
        return redirect()->route('settings.edit', 'trash')->with('status', 'complaint-restored');
    }

    /**
     * Menghapus pengaduan secara permanen dari sampah.
     */
    public function forceDelete(string $id): RedirectResponse
    {
        $complaint = Complaint::onlyTrashed()->where('user_id', Auth::id())->findOrFail($id);
        
        foreach ($complaint->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
        }
        $complaint->forceDelete();

        return redirect()->route('settings.edit', 'trash')->with('status', 'complaint-deleted-permanently');
    }

    /**
     * Mengosongkan sampah dengan menghapus semua pengaduan yang di-soft-delete.
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

        return redirect()->route('settings.edit', 'trash')->with('status', 'trash-emptied');
    }
}

