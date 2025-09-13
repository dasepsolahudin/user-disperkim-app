<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SettingsController extends Controller
{


     public function updateNotificationPreferences(Request $request)
    {
        $user = Auth::user();

        $notificationPreferences = [
            'new_complaint' => $request->has('notification_preferences.new_complaint'),
            'complaint_approved' => $request->has('notification_preferences.complaint_approved'),
            'complaint_rejected' => $request->has('notification_preferences.complaint_rejected'),
        ];

        $user->notification_preferences = $notificationPreferences;
        $user->save();

        return back()->with('status', 'notification-preferences-updated');
    }
    /**
     * Menampilkan halaman pengaturan dengan section yang aktif.
     */
    public function edit(Request $request, $section = 'profile'): View
    {
       // PERBAIKAN: Tambahkan 'delete' ke halaman yang valid
    $validPages = ['profile', 'security', 'notifications', 'appearance', 'delete'];
    if (!in_array($section, $validPages)) {
        $section = 'profile'; 
    }

    return view('settings.edit', [
        'user' => $request->user(),
        'section' => $section, 
    ]);
    }

    /**
     * Memperbarui informasi profil pengguna.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
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
    public function updateNotifications(Request $request): RedirectResponse // PERBAIKAN: Mengubah return type menjadi RedirectResponse
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

        // PERBAIKAN: Menghapus kode berlebihan dan hanya mengembalikan redirect
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

    // CATATAN: Metode 'store' dan 'index' untuk pengaduan telah dihapus 
    // karena tidak relevan di controller ini dan sudah ditangani oleh ComplaintController.
    // Ini membuat kode lebih bersih dan terorganisir.
}