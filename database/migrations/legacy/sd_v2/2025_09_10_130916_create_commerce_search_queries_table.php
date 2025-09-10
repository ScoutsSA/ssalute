<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commerce_search_queries', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('name')->nullable();
            $table->integer('catID')->nullable();
            $table->integer('userID')->nullable();
            $table->integer('countryID');
            $table->integer('regionID');
            $table->integer('districtID');
            $table->integer('groupID');
            $table->date('date');
            $table->string('time', 10);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commerce_search_queries');
    }
};
