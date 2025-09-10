<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_program_types_rovers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_program_types_rovers');
    }
};
