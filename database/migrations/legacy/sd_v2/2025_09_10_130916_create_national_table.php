<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('national', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->integer('countryID');
            $table->integer('active')->nullable()->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('national');
    }
};
