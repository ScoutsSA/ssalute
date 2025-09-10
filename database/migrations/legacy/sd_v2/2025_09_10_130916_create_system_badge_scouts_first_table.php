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
        Schema::create('system_badge_scouts_first', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1)->index('programtype');
            $table->integer('countryID')->default(196);
            $table->string('type', 25);
            $table->string('name');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('system_badge_scouts_first');
    }
};
