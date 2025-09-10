<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->integer('sdLiteOnly')->default(0);
            $table->integer('usesGoScan')->nullable()->default(0);
            $table->integer('usesShop')->default(0);
            $table->integer('usesPayFees')->default(0);
            $table->integer('groupAccountID')->default(0);
            $table->string('scarf')->nullable();
            $table->integer('groupTypeID');
            $table->text('description')->nullable();
            $table->integer('multiDen')->default(0);
            $table->integer('multiPack')->default(0);
            $table->integer('multiTroop')->default(0);
            $table->integer('multiCrew')->default(0);
            $table->integer('meerkatProgramType')->default(1);
            $table->integer('cubProgramType')->default(1);
            $table->integer('scoutProgramType')->default(2)->comment('1 = Normal Scout Program, 2 = Entsha Scout Program');
            $table->integer('roverProgramType')->default(1);
            $table->integer('amsOnly')->default(0)->comment('1 = Yes, 0 = No');
            $table->integer('hasMeerkats')->default(0);
            $table->integer('hasCubs')->nullable()->default(1)->comment('1 = Yes');
            $table->integer('hasScouts')->nullable()->default(1)->comment('1 = Yes');
            $table->integer('hasRovers')->nullable()->default(0)->comment('1 = Yes');
            $table->integer('hasBranch1')->default(0);
            $table->integer('hasBranch2')->default(0);
            $table->integer('hasBranch3')->default(0);
            $table->integer('hasBranch4')->default(0);
            $table->integer('hasBranch5')->default(0);
            $table->integer('sendWeeklyMails')->default(0);
            $table->integer('assoc_to_district');
            $table->integer('assoc_to_region');
            $table->integer('roverAssocToGroup')->nullable()->default(0);
            $table->text('phys_address')->nullable();
            $table->text('postalAddress')->nullable();
            $table->integer('postalCountryID')->nullable()->default(196);
            $table->integer('phys_country_id')->nullable()->default(196);
            $table->text('bankingDetails')->nullable();
            $table->string('bankAccountName')->nullable();
            $table->string('bankName')->nullable();
            $table->string('branchName')->nullable();
            $table->string('branchCode')->nullable();
            $table->string('bankAccountNumber')->nullable();
            $table->text('invoiceNotes')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('googleplus')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('pintrest')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tumblr')->nullable();
            $table->string('googleMaps')->nullable();
            $table->string('gpsLat')->nullable();
            $table->string('gpsLon')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('active')->comment('1 = Active');
            $table->string('weatherID', 25)->nullable();
            $table->string('weatherLocationName')->nullable();
            $table->integer('managedRegionally')->default(0)->comment('1 = Yrs, 0 = No');
            $table->integer('canMoveToEntsha')->default(1);
            $table->integer('using20')->default(1);
            $table->string('groupRegNr', 25)->nullable();
            $table->integer('censusDone')->nullable();
            $table->dateTime('groupLastUpdated')->nullable();
            $table->integer('groupLastUpdatedBy')->nullable();

            $table->index(['active', 'assoc_to_district', 'assoc_to_region'], 'active');
            $table->index(['assoc_to_region', 'active', 'groupTypeID'], 'active_2');
            $table->index(['active', 'phys_country_id', 'managedRegionally'], 'active_3');
            $table->index(['assoc_to_district', 'active', 'groupTypeID'], 'assoc_to_district');
            $table->index(['phys_country_id', 'active', 'groupTypeID'], 'phys_country_id');
            $table->index(['roverAssocToGroup', 'active'], 'roverassoctogroup');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
