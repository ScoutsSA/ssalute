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
        Schema::create('ams_training_locations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion');
            $table->string('name');
            $table->text('address');
            $table->string('gpsLat');
            $table->string('gpsLon');
            $table->integer('trainingSeats');
            $table->string('contact');
            $table->string('tel')->nullable();
            $table->string('cell')->nullable();
            $table->string('email')->nullable();
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['countryID', 'assocToRegion', 'active'], 'countryid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ams_training_locations');
    }
};
