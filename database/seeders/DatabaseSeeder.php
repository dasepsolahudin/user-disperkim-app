<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * * Fungsi ini adalah "otak" dari seeder, yang akan dijalankan
     * saat Anda mengetik `php artisan db:seed` di terminal.
     */
    public function run(): void
    {
        // Perintah $this->call() adalah cara kita memberitahu "manajer"
        // untuk memanggil seeder lain yang lebih spesifik.
        // Urutan di dalam array ini penting.
        $this->call([
            NewsSeeder::class,          // Pertama, jalankan NewsSeeder
            AnnouncementSeeder::class,  // Kedua, jalankan AnnouncementSeeder
        ]);
    }
}