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
        Schema::create('ams_adult_leader_moves', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->index('assoctoregion');
            $table->integer('userID')->index('userid');
            $table->integer('fromPosition');
            $table->integer('ToPosition');
            $table->integer('fromGroup');
            $table->integer('toGroup');
            $table->integer('fromDistrict');
            $table->integer('toDistrict');
            $table->date('effectiveDate');
            $table->dateTime('created');
            $table->integer('createdby');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ams_adult_leader_moves');
    }
};
