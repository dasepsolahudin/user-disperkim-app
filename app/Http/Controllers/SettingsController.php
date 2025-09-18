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
        
        return view('settings.edit', $data);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Ambil semua data yang sudah lolos validasi (termasuk 'kabupaten', 'kecamatan', 'desa')
        $validatedData = $request->validated();

        // Lakukan pemetaan dari nama form ke nama kolom database
        $updateData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'nik' => $validatedData['nik'] ?? null,
            'phone' => $validatedData['phone'] ?? null,
            'gender' => $validatedData['gender'] ?? null,
            'province' => $validatedData['province'] ?? null,
            'rt' => $validatedData['rt'] ?? null,
            'rw' => $validatedData['rw'] ?? null,
            'city' => $validatedData['kabupaten'] ?? null,       // Peta: kabupaten -> city
            'district' => $validatedData['kecamatan'] ?? null, // Peta: kecamatan -> district
            'village' => $validatedData['desa'] ?? null,      // Peta: desa -> village
            'full_address' => $validatedData['address'] ?? null, // Peta: address -> full_address
        ];

        // Isi model User dengan data yang sudah dipetakan
        $user->fill($updateData);

        // Jika email diubah, perlu verifikasi ulang
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Simpan semua perubahan
        $user->save();

        return Redirect::route('settings.edit', ['section' => 'profile'])->with('status', 'profile-updated');
    }

    public function updatePhoto(Request $request): RedirectResponse
    {
        $request->validate(['photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048']);
        $user = $request->user();

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $path = $request->file('photo')->store('profile-photos', 'public');
        $user->forceFill(['photo' => $path])->save();

        return back()->with('status', 'photo-updated');
    }

    public function updateNotifications(Request $request): RedirectResponse
    {
        $user = $request->user();
        $preferences = $user->notification_preferences ?? [];
        $preferences['new_complaint'] = $request->has('notifications_new_complaint');
        $preferences['complaint_updated'] = $request->has('notifications_complaint_updated');
        $preferences['via_email'] = $request->has('notifications_via_email');
        $user->notification_preferences = $preferences;
        $user->save();
        
        return back()->with('status', 'notification-preferences-updated');
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