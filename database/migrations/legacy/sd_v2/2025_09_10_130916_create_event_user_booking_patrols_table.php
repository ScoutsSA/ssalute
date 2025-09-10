<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_user_booking_patrols', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->string('name');
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
        Schema::dropIfExists('event_user_booking_patrols');
    }
};
