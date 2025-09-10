<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_district_reports_scouts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID');
            $table->integer('assocToRegion');
            $table->integer('assocToDistrict');
            $table->integer('assocToGroup');
            $table->date('reportMonth');
            $table->date('LastMonth');
            $table->integer('lastMonthBoys');
            $table->integer('lastMonthGirls');
            $table->integer('thisMonthBoys');
            $table->integer('thisMonthGirls');
            $table->integer('jttBoys');
            $table->integer('jttGirls');
            $table->integer('lttBoys');
            $table->integer('lttGirls');
            $table->integer('leavingBoys');
            $table->integer('leavingGirls');
            $table->integer('toRoversBoys');
            $table->integer('toRoversGirls');
            $table->integer('usMale');
            $table->integer('usFemale');
            $table->integer('parentHelperMale');
            $table->integer('parentHelperFemale');
            $table->integer('committeeMale');
            $table->integer('committeeFemale');
            $table->integer('membershipBoys');
            $table->integer('membershipGirls');
            $table->integer('pfBoys');
            $table->integer('pfGirls');
            $table->integer('adBoys');
            $table->integer('adGirls');
            $table->integer('fcBoys');
            $table->integer('fcGirls');
            $table->integer('exBoys');
            $table->integer('exGirls');
            $table->integer('spBoys');
            $table->integer('spGirls');
            $table->integer('badgesBoys');
            $table->integer('badgesGirls');
            $table->integer('advBoys');
            $table->integer('advGirls');
            $table->text('advancement');
            $table->text('troopActivity');
            $table->text('groupActivity');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_district_reports_scouts');
    }
};
