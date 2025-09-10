<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_financial_invoices_emailed', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup');
            $table->integer('accountID');
            $table->integer('financialYearID');
            $table->integer('invoiceID');
            $table->dateTime('sentDate');
            $table->dateTime('created');
            $table->integer('createdby');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_financial_invoices_emailed');
    }
};
