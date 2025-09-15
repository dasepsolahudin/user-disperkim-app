<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MapController extends Controller
{
    /**
     * Menampilkan halaman peta dengan semua lokasi pengaduan.
     */
    public function index(): View
    {
        // Ambil semua pengaduan yang memiliki koordinat latitude dan longitude
        $complaints = Complaint::whereNotNull('latitude')
                               ->whereNotNull('longitude')
                               ->get();

        return view('map.index', compact('complaints'));
    }
}