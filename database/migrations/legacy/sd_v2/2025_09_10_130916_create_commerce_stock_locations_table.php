<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commerce_stock_locations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('name');
            $table->text('physAddress');
            $table->string('gpsLat', 12);
            $table->string('gpsLon', 12);
            $table->string('contactName');
            $table->string('contactCell', 25);
            $table->string('contactEmail');
            $table->integer('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commerce_stock_locations');
    }
};
