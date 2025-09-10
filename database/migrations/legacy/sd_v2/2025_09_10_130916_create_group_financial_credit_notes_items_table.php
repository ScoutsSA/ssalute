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
        Schema::create('group_financial_credit_notes_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('invoiceID')->nullable();
            $table->integer('creditNoteID');
            $table->integer('assocToGroup');
            $table->integer('accountID');
            $table->integer('financialYearID');
            $table->string('feeArea')->nullable();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('group_financial_credit_notes_items');
    }
};
