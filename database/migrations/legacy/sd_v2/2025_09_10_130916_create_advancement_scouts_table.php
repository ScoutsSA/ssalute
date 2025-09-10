<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advancement_scouts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(0);
            $table->integer('assocToDistrict')->default(0);
            $table->integer('assocToGroup');
            $table->integer('scoutProgramTypeID')->default(1);
            $table->integer('scoutID');
            $table->integer('userID')->nullable()->default(0);
            $table->integer('themeID')->default(0);
            $table->integer('advancementID')->index('advancementid');
            $table->integer('advancement2ID')->nullable();
            $table->date('advancementDate');
            $table->text('notes')->nullable();
            $table->string('PDFLocation')->nullable();
            $table->integer('latest')->default(0)->comment('1 = latest');
            $table->string('instructorsName')->nullable();
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->dateTime('approvedDate')->nullable();
            $table->integer('approvedBy')->nullable();

            $table->index(['assocToDistrict', 'advancementID', 'active', 'latest'], 'assoctodistrict');
            $table->index(['assocToDistrict', 'advancementID', 'advancement2ID', 'themeID', 'active', 'advancementDate'], 'assoctodistrict_2');
            $table->index(['assocToGroup', 'advancementID', 'active', 'latest'], 'assoctogroup');
            $table->index(['assocToGroup', 'advancementID', 'advancement2ID', 'themeID', 'active', 'advancementDate'], 'assoctogroup_2');
            $table->index(['assocToGroup', 'active', 'advancementDate'], 'assoctogroup_3');
            $table->index(['assocToRegion', 'advancementID', 'active', 'latest'], 'assoctoregion');
            $table->index(['assocToRegion', 'advancementID', 'advancement2ID', 'themeID', 'active', 'advancementDate'], 'assoctoregion_2');
            $table->index(['countryID', 'advancementID', 'advancement2ID', 'active'], 'countryid');
            $table->index(['countryID', 'advancementID', 'active', 'latest'], 'countryid_2');
            $table->index(['countryID', 'advancementID', 'advancement2ID', 'themeID', 'active', 'advancementDate'], 'countryid_3');
            $table->index(['createdby', 'programType', 'approvedBy', 'active'], 'createdby');
            $table->index(['createdby', 'approvedBy', 'active'], 'createdby_2');
            $table->index(['programType', 'scoutID', 'advancementID', 'advancement2ID'], 'programtype');
            $table->index(['programType', 'scoutID', 'advancement2ID', 'active'], 'programtype_2');
            $table->index(['scoutID', 'active'], 'scoutid');
            $table->index(['scoutID', 'advancementID', 'advancement2ID', 'latest', 'active'], 'scoutid_2');
            $table->index(['scoutID', 'assocToGroup', 'advancementID', 'advancement2ID', 'active'], 'scoutid_3');
            $table->index(['scoutID', 'advancementID', 'advancement2ID', 'active'], 'scoutid_4');
            $table->index(['scoutID', 'advancementID', 'themeID', 'active', 'advancement2ID'], 'scoutid_5');
            $table->index(['scoutID', 'advancementID', 'advancement2ID', 'active', 'programType', 'themeID'], 'scoutid_6');
            $table->index(['scoutID', 'advancementID', 'active'], 'scoutid_7');
            $table->index(['scoutProgramTypeID', 'scoutID', 'advancementID', 'advancement2ID', 'latest', 'active'], 'scoutprogramtypeid');
            $table->index(['userID', 'PDFLocation'], 'userid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advancement_scouts');
    }
};
