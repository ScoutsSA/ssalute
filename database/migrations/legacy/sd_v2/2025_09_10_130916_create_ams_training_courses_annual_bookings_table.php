<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ams_training_courses_annual_bookings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('status')->index('status')->comment('1 = Provisional, 2 = Confirmed, 3 = Guaranteed, 4 = Cancelled');
            $table->integer('assocToRegion')->index('assoctoregion');
            $table->string('bookingLocation', 100)->default('AMS');
            $table->integer('annualCourseID');
            $table->integer('userID');
            $table->text('instructions')->nullable();
            $table->text('previousCourses')->nullable();
            $table->string('invoiceLocation', 1024)->nullable();
            $table->string('POPLocation', 1024)->nullable();
            $table->integer('bugMailCount')->nullable()->default(0);
            $table->integer('active')->default(1);
            $table->integer('completionConfirmed')->default(0);
            $table->string('userPIN')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['active', 'assocToRegion'], 'active');
            $table->index(['annualCourseID', 'active', 'status'], 'annualcourseid');
            $table->index(['userID', 'active', 'status', 'created'], 'userid');
            $table->index(['userID', 'active', 'created'], 'userid_2');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ams_training_courses_annual_bookings');
    }
};
