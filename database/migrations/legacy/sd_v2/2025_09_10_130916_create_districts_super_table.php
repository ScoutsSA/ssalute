<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('districts_super', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('regionID');
            $table->string('name');
            $table->text('description');
            $table->integer('active')->default(1)->index('countryid');
            $table->integer('accountID')->default(0);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['countryID', 'regionID', 'active'], 'phys_country_id');
            $table->index(['regionID', 'active'], 'regionid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('districts_super');
    }
};
