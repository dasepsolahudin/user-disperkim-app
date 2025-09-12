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
            $table->boolean('notification_push')->default(true)->after('password');
            $table->boolean('notification_email')->default(false)->after('notification_push');
            $table->boolean('notification_sms')->default(true)->after('notification_email');
            $table->boolean('auto_save')->default(true)->after('notification_sms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'notification_push',
                'notification_email',
                'notification_sms',
                'auto_save',
            ]);
        });
    }
};
