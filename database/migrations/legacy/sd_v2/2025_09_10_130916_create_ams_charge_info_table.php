<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ams_charge_info', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->index('assoctoregion');
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup')->nullable();
            $table->integer('userID')->index('userid');
            $table->integer('chargeTypeID');
            $table->string('chargeNr', 225);
            $table->string('PDFLocation', 1024)->nullable();
            $table->date('issueDate');
            $table->date('expireDate');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ams_charge_info');
    }
};
