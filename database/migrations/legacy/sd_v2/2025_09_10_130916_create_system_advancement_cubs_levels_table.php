<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_advancement_cubs_levels', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->string('name');
            $table->text('description');
            $table->integer('highLevel')->default(0);
            $table->integer('investment')->default(0);
            $table->string('colour', 25)->nullable();
            $table->integer('active')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_advancement_cubs_levels');
    }
};
