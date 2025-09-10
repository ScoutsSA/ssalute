<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_faq', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('catID');
            $table->integer('targetID')->default(0);
            $table->string('q');
            $table->text('a');
            $table->integer('active')->default(1);
            $table->integer('position')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_faq');
    }
};
