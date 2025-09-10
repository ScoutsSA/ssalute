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
        Schema::create('ams_training_courses_annual_bookings_tracking', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('bookingID')->index('bookingid');
            $table->integer('annualCourseID')->index('annualcourseid');
            $table->integer('userID')->index('userid');
            $table->integer('fromStatus');
            $table->integer('toStatus');
            $table->dateTime('created');
            $table->integer('createdby')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ams_training_courses_annual_bookings_tracking');
    }
};
