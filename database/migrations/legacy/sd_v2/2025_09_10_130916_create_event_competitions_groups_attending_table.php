<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_competitions_groups_attending', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('groupID');
            $table->integer('teamNumber');
            $table->string('teamName');
            $table->integer('scoreComplete');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'active'], 'eventid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_competitions_groups_attending');
    }
};
