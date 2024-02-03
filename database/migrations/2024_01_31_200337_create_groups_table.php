<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sd_group_id');
            $table->foreignId('region_id');
            $table->foreignId('district_id');

            $table->string('type');
            $table->boolean('is_active')->default(1);
            $table->boolean('managed_regionally')->default(0);

            $table->string('name');
            $table->string('email')->nullable();
            $table->string('description')->nullable();
            $table->string('scarf')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('google_maps')->nullable();
            $table->string('banking_details')->nullable();
            $table->string('website')->nullable();

            $table->json('related_social_links')->nullable(); // Facebook/Twitter/Instagram/YouTube etc
            $table->json('features_flags')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
