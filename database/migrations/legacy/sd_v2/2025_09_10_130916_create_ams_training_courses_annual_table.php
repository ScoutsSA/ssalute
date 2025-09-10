<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ams_training_courses_annual', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('forAdultLeadersAndRovers')->default(1);
            $table->integer('forParents')->default(0);
            $table->integer('forScouts')->default(0);
            $table->integer('assocToRegion');
            $table->string('courseID')->index('courseid');
            $table->string('courseNumber');
            $table->integer('directorID');
            $table->string('name');
            $table->text('description');
            $table->integer('locationID');
            $table->integer('courseCost')->default(0);
            $table->date('bookingCutOffDate');
            $table->date('startDate');
            $table->date('endDate');
            $table->string('previousQuali')->nullable();
            $table->integer('maxBookings')->nullable();
            $table->integer('warrantCourse')->nullable();
            $table->string('ical', 1024)->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToRegion', 'active', 'bookingCutOffDate'], 'assoctoregion');
            $table->index(['countryID', 'assocToRegion', 'startDate', 'active'], 'countryid');
            $table->index(['countryID', 'assocToRegion', 'endDate', 'active'], 'countryid_2');
            $table->index(['locationID', 'startDate', 'active'], 'locationid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ams_training_courses_annual');
    }
};
