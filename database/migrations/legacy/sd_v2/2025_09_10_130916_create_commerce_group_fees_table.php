<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commerce_group_fees', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('accountID');
            $table->integer('countryID');
            $table->integer('regionID');
            $table->integer('districtID');
            $table->integer('groupID');
            $table->decimal('amount', 10);
            $table->integer('paidOutToGroup')->nullable();
            $table->dateTime('paidOutDate')->nullable();
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commerce_group_fees');
    }
};
