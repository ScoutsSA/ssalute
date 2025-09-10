<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commerce_products_stock', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('productID')->index('productid');
            $table->integer('stockIn')->nullable();
            $table->integer('stockOut')->nullable();
            $table->dateTime('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commerce_products_stock');
    }
};
