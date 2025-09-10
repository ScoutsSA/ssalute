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
        Schema::create('event_competitions_scoring_sheets', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('internalCompetitionID');
            $table->string('name');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->date('startDate');
            $table->string('startTime', 5);
            $table->date('endDate');
            $table->string('endTime', 5);
            $table->integer('usesGPS')->default(0);
            $table->integer('pdf')->default(1);
            $table->integer('registration')->default(0);
            $table->integer('medicalScore')->default(0);
            $table->integer('seaWorthynessScore')->default(0);

            $table->index(['eventID', 'active', 'internalCompetitionID'], 'eventid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_competitions_scoring_sheets');
    }
};
