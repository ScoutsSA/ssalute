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
        Schema::create('star_awards_notes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('groupID');
            $table->integer('denID')->nullable();
            $table->integer('packID')->nullable();
            $table->integer('troopID')->nullable();
            $table->integer('patrolID')->nullable();
            $table->integer('crewID')->nullable();
            $table->integer('noteType')->comment('1 = Group, 2 = District, 3 - Region, 4 = National');
            $table->text('note');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['groupID', 'active', 'noteType', 'created'], 'groupid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('star_awards_notes');
    }
};
