<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_keys', function (Blueprint $table) {
            $table->integer('id', true);
            $table->longText('key');
            $table->integer('issuedToUserID');
            $table->longText('information');
            $table->integer('active');
            $table->dateTime('created');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_keys');
    }
};
