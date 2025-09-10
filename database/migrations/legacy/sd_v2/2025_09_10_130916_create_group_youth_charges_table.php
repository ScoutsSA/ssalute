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
        Schema::create('group_youth_charges', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('type', 12);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion');
            $table->integer('assocToDistrict');
            $table->integer('assocToGroup');
            $table->integer('userID');
            $table->integer('chargeTypeID');
            $table->string('chargeNr');
            $table->date('awardDate');
            $table->date('expireDate');
            $table->string('PDFLocation', 1024)->nullable();
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
        Schema::dropIfExists('group_youth_charges');
    }
};
