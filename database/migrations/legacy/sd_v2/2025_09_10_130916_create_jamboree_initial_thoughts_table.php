<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jamboree_initial_thoughts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID')->default(2);
            $table->integer('userID');
            $table->text('thought');
            $table->integer('active');
            $table->dateTime('created');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jamboree_initial_thoughts');
    }
};
