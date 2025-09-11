<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint; // Tambahkan ini untuk mengambil data

class PengaduanController extends Controller
{
    public function index()
    {
        // Ambil data pengaduan milik pengguna yang sedang login
        $complaints = Complaint::where('user_id', auth()->id())->latest()->get();

        // Kirim data ke view
        return view('pengaduan.index', compact('complaints'));
    }
/**
     * Display the specified resource.
     *
     * @param  \App\Models\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function show(Complaint $complaint)
    {
        // Pengecekan keamanan: Pastikan pengguna hanya bisa melihat pengaduannya sendiri
        if ($complaint->user_id !== auth()->id()) {
            abort(403, 'UNAUTHORIZED ACTION.');
        }

        return view('pengaduan.show', compact('complaint'));
    }

    // ... (method lainnya jika ada) ...
}