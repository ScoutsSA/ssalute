<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commerce_delivery_address', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('accountID')->nullable();
            $table->integer('defaultAddress')->default(0);
            $table->string('name');
            $table->string('unitNr')->nullable();
            $table->string('complexName')->nullable();
            $table->string('streetNr', 10);
            $table->string('streetName');
            $table->string('suburb')->nullable();
            $table->string('city');
            $table->string('province');
            $table->string('postCode', 5);
            $table->string('country');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['accountID', 'active', 'defaultAddress'], 'accountid');
            $table->index(['id', 'accountID'], 'id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commerce_delivery_address');
    }
};
