<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Cek apakah ada parameter 'lang' di URL dari link yang diklik
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            // 2. Pastikan bahasa valid (id/en) dan simpan di session
            if (in_array($locale, ['id', 'en'])) {
                Session::put('locale', $locale);
            }
        }

        // 3. Terapkan bahasa dari session pada setiap halaman yang dibuka
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

        return $next($request);
    }
}