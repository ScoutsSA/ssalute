<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jamboree_info', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID');
            $table->integer('year');
            $table->string('currency', 10);
            $table->decimal('scoutCostExVAT', 6);
            $table->decimal('adultCostExVAT', 6);
            $table->decimal('kidCostExVAT', 6);
            $table->decimal('busDepositExVAT', 6);
            $table->integer('depositPercent');
            $table->integer('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jamboree_info');
    }
};
