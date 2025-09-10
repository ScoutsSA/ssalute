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
        Schema::create('ams_training_courses_annual_dates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(1);
            $table->integer('courseID')->index('courseid');
            $table->integer('dayNr');
            $table->date('startDate');
            $table->time('startTime');
            $table->time('endTime');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ams_training_courses_annual_dates');
    }
};
