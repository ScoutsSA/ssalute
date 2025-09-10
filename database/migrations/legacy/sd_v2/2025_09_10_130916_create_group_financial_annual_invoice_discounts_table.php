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
        Schema::create('group_financial_annual_invoice_discounts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup')->index('assoctogroup');
            $table->integer('accountID');
            $table->string('description');
            $table->decimal('amount', 10);
            $table->integer('amountIncludesVAT')->comment('1 = Yes');
            $table->integer('financialYear');
            $table->integer('active')->comment('1 = active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['accountID', 'financialYear', 'active'], 'accountid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_financial_annual_invoice_discounts');
    }
};
