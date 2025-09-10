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
        Schema::create('event_competitions_survey_responses', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->text('cookieID')->nullable();
            $table->string('userIP')->nullable();
            $table->string('teamName')->nullable();
            $table->integer('initialRegistration')->nullable();
            $table->text('improveInitialRegistration')->nullable();
            $table->integer('communicationPrior')->nullable();
            $table->text('improveCommunicationsPrior')->nullable();
            $table->integer('communicationDuring')->nullable();
            $table->integer('qualityCommunicationDuring')->nullable();
            $table->integer('judging')->nullable();
            $table->integer('judgesEngageWithPL')->nullable();
            $table->text('judgingSuggestions')->nullable();
            $table->text('improveCommunicationsDuring')->nullable();
            $table->text('improveJudging')->nullable();
            $table->text('suggestions')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent()->index('created');

            $table->index(['eventID', 'active'], 'eventid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_competitions_survey_responses');
    }
};
