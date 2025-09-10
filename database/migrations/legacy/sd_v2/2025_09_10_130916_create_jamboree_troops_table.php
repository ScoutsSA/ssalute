<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jamboree_troops', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->string('name');
            $table->integer('subCampID')->nullable();
            $table->string('colour', 25);
            $table->integer('active')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jamboree_troops');
    }
};
