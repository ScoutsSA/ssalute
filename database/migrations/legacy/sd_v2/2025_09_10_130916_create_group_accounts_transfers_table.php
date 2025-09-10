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
        Schema::create('group_accounts_transfers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('fromCountryID');
            $table->integer('fromRegionID');
            $table->integer('fromDistrictID');
            $table->integer('fromGroupID');
            $table->integer('toCountryID');
            $table->integer('toRegionID');
            $table->integer('toDistrictID');
            $table->integer('toGroupID');
            $table->integer('accountID');
            $table->integer('action')->comment('1 = From SGL Must Approve, 2 = From Treasurer Must Approve, 3 = To SGL Must Approve');
            $table->text('notes');
            $table->integer('fromSGLApproved')->nullable();
            $table->integer('fromSGLID')->nullable();
            $table->dateTime('fromSGLApprovedDate')->nullable();
            $table->text('fromSGLNotes')->nullable();
            $table->integer('fromTreasurerApproved')->nullable();
            $table->integer('fromTreasurerID')->nullable();
            $table->dateTime('fromTreasurerApprovedDate')->nullable();
            $table->text('fromTreasurerNotes')->nullable();
            $table->integer('toSGLApproved')->nullable();
            $table->integer('toSGLID')->nullable();
            $table->dateTime('toSGLApprovedDate')->nullable();
            $table->text('toSGLNotes')->nullable();
            $table->dateTime('actualTransferDate')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['fromGroupID', 'action'], 'fromgroupid');
            $table->index(['toGroupID', 'action'], 'togroupid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_accounts_transfers');
    }
};
