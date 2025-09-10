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
        Schema::create('ams_training_courses', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('courseType')->nullable();
            $table->integer('assocToRegion')->index('assoctoregion');
            $table->string('name');
            $table->string('agendaPDFLocation', 1024)->nullable();
            $table->string('materialPDFLocation', 1024)->nullable();
            $table->integer('nrOfDays');
            $table->integer('trainingSeats')->nullable();
            $table->integer('maxBookings')->nullable();
            $table->integer('active');
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
        Schema::dropIfExists('ams_training_courses');
    }
};
