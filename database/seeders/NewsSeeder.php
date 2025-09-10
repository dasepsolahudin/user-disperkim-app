<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        News::create([
            'title' => 'Perbaikan Jalan di Sektor A Telah Selesai',
            'slug' => 'perbaikan-jalan-sektor-a-selesai',
            'content' => 'Pekerjaan perbaikan jalan utama di Sektor A telah rampung dan kini dapat dilalui oleh semua kendaraan. Terima kasih atas kesabaran warga.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        News::create([
            'title' => 'Program Penghijauan Tahap II Akan Dimulai Minggu Depan',
            'slug' => 'program-penghijauan-tahap-ii',
            'content' => 'Menyusul kesuksesan tahap pertama, program penghijauan akan dilanjutkan dengan penanaman 1000 pohon baru di area taman kota.',
            'status' => 'published',
            'published_at' => now()->subDay(), // Dipublish kemarin
        ]);

        News::create([
            'title' => 'Jadwal Fogging Demam Berdarah untuk Bulan Ini',
            'slug' => 'jadwal-fogging-demam-berdarah',
            'content' => 'Berikut adalah jadwal lengkap pelaksanaan fogging untuk memberantas nyamuk Aedes aegypti di seluruh wilayah perumahan.',
            'status' => 'published',
            'published_at' => now()->subDays(2), // Dipublish 2 hari yang lalu
        ]);
    }
}