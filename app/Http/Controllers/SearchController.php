<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil kata kunci pencarian dari input form
        $query = $request->input('q');

        // 2. Lakukan pencarian jika ada query
        $complaints = collect(); // Buat koleksi kosong sebagai default
        if ($query) {
            $complaints = Complaint::where('title', 'LIKE', "%{$query}%")
                                   ->orWhere('description', 'LIKE', "%{$query}%")
                                   ->latest() // Urutkan dari yang terbaru
                                   ->paginate(10); // Gunakan paginasi
        }

        // 3. Kembalikan view dengan hasil pencarian
        return view('search.results', [
            'query' => $query,
            'complaints' => $complaints
        ]);
    }
}
