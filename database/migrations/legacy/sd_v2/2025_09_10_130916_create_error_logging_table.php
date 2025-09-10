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
        Schema::create('error_logging', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('page');
            $table->longText('POST')->nullable();
            $table->longText('errorsFound')->nullable();
            $table->integer('userID');
            $table->integer('roleID');
            $table->integer('nationalID');
            $table->integer('regionID')->nullable();
            $table->integer('districtID')->nullable();
            $table->integer('groupID')->nullable();
            $table->dateTime('created')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error_logging');
    }
};
