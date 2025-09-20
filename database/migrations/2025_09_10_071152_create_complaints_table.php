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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('category');
            
            // --- KOLOM-KOLOM TAMBAHAN LANGSUNG DI SINI ---
            $table->string('status')->default('Baru');
            $table->string('priority')->default('medium');
            $table->text('location_text')->nullable(); // Dari migrasi lama
            
            // Kolom alamat lengkap
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();
            $table->string('kampung')->nullable();
            $table->string('rt_rw', 15)->nullable();
            $table->string('foto_ktp')->nullable(); // Path untuk foto KTP
            
            $table->timestamps();
            $table->softDeletes(); // Untuk fitur 'trash'
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
