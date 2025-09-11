<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User; // <-- TAMBAHKAN INI
use App\Models\Complaint;
use App\Models\Announcement;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        // Ambil 4 berita terbaru yang sudah 'published'
        $latestNews = News::where('status', 'published')
                            ->latest('published_at')
                            ->take(4)
                            ->get();

        // Ambil pengumuman yang sedang aktif
        $activeAnnouncement = Announcement::where('starts_at', '<=', now())
                                            ->where('ends_at', '>=', now())
                                            ->first();

        // Ambil data statistik pengaduan
        $complaintStats = [
            'total' => Complaint::count(),
            'in_progress' => Complaint::where('status', 'Pengerjaan')->count(),
            'completed' => Complaint::where('status', 'Selesai')->count(),
            'active_users' => User::count(), // <-- TAMBAHKAN DATA PENGGUNA AKTIF
        ];
        // Kirim semua data ke view 'welcome'
        return view('welcome', [
            'latestNews' => $latestNews,
            'activeAnnouncement' => $activeAnnouncement,
            'complaintStats' => $complaintStats,
        ]);
    }
}