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
        Schema::create('jamboree_invoices', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('userID');
            $table->decimal('invoiceAmountExVat')->nullable();
            $table->decimal('invoiceVATAmount')->nullable();
            $table->decimal('invoiceTotalAmount')->nullable();
            $table->date('dueDate');
            $table->string('PDFLocation')->nullable();
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
        Schema::dropIfExists('jamboree_invoices');
    }
};
