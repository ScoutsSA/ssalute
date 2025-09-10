<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jamboree_position_offered', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('regionID');
            $table->integer('districtID');
            $table->integer('groupID');
            $table->integer('userID');
            $table->integer('parentID')->nullable();
            $table->integer('positionID');
            $table->integer('passportCountryID');
            $table->integer('passportCheck');
            $table->text('notes');
            $table->dateTime('created');
            $table->integer('offeredPosition')->nullable();
            $table->dateTime('offeredPositionDate')->nullable();
            $table->integer('offeredPositionBy')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jamboree_position_offered');
    }
};
