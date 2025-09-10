<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ams_warrant_info', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(0)->index('assoctoregion');
            $table->integer('assocToDistrict')->default(0);
            $table->integer('assocToGroup')->default(0);
            $table->integer('userID');
            $table->integer('roleID')->nullable();
            $table->integer('warrantTypeID')->nullable();
            $table->string('warrantNr', 225);
            $table->string('warrantName')->nullable();
            $table->integer('limited')->default(0);
            $table->integer('appointment')->default(0);
            $table->string('PDFLocation', 1024)->nullable();
            $table->date('issueDate');
            $table->date('expireDate');
            $table->integer('cancellationTypeID')->nullable();
            $table->text('cancelationNotes')->nullable();
            $table->integer('expireEmailCount')->default(0);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['countryID', 'warrantNr', 'active'], 'countryid');
            $table->index(['userID', 'expireDate', 'active'], 'userid');
            $table->index(['userID', 'countryID', 'assocToRegion', 'assocToDistrict', 'assocToGroup', 'active', 'expireDate', 'roleID'], 'userid_2');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ams_warrant_info');
    }
};
