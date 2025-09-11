<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke user
        $table->string('title');
        $table->text('description');
        $table->string('location_text')->nullable(); // Untuk lokasi teks
        // Nanti kita bisa tambahkan kolom untuk koordinat peta
        $table->enum('status', ['Baru', 'Verifikasi', 'Pengerjaan', 'Selesai', 'Ditolak'])->default('Baru');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
