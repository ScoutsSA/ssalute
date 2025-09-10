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
        Schema::create('projects', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('projectForID');
            $table->integer('countryID')->default(0);
            $table->integer('regionID')->default(0);
            $table->integer('districtID')->default(0);
            $table->integer('groupID')->default(0);
            $table->integer('typeID');
            $table->string('name', 1024);
            $table->text('description');
            $table->text('aim');
            $table->date('startDate');
            $table->date('endDate')->nullable();
            $table->string('document')->nullable();
            $table->string('contactPerson');
            $table->string('contactEmail')->nullable();
            $table->string('contactCell')->nullable();
            $table->string('contactWebsite', 1024)->nullable();
            $table->integer('active');
            $table->integer('approved')->nullable()->default(0);
            $table->integer('approvedby')->nullable();
            $table->dateTime('approveddate')->nullable();
            $table->integer('declined')->nullable()->default(0);
            $table->integer('declinedby')->nullable();
            $table->dateTime('declineddate')->nullable();
            $table->text('declinedReason')->nullable();
            $table->text('declinedNotes')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['countryID', 'active', 'approved'], 'countryid');
            $table->index(['countryID', 'active', 'approved', 'typeID'], 'countryid_2');
            $table->index(['districtID', 'active', 'approved'], 'districtid');
            $table->index(['groupID', 'active', 'approved'], 'groupid');
            $table->index(['regionID', 'active', 'approved'], 'regionid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
