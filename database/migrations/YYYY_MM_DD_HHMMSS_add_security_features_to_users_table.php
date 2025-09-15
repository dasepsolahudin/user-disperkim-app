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
            // Kolom untuk Autentikasi Dua Faktor (2FA)
            $table->string('two_factor_method')->default('none')->after('password');
            $table->string('phone_number')->nullable()->unique()->after('email');
            
            // Kolom untuk Notifikasi Keamanan
            $table->json('security_notifications')->nullable()->after('notification_preferences');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['two_factor_method', 'phone_number', 'security_notifications']);
        });
    }
};
