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
            // Menambahkan kolom nomor telepon setelah kolom 'rt_rw'
            $table->string('phone_number')->nullable()->after('rt_rw');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn('phone_number');
        });
    }
};
