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
        Schema::create('ams_documents_groups', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->index('assoctoregion');
            $table->integer('assocToGroup')->index('assoctogroup');
            $table->integer('assocToDistrict')->index('assoctodistrict');
            $table->integer('documentTypeID');
            $table->string('description', 1024);
            $table->string('PDFLocation', 1024);
            $table->date('validUntilDate');
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
        Schema::dropIfExists('ams_documents_groups');
    }
};
