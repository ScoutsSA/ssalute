<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('groups_property_ownership_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->integer('owned')->default(0);
            $table->integer('rented')->default(0);
            $table->integer('active')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('groups_property_ownership_types');
    }
};
