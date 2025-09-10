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
        Schema::create('districts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('regionID');
            $table->integer('superDistrictID')->default(0);
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('phys_address')->nullable();
            $table->integer('countryID')->default(196);
            $table->integer('active')->default(1);
            $table->integer('accountID')->default(0);
            $table->integer('censusDone')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['countryID', 'active'], 'countryid');
            $table->index(['countryID', 'regionID', 'active'], 'phys_country_id');
            $table->index(['regionID', 'active'], 'regionid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('districts');
    }
};
