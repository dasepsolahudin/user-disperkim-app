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
        // 2. Ambil semua pengaduan yang memiliki latitude dan longitude
        $complaints = Complaint::whereNotNull('latitude')
                               ->whereNotNull('longitude')
                               ->get();

        // 3. Kirim data complaints ke view
        return view('map.index', [
            'complaints' => $complaints
        ]);
    }
}