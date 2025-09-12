<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // ✅ Halaman Edit Profil
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    // ✅ Update Profil
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            }

            $path = $request->file('photo')->store('profile-photos', 'public');
            $validated['photo'] = $path;
            $user = Auth::user();

        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update nama
        $user->name = $request->name;

        // Upload foto
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->photo = $path; // simpan path ke database
        }
        

        // Update user
        $user->photo = $path;
        $user->save();

        return response()->json([
            'success' => true,
            'photo_url' => asset('storage/'.$path),
        ]);
    }
}
