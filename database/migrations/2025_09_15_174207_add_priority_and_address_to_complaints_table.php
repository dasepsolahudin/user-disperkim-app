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
            // Menambahkan kolom baru sesuai desain
            $table->string('priority')->default('Sedang')->after('category');
            $table->string('village')->nullable()->after('location_text');
            $table->string('district')->nullable()->after('location_text');
            $table->string('city')->nullable()->after('location_text');
            $table->string('sub_district')->nullable()->after('location_text'); // Untuk Kampung/RW
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn(['priority', 'village', 'district', 'city', 'sub_district']);
        });
    }
};