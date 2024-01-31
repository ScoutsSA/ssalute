<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ssa_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sd_system_user_type_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('requires_warrant')->default(0);
            $table->integer('requires_ial')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ssa_roles');
    }
};
