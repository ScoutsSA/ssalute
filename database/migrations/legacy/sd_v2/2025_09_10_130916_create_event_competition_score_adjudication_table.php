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
        Schema::create('event_competition_score_adjudication', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('teamID');
            $table->integer('scoringAreaID');
            $table->integer('adjudicationScore');
            $table->integer('active');
            $table->text('notes')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'teamID', 'scoringAreaID', 'active'], 'eventid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_competition_score_adjudication');
    }
};
