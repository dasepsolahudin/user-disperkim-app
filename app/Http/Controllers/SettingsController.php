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
        $user = $request->user();
        $validPages = ['profile', 'security', 'notifications', 'appearance', 'delete', 'trash'];
        if (!in_array($section, $validPages)) {
            $section = 'profile';
        }

        // --- PENAMBAHAN LOGIKA STATISTIK ---
        $totalComplaints = Complaint::where('user_id', $user->id)->count();
        $completedComplaints = Complaint::where('user_id', $user->id)->where('status', 'Selesai')->count();
        $inProgressComplaints = $totalComplaints - $completedComplaints;

        $data = [
            'user' => $user,
            'section' => $section,
            'trashedComplaints' => collect(),
            'stats' => [
                'total' => $totalComplaints,
                'completed' => $completedComplaints,
                'in_progress' => $inProgressComplaints,
            ],
            // --- SELESAI PENAMBAHAN ---
        ];

        if ($section === 'trash') {
            $data['trashedComplaints'] = Complaint::onlyTrashed()
                ->where('user_id', $request->user()->id)
                ->latest('deleted_at')
                ->paginate(10, ['*'], 'trash_page');
        }
        
        return view('search.settings.edit', $data);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validatedData = $request->validated();

        // Update nama, email, dan nomor telepon
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        
        // --- PERBAIKAN: Mengganti logika alamat dengan nomor telepon ---
        // Menghapus logika alamat yang tidak digunakan lagi (city, district, village)
        // dan menambahkan pembaruan untuk phone_number.
        $user->phone_number = $validatedData['phone_number'] ?? null;
        // --- SELESAI PERBAIKAN ---

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // --- PERBAIKAN: Mengarahkan kembali ke section 'profile' setelah update ---
        return Redirect::route('settings.edit', ['section' => 'profile'])->with('status', 'profile-updated');
    }

    public function updatePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => ['required', 'image', 'max:2048'],
        ]);

        $user = $request->user();

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $path = $request->file('photo')->store('photos', 'public');
        $user->forceFill(['photo' => $path])->save();

        // --- PERBAIKAN: Mengarahkan kembali ke section 'profile' setelah update foto ---
        return Redirect::route('settings.edit', ['section' => 'profile'])->with('status', 'photo-updated');
    }

    // --- (Tidak ada perubahan pada metode di bawah ini, semua struktur Anda tetap sama) ---

    public function updateNotifications(Request $request): RedirectResponse
    {
        $user = $request->user();
        $request->validate([
            'push_notification' => 'nullable|boolean',
            'email_notification' => 'nullable|boolean',
            'sms_notification' => 'nullable|boolean',
            'auto_save' => 'nullable|boolean',
        ]);
        $preferences = $user->notification_preferences ?? [];
        $preferences['push_notification'] = $request->boolean('push_notification');
        $preferences['email_notification'] = $request->boolean('email_notification');
        $preferences['sms_notification'] = $request->boolean('sms_notification');
        $preferences['auto_save'] = $request->boolean('auto_save');
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