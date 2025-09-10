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
        Schema::create('group_equipment', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup');
            $table->string('name');
            $table->text('description');
            $table->integer('locationID');
            $table->integer('purchased')->comment('2 = Purchased, 1 = Donated');
            $table->integer('purchaseCost')->nullable();
            $table->integer('replacementCost')->nullable();
            $table->integer('totalPurchaseCost');
            $table->integer('totalReplacementCost');
            $table->date('purchaseDate');
            $table->text('purchaseLocation')->nullable();
            $table->integer('qty');
            $table->integer('insured')->comment('1 = Insured');
            $table->string('expectedLifeFromPurchaseDate');
            $table->string('assetCondition');
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_equipment');
    }
};
