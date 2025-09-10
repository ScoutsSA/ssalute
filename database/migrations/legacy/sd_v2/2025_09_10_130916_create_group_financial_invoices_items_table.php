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
        Schema::create('group_financial_invoices_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('invoiceID');
            $table->integer('assocToGroup')->index('assoctogroup');
            $table->integer('accountID');
            $table->integer('financialYearID');
            $table->string('feeArea');
            $table->string('name');
            $table->string('description');
            $table->decimal('amount', 10);
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
        Schema::dropIfExists('group_financial_invoices_items');
    }
};
