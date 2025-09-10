<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_financial_credit_notes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('invoiceID')->nullable();
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup');
            $table->integer('accountID');
            $table->integer('financialYearID');
            $table->string('PDFLocation')->nullable();
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToGroup', 'accountID', 'active'], 'assoctogroup');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_financial_credit_notes');
    }
};
