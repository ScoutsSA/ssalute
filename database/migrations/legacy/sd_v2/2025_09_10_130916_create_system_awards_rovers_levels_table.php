<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_awards_rovers_levels', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->string('name');
            $table->text('description');
            $table->string('htmlColor', 15)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_awards_rovers_levels');
    }
};
