<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ams_documents', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('userID');
            $table->integer('assocToRegion')->index('assoctoregion');
            $table->integer('assocToGroup')->index('assoctogroup');
            $table->integer('assocToDistrict')->index('assoctodistrict');
            $table->integer('documentTypeID')->index('documenttypeid');
            $table->string('description');
            $table->string('PDFLocation', 1024);
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['userID', 'active'], 'userid');
            $table->index(['userID', 'documentTypeID', 'active'], 'userid_2');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ams_documents');
    }
};
