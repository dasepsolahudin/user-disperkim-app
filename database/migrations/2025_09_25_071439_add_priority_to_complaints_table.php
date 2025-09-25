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
        // Cek dulu apakah kolom 'priority' BELUM ADA
        if (!Schema::hasColumn('complaints', 'priority')) {
            Schema::table('complaints', function (Blueprint $table) {
                // Jika belum ada, baru tambahkan kolomnya
                $table->string('priority')->default('Sedang')->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cek dulu apakah kolom 'priority' SUDAH ADA
        if (Schema::hasColumn('complaints', 'priority')) {
            Schema::table('complaints', function (Blueprint $table) {
                // Jika ada, baru hapus kolomnya
                $table->dropColumn('priority');
            });
        }
    }
};