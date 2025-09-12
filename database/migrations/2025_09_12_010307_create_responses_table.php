<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_responses_table.php

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
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->constrained()->onDelete('cascade'); // Relasi ke tabel complaints
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users (petugas yg menjawab)
            $table->text('content'); // Isi tanggapan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};