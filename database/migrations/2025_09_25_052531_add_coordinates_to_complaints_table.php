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
        Schema::table('complaints', function (Blueprint $table) {
            // Menambahkan kolom latitude setelah kolom 'location_text'
            // Menggunakan decimal untuk presisi koordinat geografis
            $table->decimal('latitude', 10, 7)->nullable()->after('location_text');
            
            // Menambahkan kolom longitude setelah kolom 'latitude'
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            // Menghapus kolom jika migrasi di-rollback
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
