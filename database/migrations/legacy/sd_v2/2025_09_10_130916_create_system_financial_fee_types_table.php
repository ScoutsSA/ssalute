<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_financial_fee_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->text('description');
            $table->integer('canBeProrated')->default(0)->comment('1 = Yes, 0 = No');
            $table->integer('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_financial_fee_types');
    }
};
