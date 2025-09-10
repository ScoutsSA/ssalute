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
        Schema::create('system_badge_scouts_second', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('firstID')->index('firstid');
            $table->string('heading')->nullable();
            $table->text('task');
            $table->integer('position')->default(0);
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(1);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_badge_scouts_second');
    }
};
