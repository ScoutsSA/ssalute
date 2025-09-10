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
        Schema::create('group_financial_payments_made', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('invoiceID')->default(0);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup');
            $table->integer('accountID');
            $table->decimal('amount', 10);
            $table->date('payment_date');
            $table->integer('paymentType')->default(1)->comment('1 = Group Captured, 2 = From Wallet');
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToGroup', 'paymentType', 'active'], 'assoctogroup');
            $table->index(['assocToGroup', 'accountID', 'active'], 'assoctogroup_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_financial_payments_made');
    }
};
