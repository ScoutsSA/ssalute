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
        Schema::create('jamboree_troop_patrol_allocations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('troopID');
            $table->integer('patrolID')->nullable();
            $table->integer('roleID');
            $table->integer('active')->default(1);
            $table->text('notes')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['troopID', 'roleID', 'active'], 'troopid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jamboree_troop_patrol_allocations');
    }
};
