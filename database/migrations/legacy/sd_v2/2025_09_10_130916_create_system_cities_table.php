<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_cities', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->integer('active');

            $table->index(['countryID', 'active'], 'countryid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_cities');
    }
};
