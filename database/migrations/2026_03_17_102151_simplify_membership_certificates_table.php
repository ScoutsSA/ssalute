<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('membership_certificates', function (Blueprint $table) {
            $table->dropColumn(['generated_at', 'expires_at']);
            $table->dropIndex(['user_id']);
            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('membership_certificates', function (Blueprint $table) {
            $table->dropUnique(['user_id']);
            $table->index('user_id');
            $table->timestamp('generated_at')->nullable();
            $table->timestamp('expires_at')->nullable();
        });
    }
};
