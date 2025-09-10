<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jamboree_core_team', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID')->default(2);
            $table->integer('userID');
            $table->integer('canAdmin')->default(0);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jamboree_core_team');
    }
};
