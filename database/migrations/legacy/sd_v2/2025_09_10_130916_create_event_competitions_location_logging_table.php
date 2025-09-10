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
        Schema::create('event_competitions_location_logging', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID')->nullable();
            $table->integer('groupID')->nullable();
            $table->integer('districtID')->nullable();
            $table->integer('regionID')->nullable();
            $table->integer('roleID')->nullable();
            $table->integer('userID');
            $table->string('userAgent')->nullable();
            $table->decimal('accuracy', 11)->nullable()->comment('radius of accuracy meters');
            $table->decimal('altitude', 11, 3)->nullable()->comment('meters above sea level');
            $table->string('altitudeAccuracy')->nullable()->comment('radius of altitude accuracy meters');
            $table->string('heading')->nullable()->comment('Degrees from true North');
            $table->decimal('latitude', 11, 8);
            $table->decimal('longitude', 11, 8);
            $table->decimal('speed', 11, 3)->nullable()->comment('meters per second');
            $table->integer('speedDone')->default(0);
            $table->date('date')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
            $table->integer('used')->default(0);

            $table->index(['eventID', 'groupID', 'active', 'roleID', 'created'], 'eventid');
            $table->index(['eventID', 'groupID', 'active', 'roleID', 'latitude', 'longitude'], 'eventid_2');
            $table->index(['eventID', 'active'], 'eventid_3');
            $table->index(['groupID', 'active', 'speed'], 'for speed');
            $table->index(['groupID', 'roleID', 'active', 'latitude', 'longitude', 'used'], 'groupid');
            $table->index(['groupID', 'roleID', 'active', 'created'], 'groupid_2');
            $table->index(['eventID', 'userID', 'speed', 'active'], 'userid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_competitions_location_logging');
    }
};
