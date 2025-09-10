<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_competitions_judges_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->integer('canAdmin')->default(0);
            $table->integer('canCaptureScores')->default(0);
            $table->integer('canAdminJudges')->default(0);
            $table->integer('canAdminFinances')->default(0);
            $table->integer('canAdminTeams')->default(0);
            $table->integer('medical')->default(0);
            $table->integer('seaWorthiness')->default(0);
            $table->integer('active')->default(1)->index('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_competitions_judges_types');
    }
};
