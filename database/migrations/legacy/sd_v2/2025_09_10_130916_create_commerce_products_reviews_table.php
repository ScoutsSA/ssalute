<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commerce_products_reviews', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('productID');
            $table->integer('userID');
            $table->text('review');
            $table->integer('stars')->nullable();
            $table->integer('active');
            $table->dateTime('created')->index('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['productID', 'active'], 'productid');
            $table->index(['userID', 'active'], 'userid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commerce_products_reviews');
    }
};
