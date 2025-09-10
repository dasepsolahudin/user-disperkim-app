<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Announcement::create([
            'title' => 'Pemberitahuan Pemadaman Air Sementara',
            'content' => 'Akan ada pemadaman air untuk keperluan perawatan pada tanggal 15 September 2025 dari jam 09:00 hingga 15:00. Mohon untuk menampung air secukupnya.',
            'level' => 'warning',
            'starts_at' => now()->subDay(), // Mulai dari kemarin
            'ends_at' => now()->addDays(7), // Berakhir 7 hari dari sekarang
        ]);
    }
}