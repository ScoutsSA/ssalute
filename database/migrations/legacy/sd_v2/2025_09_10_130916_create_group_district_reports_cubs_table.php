<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_district_reports_cubs', function (Blueprint $table) {
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
            $table->integer('jtpBoys');
            $table->integer('jtpGirls');
            $table->integer('ltpBoys');
            $table->integer('ltpGirls');
            $table->integer('leavingBoys');
            $table->integer('leavingGirls');
            $table->integer('toScoutsBoys');
            $table->integer('toScoutsGirls');
            $table->integer('usMale');
            $table->integer('usFemale');
            $table->integer('parentHelperMale');
            $table->integer('parentHelperFemale');
            $table->integer('committeeMale');
            $table->integer('committeeFemale');
            $table->integer('membershipBoys');
            $table->integer('membershipGirls');
            $table->integer('swBoys');
            $table->integer('swGirls');
            $table->integer('gwBoys');
            $table->integer('gwGirls');
            $table->integer('lwBoys');
            $table->integer('lwGirls');
            $table->integer('badgesBoys');
            $table->integer('badgesGirls');
            $table->integer('advBoys');
            $table->integer('advGirls');
            $table->text('advancement');
            $table->text('packActivity');
            $table->text('groupActivity');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_district_reports_cubs');
    }
};
