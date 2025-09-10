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
        Schema::create('scouter_reviews', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('countryID');
            $table->integer('regionID');
            $table->integer('districtID');
            $table->integer('groupID');
            $table->integer('roleID');
            $table->text('review');
            $table->string('reviewedFor');
            $table->integer('stars');
            $table->integer('active');
            $table->integer('approved')->default(0);
            $table->integer('approvedby')->nullable();
            $table->dateTime('approvedDate')->nullable();
            $table->integer('declined')->default(0);
            $table->integer('declinedby')->nullable();
            $table->dateTime('declinedDate')->nullable();
            $table->text('declinedReason')->nullable();
            $table->text('declinedNotes')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['active', 'approved', 'declined'], 'active');
            $table->index(['countryID', 'active', 'approved'], 'countryid');
            $table->index(['districtID', 'active', 'approved'], 'districtid');
            $table->index(['groupID', 'active', 'approved'], 'groupid');
            $table->index(['regionID', 'active', 'approved'], 'regionid');
            $table->index(['userID', 'active', 'approved'], 'userid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scouter_reviews');
    }
};
