<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('maintenance')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
