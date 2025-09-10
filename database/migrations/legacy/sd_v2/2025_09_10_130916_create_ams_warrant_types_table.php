<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ams_warrant_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('position')->default(0);
            $table->string('name');
            $table->string('shortName');
            $table->text('description');
            $table->integer('national')->default(0);
            $table->integer('region')->default(0);
            $table->integer('district')->default(0);
            $table->integer('group')->default(0);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(2);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ams_warrant_types');
    }
};
