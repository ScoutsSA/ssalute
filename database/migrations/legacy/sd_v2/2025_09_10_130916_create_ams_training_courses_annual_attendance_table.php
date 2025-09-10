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
        Schema::create('ams_training_courses_annual_attendance', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->index('assoctoregion');
            $table->integer('annualCourseID');
            $table->integer('dayID');
            $table->date('dayDate');
            $table->integer('userID')->index('userid');
            $table->integer('attendance');
            $table->integer('active')->index('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['annualCourseID', 'userID', 'active', 'dayID'], 'annualcourseid');
            $table->index(['annualCourseID', 'userID', 'active', 'attendance'], 'annualcourseid_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ams_training_courses_annual_attendance');
    }
};
