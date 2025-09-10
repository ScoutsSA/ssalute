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
        Schema::create('ams_training_courses_annual_bookings_notes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('bookingID');
            $table->integer('annualCourseID');
            $table->integer('userID');
            $table->text('note');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby')->nullable();
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['annualCourseID', 'userID', 'active'], 'annualcourseid');
            $table->index(['userID', 'bookingID', 'annualCourseID', 'active'], 'userid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ams_training_courses_annual_bookings_notes');
    }
};
