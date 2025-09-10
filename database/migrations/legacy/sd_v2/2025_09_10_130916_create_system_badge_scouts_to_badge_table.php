<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_badge_scouts_to_badge', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('badgeID');
            $table->integer('toBadgeTaskID');
            $table->integer('active')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_badge_scouts_to_badge');
    }
};
