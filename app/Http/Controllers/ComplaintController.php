<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    // Fungsi untuk menampilkan halaman form
    public function create()
    {
        return view('complaints.create');
    }
}
