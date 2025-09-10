<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_competitions_judges', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('userID');
            $table->integer('judgeTypeID');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'active', 'userID'], 'eventid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_competitions_judges');
    }
};
