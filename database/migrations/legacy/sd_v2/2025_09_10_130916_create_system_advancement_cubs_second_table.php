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
        Schema::create('system_advancement_cubs_second', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->integer('advancmentID')->index('advancmentid');
            $table->string('advancementArea')->nullable();
            $table->string('name');
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_advancement_cubs_second');
    }
};
