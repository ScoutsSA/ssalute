<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ams_past_service_info', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->index('assoctoregion');
            $table->integer('assocToDistrict');
            $table->integer('userID')->index('userid');
            $table->integer('pastServiceType');
            $table->integer('assocToGroup');
            $table->date('startDate');
            $table->date('endDate');
            $table->string('otherRegionName')->nullable();
            $table->string('otherDistrictName')->nullable();
            $table->string('otherGroupName')->nullable();
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('toBeFixed')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ams_past_service_info');
    }
};
