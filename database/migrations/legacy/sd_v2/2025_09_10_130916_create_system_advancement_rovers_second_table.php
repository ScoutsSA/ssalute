<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_advancement_rovers_second', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->integer('advancmentID');
            $table->integer('theme')->default(0);
            $table->string('name');
            $table->text('description');
            $table->string('short')->nullable();
            $table->integer('campingTask')->default(0);
            $table->integer('badgeTask')->default(0);
            $table->integer('active')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_advancement_rovers_second');
    }
};
