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
        Schema::create('commerce_orders', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('groupProduct')->nullable();
            $table->integer('userID');
            $table->integer('countryID')->nullable();
            $table->integer('regionID')->nullable();
            $table->integer('districtID')->nullable();
            $table->integer('groupID')->nullable();
            $table->integer('deliveryAddressID');
            $table->string('deliveryOption');
            $table->decimal('deliveryAmountIncVAT', 11)->default(0);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->integer('status')->nullable();
            $table->integer('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commerce_orders');
    }
};
