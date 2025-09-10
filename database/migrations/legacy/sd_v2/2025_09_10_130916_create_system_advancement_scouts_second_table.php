<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_advancement_scouts_second', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('scoutProgramTypeID')->default(2);
            $table->integer('programType')->default(2);
            $table->integer('countryID')->default(196);
            $table->integer('position')->default(0);
            $table->integer('advancmentID')->index('advancmentid');
            $table->integer('theme')->nullable();
            $table->string('name')->nullable();
            $table->text('description');
            $table->string('short')->nullable();
            $table->integer('campingTask')->default(0);
            $table->integer('badgeTask')->default(0);
            $table->string('oldID', 11)->default('0');
            $table->integer('active')->default(1);
            $table->integer('PGATask')->default(0);

            $table->index(['programType', 'advancmentID', 'active'], 'programtype');
            $table->index(['programType', 'active'], 'programtype_2');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_advancement_scouts_second');
    }
};
