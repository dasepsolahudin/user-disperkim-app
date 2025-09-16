<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client; // <-- Tambahkan ini
use GuzzleHttp\Exception\RequestException; // <-- Tambahkan ini

class DashboardController extends Controller
{
    public function index(): View
    {
        // Mengambil data statistik (tidak berubah)
        $stats = Complaint::where('user_id', Auth::id())
            ->selectRaw("count(*) as total")
            ->selectRaw("count(case when status = 'in_progress' then 1 end) as in_progress")
            ->first();

        // --- PERBAIKAN: Menggunakan Guzzle untuk mengambil berita ---
        $newsItems = [];
        $client = new Client(['verify' => false]); // 'verify' => false untuk mengatasi masalah SSL jika ada
        $rssFeedUrl = 'https://news.google.com/rss/search?q=Disperkim%20Garut&hl=id&gl=ID&ceid=ID:id';

        try {
            // Lakukan permintaan GET ke Google News
            $response = $client->request('GET', $rssFeedUrl);
            $xmlString = $response->getBody()->getContents();
            $xml = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOCDATA);

            if ($xml !== false && isset($xml->channel->item)) {
                $items = $xml->channel->item;
                $count = 0;
                foreach ($items as $item) {
                    if ($count >= 5) break;

                    $description = (string) $item->description;
                    preg_match('/<img src="([^"]+)"/', $description, $matches);
                    $imageUrl = $matches[1] ?? null;

                    $newsItems[] = [
                        'title' => (string) $item->title,
                        'link' => (string) $item->link,
                        'pubDate' => (string) $item->pubDate,
                        'source' => (string) $item->source,
                        'image' => $imageUrl,
                    ];
                    $count++;
                }
            }
        } catch (RequestException $e) {
            // Jika Guzzle gagal, biarkan newsItems kosong
            // Anda bisa menambahkan log di sini: \Log::error($e->getMessage());
            $newsItems = [];
        }

        // Jika berita masih kosong setelah mencoba dengan Guzzle, tampilkan berita cadangan
        if (empty($newsItems)) {
            $newsItems = $this->getFallbackNews();
        }

        return view('dashboard', [
            'stats' => $stats,
            'newsItems' => $newsItems
        ]);
    }

    /**
     * Menyediakan data berita statis jika berita realtime gagal.
     */
    private function getFallbackNews(): array
    {
        return [
            [
                'title' => 'Disperkim Garut Fokus Selesaikan Program Rutilahu Tahun Ini',
                'link' => '#',
                'pubDate' => now()->subDays(1)->toRfc822String(),
                'source' => 'Info Garut',
                'image' => null, // Berita cadangan tidak punya gambar
            ],
            [
                'title' => 'Perbaikan Drainase di Kecamatan Tarogong Kidul Jadi Prioritas',
                'link' => '#',
                'pubDate' => now()->subDays(2)->toRfc822String(),
                'source' => 'Berita Garut',
                'image' => null,
            ],
        ];
    }
}