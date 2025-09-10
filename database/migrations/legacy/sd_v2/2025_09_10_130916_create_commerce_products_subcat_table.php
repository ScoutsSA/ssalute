<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commerce_products_subcat', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('catID');
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->integer('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commerce_products_subcat');
    }
};
