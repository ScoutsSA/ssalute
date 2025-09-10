<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_advancement_scouts_levels', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('scoutProgramTypeID')->default(1);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->string('name');
            $table->text('description');
            $table->string('htmlColor', 15)->nullable();
            $table->string('colour', 100)->nullable();
            $table->integer('highLevel')->default(1);
            $table->integer('investment')->default(0);
            $table->integer('active')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_advancement_scouts_levels');
    }
};
