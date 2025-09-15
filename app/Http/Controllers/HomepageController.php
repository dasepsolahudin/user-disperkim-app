<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomepageController extends Controller
{
    /**
     * Menampilkan halaman utama (landing page).
     */
    public function index(): View
    {
        // Mengambil data statistik
        $stats = [
            'total'       => Complaint::count(),
            'in_progress' => Complaint::where('status', 'Pengerjaan')->count(),
            'completed'   => Complaint::where('status', 'Selesai')->count(),
            'users'       => User::count(),
        ];

        // Mengambil 4 berita terbaru
        $latestNews = News::where('status', 'published')
                           ->orderBy('published_at', 'desc')
                           ->limit(4)
                           ->get();

        // Mengirim data ke view
        return view('welcome', [
            'stats' => $stats,
            'news' => $latestNews,
        ]);
    }
}