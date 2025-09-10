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
        Schema::create('jamboree_adult_allocations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->integer('subCampID')->default(0);
            $table->integer('activityCenterID')->default(0);
            $table->integer('baseID')->default(0);
            $table->integer('roleID');
            $table->integer('userID');
            $table->text('notes')->nullable();
            $table->integer('active');
            $table->integer('position')->nullable()->default(0);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jamboree_adult_allocations');
    }
};
