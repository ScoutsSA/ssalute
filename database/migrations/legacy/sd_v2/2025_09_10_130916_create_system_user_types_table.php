<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_user_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->text('description');
            $table->integer('sysAdmin')->default(0);
            $table->integer('nationalRole')->default(0);
            $table->integer('regionalRole')->default(0);
            $table->integer('superDistrictRole')->default(0);
            $table->integer('districtRole')->default(0);
            $table->integer('groupRole')->default(0);
            $table->integer('denRole')->default(0);
            $table->integer('packRole')->default(0);
            $table->integer('troopRole')->default(0);
            $table->integer('crewRole')->default(0);
            $table->integer('adultLeaderRole')->default(0);
            $table->integer('parentHelperRole')->default(0);
            $table->integer('alumniRole')->default(0);
            $table->integer('warrantedRole')->default(0);
            $table->integer('appointmentRole')->default(0);
            $table->integer('requiresCriminalClearance')->default(1);
            $table->integer('signsLeft')->nullable();
            $table->integer('signsRight')->nullable();
            $table->integer('chargeRole')->default(0);
            $table->integer('active')->default(1);
            $table->integer('position')->default(0);
            $table->integer('canAdminAlumni')->default(0);
            $table->integer('canSeeAlumni')->default(0);
            $table->integer('canAdminNational')->default(0);
            $table->integer('canSeeNational')->default(0);
            $table->integer('canAdminRegion')->default(0);
            $table->integer('canSeeRegion')->default(0);
            $table->integer('canAdminRegionKids')->default(0);
            $table->integer('canAdminRegionTraining')->default(0);
            $table->integer('canAdminSuperDistrict')->default(0);
            $table->integer('canSeeSuperDistrict')->default(0);
            $table->integer('canAdminDistrict')->default(0);
            $table->integer('canSeeDistrict')->default(0);
            $table->integer('canAdminDistrictKids')->default(0);
            $table->integer('canAdminGroup')->default(0);
            $table->integer('canSeeGroup')->default(0);
            $table->integer('canAdminGroupAdults')->default(0);
            $table->integer('canAwardGroupMeerkats')->default(0);
            $table->integer('canAwardGroupCubs')->default(0);
            $table->integer('canAwardGroupScouts')->default(0);
            $table->integer('canAwardGroupRovers')->default(0);
            $table->integer('canSeeSupport')->default(1);
            $table->integer('canAdminSupport')->default(0);
            $table->integer('canAddWarrants')->default(0);
            $table->integer('canAdminProperty')->default(0);
            $table->integer('canSignWarrants')->default(0);
            $table->integer('canAdminForm29')->default(0);
            $table->integer('canAdminPoliceClearance')->default(0);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(1);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['id', 'countryID'], 'id');
            $table->index(['id', 'adultLeaderRole', 'warrantedRole'], 'id_2');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_user_types');
    }
};
