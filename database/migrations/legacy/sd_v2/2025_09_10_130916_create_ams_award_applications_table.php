<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ams_award_applications', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->index('assoctoregion');
            $table->integer('userID')->index('userid');
            $table->integer('awardHeadingID');
            $table->integer('awardTypeID');
            $table->string('PDFLocation', 1024);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->dateTime('awardDate')->nullable();
            $table->integer('awardedBy')->nullable();
            $table->dateTime('declinedDate')->nullable();
            $table->integer('declinedBy')->nullable();
            $table->string('awardType')->nullable();
            $table->text('awardDescription')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ams_award_applications');
    }
};
