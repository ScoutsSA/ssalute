<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('groups_property', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('groupID')->index('groupid');
            $table->integer('districtID')->index('districtid');
            $table->integer('regionID')->index('regionid');
            $table->integer('countryID')->default(196)->index('countryid');
            $table->integer('ownedRented')->nullable()->comment('1 = Owned, 2 = Rented');
            $table->string('landlordName')->nullable();
            $table->string('landlordContactPerson')->nullable();
            $table->string('landlordContactPersonCell', 25)->nullable();
            $table->string('landlordContactPersonEmail')->nullable();
            $table->text('propertyDescription')->nullable();
            $table->string('ERFno', 1024)->nullable();
            $table->string('ERFSize', 10)->nullable();
            $table->integer('propertyValuation')->nullable();
            $table->date('lastValuationDate')->nullable();
            $table->integer('improvementValue')->nullable();
            $table->date('leaseStartDate')->nullable();
            $table->date('leaseEndDate')->nullable();
            $table->date('leaseRenewalDate')->nullable();
            $table->text('leaseConditions')->nullable();
            $table->text('improvementsDescription')->nullable();
            $table->integer('monthlyRentalAmount')->nullable();
            $table->integer('monthlyRates')->nullable();
            $table->integer('monthlyElectricity')->nullable();
            $table->integer('monthlyWaterSewerage')->nullable();
            $table->string('insuranceCompany')->nullable();
            $table->string('insuranceContactPerson')->nullable();
            $table->string('insuranceContactPersonEmail', 100)->nullable();
            $table->string('insuranceContactPersonCell', 15)->nullable();
            $table->integer('insuranceValue')->nullable();
            $table->text('insuranceDetails')->nullable();
            $table->text('groupNotes')->nullable();
            $table->dateTime('created')->nullable();
            $table->integer('createdby')->nullable();
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('groups_property');
    }
};
