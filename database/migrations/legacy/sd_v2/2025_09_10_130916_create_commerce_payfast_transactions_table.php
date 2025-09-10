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
        Schema::create('commerce_payfast_transactions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('accountID');
            $table->integer('userID');
            $table->string('status', 100);
            $table->decimal('amount', 10);

            $table->index(['accountID', 'status'], 'accountid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commerce_payfast_transactions');
    }
};
