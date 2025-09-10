<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ams_training_courses_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->string('colour', 100);
            $table->integer('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ams_training_courses_types');
    }
};
