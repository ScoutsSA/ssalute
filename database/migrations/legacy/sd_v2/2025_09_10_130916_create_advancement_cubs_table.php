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
        Schema::create('advancement_cubs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(0);
            $table->integer('assocToDistrict')->default(0);
            $table->integer('assocToGroup');
            $table->integer('cubID');
            $table->integer('userID')->default(0);
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
            $table->index(['assocToDistrict', 'advancementID', 'advancementSecondID', 'advancementThirdID', 'active', 'advancementDate'], 'assoctodistrict_2');
            $table->index(['assocToGroup', 'cubID', 'active', 'advancementID', 'advancementSecondID', 'advancementThirdID'], 'assoctogroup');
            $table->index(['assocToGroup', 'advancementID', 'active', 'latest'], 'assoctogroup_2');
            $table->index(['assocToGroup', 'advancementID', 'advancementSecondID', 'advancementThirdID', 'active', 'latest'], 'assoctogroup_3');
            $table->index(['assocToGroup', 'advancementID', 'advancementSecondID', 'advancementThirdID', 'active', 'advancementDate'], 'assoctogroup_4');
            $table->index(['assocToGroup', 'active', 'advancementDate'], 'assoctogroup_5');
            $table->index(['assocToRegion', 'advancementID', 'active', 'latest'], 'assoctoregion');
            $table->index(['assocToRegion', 'advancementID', 'advancementSecondID', 'advancementThirdID', 'active', 'advancementDate'], 'assoctoregion_2');
            $table->index(['countryID', 'advancementID', 'active', 'latest'], 'countryid');
            $table->index(['countryID', 'advancementID', 'advancementSecondID', 'advancementThirdID', 'active', 'advancementDate'], 'countryid_2');
            $table->index(['cubID', 'advancementID', 'advancementSecondID', 'advancementThirdID', 'latest', 'active'], 'cubid');
            $table->index(['cubID', 'advancementSecondID', 'advancementThirdID', 'active'], 'cubid_2');
            $table->index(['cubID', 'advancementID', 'advancementSecondID', 'advancementThirdID', 'active', 'programType', 'themeID'], 'cubid_4');
            $table->index(['cubID', 'active'], 'cubid_5');
            $table->index(['cubID', 'advancementID', 'active'], 'cubid_6');
            $table->index(['cubID', 'advancementID', 'advancementThirdID', 'active', 'programType'], 'cubid_7');
            $table->index(['cubID', 'advancementID', 'advancementSecondID', 'advancementThirdID', 'themeID', 'active'], 'cubid_8');
            $table->index(['userID', 'PDFLocation'], 'userid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advancement_cubs');
    }
};
