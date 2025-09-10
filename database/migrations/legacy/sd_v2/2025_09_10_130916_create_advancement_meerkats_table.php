<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advancement_meerkats', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(0);
            $table->integer('assocToDistrict')->default(0);
            $table->integer('assocToGroup');
            $table->integer('meerkatID')->nullable();
            $table->integer('userID')->nullable();
            $table->integer('themeID')->default(0);
            $table->integer('advancementID')->index('advancementid');
            $table->integer('advancementSecondID')->nullable();
            $table->integer('advancementThirdID')->nullable();
            $table->text('notes')->nullable();
            $table->string('PDFLocation')->nullable();
            $table->date('advancementDate')->nullable();
            $table->integer('latest')->default(0)->comment('1 = latest');
            $table->string('instructorsName')->nullable();
            $table->integer('active')->default(0)->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToDistrict', 'advancementID', 'active', 'latest'], 'assoctodistrict');
            $table->index(['assocToGroup', 'active', 'advancementID', 'advancementSecondID', 'advancementThirdID'], 'assoctogroup');
            $table->index(['assocToGroup', 'advancementID', 'active', 'latest'], 'assoctogroup_2');
            $table->index(['assocToGroup', 'active', 'advancementDate'], 'assoctogroup_3');
            $table->index(['assocToRegion', 'advancementID', 'active', 'latest'], 'assoctoregion');
            $table->index(['countryID', 'advancementID', 'active', 'latest'], 'countryid');
            $table->index(['advancementID', 'advancementSecondID', 'advancementThirdID', 'latest', 'active'], 'cubid');
            $table->index(['advancementSecondID', 'advancementThirdID', 'active'], 'cubid_2');
            $table->index(['userID', 'active', 'latest'], 'userid');
            $table->index(['userID', 'advancementID', 'advancementSecondID', 'advancementThirdID', 'active', 'programType', 'themeID'], 'userid_2');
            $table->index(['userID', 'active'], 'userid_3');
            $table->index(['userID', 'PDFLocation'], 'userid_4');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advancement_meerkats');
    }
};
