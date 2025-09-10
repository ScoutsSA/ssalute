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
        Schema::create('event_competitions_finances_payments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('teamID');
            $table->integer('amount');
            $table->date('date');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'teamID', 'active'], 'eventid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_competitions_finances_payments');
    }
};
