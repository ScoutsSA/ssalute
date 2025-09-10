<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commerce_wallet', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('accountID');
            $table->integer('transactionType');
            $table->string('transactionID', 1024);
            $table->decimal('transactionAmountINCVAT', 10);
            $table->dateTime('transactionDate');
            $table->integer('active');
            $table->integer('paidToGroup')->default(0);
            $table->date('paidToGroupDate')->nullable();

            $table->index(['accountID', 'transactionType', 'transactionAmountINCVAT'], 'accountid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commerce_wallet');
    }
};
