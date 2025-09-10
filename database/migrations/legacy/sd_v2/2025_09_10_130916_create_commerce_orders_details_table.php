<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commerce_orders_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('orderID');
            $table->integer('userID');
            $table->integer('productID');
            $table->integer('qty');
            $table->decimal('unitPriceIncVat', 7);
            $table->integer('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commerce_orders_details');
    }
};
