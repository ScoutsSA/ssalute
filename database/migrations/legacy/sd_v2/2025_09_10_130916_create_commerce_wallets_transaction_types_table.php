<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commerce_wallets_transaction_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->text('description');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commerce_wallets_transaction_types');
    }
};
