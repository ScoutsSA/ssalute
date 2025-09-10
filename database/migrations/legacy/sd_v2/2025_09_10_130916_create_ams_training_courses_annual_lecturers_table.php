<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ams_training_courses_annual_lecturers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('annualCourseID');
            $table->integer('lecturerID');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['annualCourseID', 'active'], 'annualcourseid');
            $table->index(['lecturerID', 'annualCourseID', 'active'], 'lecturerid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ams_training_courses_annual_lecturers');
    }
};
