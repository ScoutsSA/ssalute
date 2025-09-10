<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('info_sharing_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->integer('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('info_sharing_types');
    }
};
