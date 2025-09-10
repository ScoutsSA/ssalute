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
        Schema::create('api_usage', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('IPAddress', 45)->nullable();
            $table->string('APICalled', 45)->nullable();
            $table->longText('userAgent')->nullable();
            $table->longText('keyUsed')->nullable();
            $table->longText('presented')->nullable();
            $table->longText('response')->nullable();
            $table->dateTime('created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_usage');
    }
};
