<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_district_reports', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup');
            $table->date('reportMonth');
            $table->string('area');
            $table->integer('boys');
            $table->integer('girls');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_district_reports');
    }
};
