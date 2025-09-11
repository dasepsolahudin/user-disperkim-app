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
        Schema::table('users', function (Blueprint $table) {
            $table->string('kabupaten')->nullable()->after('email');
            $table->string('kecamatan')->nullable()->after('kabupaten');
            $table->string('desa')->nullable()->after('kecamatan');
            $table->string('kampung')->nullable()->after('desa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['kabupaten', 'kecamatan', 'desa', 'kampung']);
        });
    }
};