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
        Schema::create('event_competitions_scoring_sheets_headings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('internalCompetitionID');
            $table->integer('scoringSheetID');
            $table->string('heading');
            $table->integer('position');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedBy')->nullable();

            $table->index(['eventID', 'active', 'internalCompetitionID', 'scoringSheetID'], 'eventid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_competitions_scoring_sheets_headings');
    }
};
