<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLang(Request $request)
    {
        $request->validate([
            'lang' => 'required|in:id,en',
        ]);

        Session::put('locale', $request->lang);

        return redirect()->back();
    }
}