<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_competitions_questions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('internalCompetitionID');
            $table->integer('scoringAreaID');
            $table->integer('scoringSheetID');
            $table->integer('headingID');
            $table->string('question', 1024);
            $table->integer('position');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'active', 'internalCompetitionID', 'scoringAreaID', 'scoringSheetID', 'headingID'], 'eventid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_competitions_questions');
    }
};
