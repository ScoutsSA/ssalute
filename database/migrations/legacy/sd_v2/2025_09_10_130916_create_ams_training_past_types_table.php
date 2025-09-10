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
        Schema::create('ams_training_past_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->integer('code')->nullable();
            $table->string('calendarColour', 25)->nullable();
            $table->string('shortName');
            $table->text('description');
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(2);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ams_training_past_types');
    }
};
