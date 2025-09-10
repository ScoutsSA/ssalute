<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('position')->default(0);
            $table->string('name');
            $table->string('short', 3)->nullable();
            $table->integer('usingAMS')->default(0)->comment('1 = Yes, 0 = No');
            $table->text('description');
            $table->text('phys_address');
            $table->integer('countryID');
            $table->integer('active')->default(1);
            $table->integer('accountID')->default(0);
            $table->integer('censusDone')->default(1);

            $table->index(['countryID', 'active'], 'phys_country_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
