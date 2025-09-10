<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ams_training_past', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable()->index('assoctoregion');
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup')->nullable();
            $table->integer('userID');
            $table->integer('trainingTypeID')->nullable();
            $table->text('courseName')->nullable();
            $table->string('courseNumber');
            $table->date('completionDate');
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('validated')->default(0)->comment('1 = Validated');
            $table->dateTime('validatedDate')->nullable();
            $table->integer('validatedby')->nullable();

            $table->index(['userID', 'active', 'trainingTypeID'], 'userid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ams_training_past');
    }
};
