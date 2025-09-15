<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi disesuaikan dengan nama input dari form
        //    Asumsi nama input di form masih kabupaten, kecamatan, dll.
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'kabupaten' => ['nullable', 'string', 'max:255'],
            'kecamatan' => ['nullable', 'string', 'max:255'],
            'desa' => ['nullable', 'string', 'max:255'],
            // tambahkan validasi untuk field lain jika ada di form
        ]);

        // 2. Saat membuat user, petakan nama input ke nama kolom database yang benar
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
            // --- INI BAGIAN PERBAIKANNYA ---
            // 'nama_kolom_database' => $request->nama_input_form
            'city' => $request->kabupaten,      // Menyimpan data 'kabupaten' ke kolom 'city'
            'district' => $request->kecamatan,    // Menyimpan data 'kecamatan' ke kolom 'district'
            'village' => $request->desa,         // Menyimpan data 'desa' ke kolom 'village'
            // Anda bisa tambahkan pemetaan untuk provinsi, rt, rw jika ada di form
            // 'province' => $request->provinsi,
            // 'rt' => $request->rt,
            // 'rw' => $request->rw,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}

