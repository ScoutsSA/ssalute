<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jamboree_invoices_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('invoiceID')->index('invoiceid');
            $table->integer('applicantID');
            $table->string('description');
            $table->integer('number');
            $table->decimal('unitAmount');
            $table->decimal('totalAmount', 10);
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jamboree_invoices_items');
    }
};
