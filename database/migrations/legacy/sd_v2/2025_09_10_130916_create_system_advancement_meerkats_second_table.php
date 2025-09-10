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
        Schema::create('system_advancement_meerkats_second', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->integer('advancmentID')->index('advancmentid');
            $table->string('advancementArea')->nullable();
            $table->string('name');
            $table->string('short');
            $table->text('description');
            $table->integer('badgeTask')->default(0);
            $table->integer('theme')->default(0);
            $table->integer('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_advancement_meerkats_second');
    }
};
