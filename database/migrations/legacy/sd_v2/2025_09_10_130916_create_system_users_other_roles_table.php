<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_users_other_roles', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('countryID')->default(196);
            $table->integer('regionID')->default(0);
            $table->integer('superDistrictID')->nullable();
            $table->integer('districtID')->default(0);
            $table->integer('groupID')->default(0);
            $table->integer('roleID')->default(0);
            $table->integer('defaultRole')->default(0);
            $table->integer('active');
            $table->text('creationNotes')->nullable();
            $table->integer('actionCountryID')->default(0);
            $table->integer('actionRegionID')->default(0);
            $table->integer('actionSuperDistrictID')->default(0);
            $table->integer('actionDistrictID')->default(0);
            $table->integer('actionGroupID')->default(0);
            $table->integer('retired')->default(0);
            $table->integer('resigned')->default(0);
            $table->integer('suspended')->default(0);
            $table->integer('multiID')->default(0);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['actionCountryID', 'active', 'roleID'], 'actioncountryid');
            $table->index(['actionCountryID', 'userID', 'active'], 'actioncountryid_2');
            $table->index(['actionDistrictID', 'active', 'roleID'], 'actiondistrictid');
            $table->index(['actionGroupID', 'active', 'roleID'], 'actiongroupid');
            $table->index(['actionRegionID', 'active', 'roleID'], 'actionregionid');
            $table->index(['countryID', 'userID', 'active', 'roleID'], 'countryid');
            $table->index(['countryID', 'roleID', 'active'], 'countryid_3');
            $table->index(['countryID', 'active'], 'countryid_4');
            $table->index(['districtID', 'userID', 'active', 'roleID'], 'districtid');
            $table->index(['districtID', 'roleID', 'active'], 'districtid_2');
            $table->index(['districtID', 'active'], 'districtid_3');
            $table->index(['actionCountryID', 'active', 'defaultRole'], 'form29');
            $table->index(['groupID', 'userID', 'active', 'roleID'], 'groupid');
            $table->index(['groupID', 'roleID', 'active'], 'groupid_2');
            $table->index(['groupID', 'active'], 'groupid_3');
            $table->index(['regionID', 'userID', 'active', 'roleID'], 'regionid');
            $table->index(['regionID', 'roleID', 'active'], 'regionid_2');
            $table->index(['regionID', 'active'], 'regionid_3');
            $table->index(['roleID', 'active'], 'roleid');
            $table->index(['roleID', 'active', 'defaultRole'], 'roleid_2');
            $table->index(['userID', 'active', 'defaultRole'], 'userid');
            $table->index(['userID', 'active', 'id'], 'userid_2');
            $table->index(['userID', 'roleID', 'active', 'actionCountryID', 'actionRegionID', 'actionDistrictID', 'actionGroupID'], 'userid_3');
            $table->index(['userID', 'active', 'actionGroupID'], 'userid_4');
            $table->index(['userID', 'actionRegionID', 'active', 'roleID'], 'userid_5');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_users_other_roles');
    }
};
