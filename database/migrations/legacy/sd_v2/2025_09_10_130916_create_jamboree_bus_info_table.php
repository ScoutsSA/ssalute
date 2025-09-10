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
        Schema::create('jamboree_bus_info', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID')->default(0);
            $table->integer('regionID');
            $table->string('provider');
            $table->decimal('totalBusCost', 10)->nullable();
            $table->decimal('perSeatInvoiceAmountExVAT', 6)->nullable()->default(0);
            $table->string('busNr')->nullable();
            $table->integer('availableSeats');
            $table->string('departureLocation');
            $table->date('departureDate');
            $table->string('departureTime');
            $table->string('arrivalLocation')->nullable();
            $table->date('arrivalDate')->nullable();
            $table->string('arrivalTime', 100)->nullable();
            $table->integer('active')->default(1);
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
        Schema::dropIfExists('jamboree_bus_info');
    }
};
