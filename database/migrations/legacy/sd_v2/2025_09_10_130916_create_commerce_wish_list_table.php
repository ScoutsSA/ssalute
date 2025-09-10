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
        Schema::create('commerce_wish_list', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('accountID');
            $table->integer('productID');
            $table->integer('qty');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['accountID', 'active'], 'accountid');
            $table->index(['userID', 'id'], 'userid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commerce_wish_list');
    }
};
