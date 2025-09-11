<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna sudah login DAN memiliki peran 'admin'
        if (Auth::check() && Auth::user()->role == 'admin') {
            // Jika ya, izinkan akses ke halaman selanjutnya
            return $next($request);
        }

        // Jika tidak, tolak dan kembalikan ke dashboard dengan pesan error
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki hak akses admin.');
    }
}