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
     * Memperbarui preferensi notifikasi pengguna.
     */
    public function updateNotifications(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'notification_push' => 'required|boolean',
            'notification_email' => 'required|boolean',
            'notification_sms' => 'required|boolean',
            'auto_save' => 'required|boolean',
        ]);

        $request->user()->forceFill($validated)->save();

        return response()->json(['status' => 'success']);
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

    /**
     * Menyimpan pengaduan yang baru dibuat.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:rutilahu,infrastruktur,tata-kota,air-bersih-sanitasi',
            'location_text' => 'required|string',
            'photos' => 'required|array|min:3',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'ktp_photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $complaint = Complaint::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'location_text' => $request->location_text,
            'status' => 'pending',
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('complaint-photos', 'public');
                ComplaintPhoto::create([
                    'complaint_id' => $complaint->id,
                    'photo_path' => $path,
                ]);
            }
        }

        if ($request->hasFile('ktp_photo')) {
            $path = $request->file('ktp_photo')->store('ktp-photos', 'public');
            $user = Auth::user();
            $user->ktp_photo_path = $path;
            $user->save();
        }

        return redirect()->route('complaints.index')->with('success', 'Pengaduan berhasil dikirim.');
    }

    /**
     * Menampilkan daftar pengaduan.
     */
    public function index()
    {
        $complaints = Complaint::where('user_id', Auth::id())->latest()->paginate(10);
        return view('complaints.index', compact('complaints'));
    }

}
