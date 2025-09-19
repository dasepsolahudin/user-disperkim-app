<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Complaint;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    /**
     * Menampilkan halaman pengaturan dengan section yang aktif.
     */
    public function edit(Request $request, $section = 'profile'): View
    {
        $validPages = ['profile', 'security', 'notifications', 'appearance', 'delete', 'trash'];
        if (!in_array($section, $validPages)) {
            $section = 'profile';
        }

        $data = [
            'user' => $request->user(),
            'section' => $section,
            'trashedComplaints' => collect(), 
        ];

        if ($section === 'trash') {
            $data['trashedComplaints'] = Complaint::onlyTrashed()
                ->where('user_id', $request->user()->id)
                ->latest('deleted_at')
                ->paginate(10, ['*'], 'trash_page');
        }
        
    return view('settings.edit', compact('section')); // Baris ini kemungkinan menjadi masalah.
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Ambil semua data yang sudah divalidasi
        $validatedData = $request->validated();

        // Update nama dan email
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        
        // PERBAIKAN: Mapping data alamat dari form ke database
        $user->city = $validatedData['kabupaten'] ?? null;
        $user->district = $validatedData['kecamatan'] ?? null;
        $user->village = $validatedData['desa'] ?? null;

        // Cek jika email diubah untuk verifikasi ulang
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('settings.edit')->with('status', 'profile-updated');
    }

    public function updatePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => ['required', 'image', 'max:2048'],
        ]);

        $user = $request->user();

        // Hapus foto lama jika ada
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $path = $request->file('photo')->store('photos', 'public');
        $user->forceFill(['photo' => $path])->save();

        return Redirect::route('settings.edit')->with('status', 'photo-updated');
    }


    public function updateNotifications(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validasi input
        $request->validate([
            'push_notification' => 'nullable|boolean',
            'email_notification' => 'nullable|boolean',
            'sms_notification' => 'nullable|boolean',
            'auto_save' => 'nullable|boolean',
        ]);

        // Mengambil preferensi yang sudah ada atau membuat array kosong
        $preferences = $user->notification_preferences ?? [];

        // Memperbarui preferensi dengan nilai dari request
        $preferences['push_notification'] = $request->boolean('push_notification');
        $preferences['email_notification'] = $request->boolean('email_notification');
        $preferences['sms_notification'] = $request->boolean('sms_notification');
        $preferences['auto_save'] = $request->boolean('auto_save');

        // Simpan preferensi yang diperbarui ke database
        $user->notification_preferences = $preferences;
        $user->save();

        return Redirect::route('settings.edit', ['section' => 'notifications'])->with('status', 'notification-preferences-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', ['password' => ['required', 'current_password']]);
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->to('/');
    }
    
    // --- Metode untuk Fitur Sampah ---

    public function showTrashed(string $id): View
    {
        $complaint = Complaint::onlyTrashed()->where('user_id', Auth::id())->findOrFail($id);
        return view('complaints.show', compact('complaint'));
    }

    public function restore(string $id): RedirectResponse
    {
        $complaint = Complaint::onlyTrashed()->where('user_id', Auth::id())->findOrFail($id);
        $complaint->restore();
        return redirect()->route('settings.edit', 'trash')->with('status', 'complaint-restored');
    }

    public function forceDelete(string $id): RedirectResponse
    {
        $complaint = Complaint::onlyTrashed()->where('user_id', Auth::id())->findOrFail($id);
        foreach ($complaint->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
        }
        $complaint->forceDelete();
        return redirect()->route('settings.edit', 'trash')->with('status', 'complaint-deleted-permanently');
    }

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
    
    public function updateTwoFactorAuthentication(Request $request): JsonResponse
    {
        $request->validate([
            'sms' => 'sometimes|boolean',
            'email' => 'sometimes|boolean',
        ]);
        $user = $request->user();
        if ($request->has('sms')) {
            $user->two_factor_sms_enabled = $request->sms;
        }
        if ($request->has('email')) {
            $user->two_factor_email_enabled = $request->email;
        }
        $user->save();
        return response()->json(['status' => 'success', 'message' => 'Pengaturan 2FA diperbarui.']);
    }
}