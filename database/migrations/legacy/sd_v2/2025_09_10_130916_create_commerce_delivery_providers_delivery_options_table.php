<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commerce_delivery_providers_delivery_options', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('providerID');
            $table->text('description');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commerce_delivery_providers_delivery_options');
    }
};
