<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_404_pages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->nullable();
            $table->text('refURL')->nullable();
            $table->text('actualURL')->nullable();
            $table->dateTime('created');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_404_pages');
    }
};
