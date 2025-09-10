<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_competitions_scoring', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('teamID');
            $table->integer('scoringAreaID');
            $table->integer('scoringSheetID');
            $table->integer('questionID');
            $table->integer('answerID');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedBy')->nullable();
            $table->text('notes')->nullable();

            $table->index(['eventID', 'active', 'scoringSheetID', 'questionID', 'answerID'], 'eventid');
            $table->index(['eventID', 'scoringAreaID', 'teamID', 'active'], 'eventid_2');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_competitions_scoring');
    }
};
