<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commerce_shoppers_logins', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->dateTime('date');
            $table->string('ip');
            $table->string('fromLocation');
            $table->text('userAgent');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commerce_shoppers_logins');
    }
};
