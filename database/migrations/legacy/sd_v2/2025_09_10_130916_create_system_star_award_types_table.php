<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_star_award_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->integer('area');
            $table->integer('active')->default(1);
            $table->integer('position');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_star_award_types');
    }
};
