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
            // Tambahkan kolom setelah 'location_text' atau sesuaikan
            $table->string('kabupaten')->nullable()->after('location_text');
            $table->string('kecamatan')->nullable()->after('kabupaten');
            $table->string('desa')->nullable()->after('kecamatan');
            $table->string('kampung')->nullable()->after('desa');
            $table->string('rt_rw')->nullable()->after('kampung');
            $table->string('foto_ktp')->nullable()->after('rt_rw'); // Kolom untuk foto KTP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn(['kabupaten', 'kecamatan', 'desa', 'kampung', 'rt_rw', 'foto_ktp']);
        });
    }
};
