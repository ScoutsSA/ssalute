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
        Schema::create('jamboree_eoi', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->integer('userID');
            $table->integer('roleID');
            $table->integer('countryID');
            $table->integer('regionID');
            $table->integer('districtID');
            $table->integer('groupID');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jamboree_eoi');
    }
};
