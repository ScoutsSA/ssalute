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
        Schema::create('advancement_rovers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(0);
            $table->integer('assocToDistrict')->default(0);
            $table->integer('assocToGroup');
            $table->integer('roverID')->index('roverid');
            $table->integer('userID')->default(0);
            $table->integer('themeID')->default(0);
            $table->integer('advancementID')->index('advancementid');
            $table->integer('advancement2ID')->nullable();
            $table->date('advancementDate');
            $table->text('notes')->nullable();
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('latest')->default(0)->comment('1 = Active');
            $table->string('instructorsName')->nullable();
            $table->integer('active')->comment('1 = Latest');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToDistrict', 'advancementID', 'active', 'latest'], 'assoctodistrict');
            $table->index(['assocToGroup', 'advancementID', 'active', 'latest'], 'assoctogroup');
            $table->index(['assocToGroup', 'active', 'advancementDate'], 'assoctogroup_2');
            $table->index(['assocToRegion', 'advancementID', 'active', 'latest'], 'assoctoregion');
            $table->index(['countryID', 'advancementID', 'active', 'latest'], 'countryid');
            $table->index(['roverID', 'advancementID', 'advancement2ID', 'latest', 'active'], 'roverid_2');
            $table->index(['roverID', 'advancementID', 'advancement2ID', 'active', 'programType'], 'roverid_3');
            $table->index(['roverID', 'active'], 'roverid_4');
            $table->index(['userID', 'PDFLocation'], 'userid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advancement_rovers');
    }
};
