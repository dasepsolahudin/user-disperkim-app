<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Menampilkan hasil pencarian berdasarkan query.
     */
    public function results(Request $request)
    {
        // Validasi input, pastikan query tidak kosong
        $request->validate([
            'q' => 'required|string|min:3',
        ]);

        $query = $request->input('q');

        // Lakukan pencarian pada model Complaint di beberapa kolom yang relevan
        $complaints = Complaint::where(function ($dbQuery) use ($query) {
            $dbQuery->where('title', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->orWhere('category', 'LIKE', "%{$query}%")
                ->orWhere('location_text', 'LIKE', "%{$query}%")
                ->orWhere('address', 'LIKE', "%{$query}%");
        })
        ->latest() // Urutkan dari yang terbaru
        ->paginate(10); // Gunakan pagination untuk performa

        // Kembalikan view dengan data hasil pencarian
        return view('search.results', [
            'complaints' => $complaints,
            'query'      => $query,
        ]);
    }
}
