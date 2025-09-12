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
    /**
     * Menampilkan halaman pengaturan dengan section yang aktif.
     */
    public function edit(Request $request, $section = 'profile'): View
    {
        // Daftar section yang diizinkan untuk keamanan
        $validSections = ['profile', 'security', 'notifications'];
        if (!in_array($section, $validSections)) {
            abort(404);
        }

        // Ini adalah baris kunci yang memperbaiki error.
        // Kita mengirimkan 'section' ke view.
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
}