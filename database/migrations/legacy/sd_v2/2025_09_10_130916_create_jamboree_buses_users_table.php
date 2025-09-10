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
        Schema::create('jamboree_buses_users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->integer('userID');
            $table->integer('busID');
            $table->text('notes')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['jamboreeID', 'active'], 'jamboreeid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jamboree_buses_users');
    }
};
