<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jamboree_sub_camps', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->string('name');
            $table->integer('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jamboree_sub_camps');
    }
};
