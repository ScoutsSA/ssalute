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
        Schema::create('ams_warrant_extensions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable()->index('assoctoregion');
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup')->nullable();
            $table->integer('warrantID')->index('warrantid');
            $table->integer('userID')->index('userid');
            $table->date('oldExpireDate');
            $table->date('newExpireDate');
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('active')->default(1);
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
        Schema::dropIfExists('ams_warrant_extensions');
    }
};
