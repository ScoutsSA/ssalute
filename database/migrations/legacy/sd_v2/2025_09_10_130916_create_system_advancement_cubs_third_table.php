<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_advancement_cubs_third', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->integer('advancmentID')->index('advancmentid');
            $table->integer('secondID')->index('secondid');
            $table->string('challenge', 50)->nullable();
            $table->integer('theme')->default(0);
            $table->string('note')->nullable();
            $table->string('name');
            $table->text('description');
            $table->string('short')->nullable();
            $table->integer('campingTask')->default(0);
            $table->integer('badgeTask')->default(0);
            $table->integer('active')->default(1);

            $table->index(['challenge', 'active', 'programType'], 'challenge');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_advancement_cubs_third');
    }
};
