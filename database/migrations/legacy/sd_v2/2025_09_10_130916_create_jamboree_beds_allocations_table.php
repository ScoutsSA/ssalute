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
        Schema::create('jamboree_beds_allocations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('subcampID');
            $table->integer('troopID');
            $table->integer('patrolID');
            $table->integer('bedID');
            $table->integer('active')->default(1);

            $table->index(['patrolID', 'active'], 'subcampid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jamboree_beds_allocations');
    }
};
