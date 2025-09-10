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
        Schema::create('event_user_booking', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('status')->comment('1 = Provisional. 2 = Confirmed, 3 = Guaranteed, 4 = Cancelled');
            $table->integer('userID');
            $table->integer('travelArrangements')->nullable()->default(0);
            $table->integer('accommodationArrangements')->nullable()->default(0);
            $table->integer('apparelOption')->nullable();
            $table->integer('patrolID')->nullable();
            $table->integer('canAdmin');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['userID', 'active'], 'userid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_user_booking');
    }
};
