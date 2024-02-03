<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id');
            $table->foreignId('district_id');
            $table->foreignId('group_id');

            $table->string('type');
            $table->boolean('is_active')->default(1);

            $table->string('name')->nullable();
            $table->json('features_flags')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
