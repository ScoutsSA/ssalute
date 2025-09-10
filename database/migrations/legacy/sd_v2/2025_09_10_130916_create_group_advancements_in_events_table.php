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
        Schema::create('group_advancements_in_events', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup');
            $table->integer('scoutProgramTypeID')->default(1);
            $table->string('type', 15)->comment('Cub Or Scout');
            $table->integer('eventID');
            $table->integer('firstID')->default(0);
            $table->integer('secondID')->default(0);
            $table->integer('thirdID')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_advancements_in_events');
    }
};
