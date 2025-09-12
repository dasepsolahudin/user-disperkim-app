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
            // Cek apabila kolom ada sebelum dihapus
            if (Schema::hasColumn('users', 'alamat_lengkap')) {
                $table->dropColumn('alamat_lengkap');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kembali kolom jika migrasi di-rollback
            $table->text('alamat_lengkap')->nullable()->after('desa');
        });
    }
};
