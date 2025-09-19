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
            $table->string('kampung')->nullable()->after('village');
            $table->string('rt')->nullable()->after('kampung');
            $table->string('rw')->nullable()->after('rt');
            $table->string('phone_number')->nullable()->after('rw');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn(['kampung', 'rt', 'rw', 'phone_number']);
        });
    }
};