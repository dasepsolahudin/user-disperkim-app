<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Mengganti bahasa aplikasi dan menyimpannya di session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLang(Request $request)
    {
        $request->validate([
            'locale' => 'required|in:id,en', // Memastikan hanya bahasa yang didukung yang bisa dipilih
        ]);

        Session::put('locale', $request->locale);

        return redirect()->back();
    }
}

