<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ssa_role_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ssa_role_id');
            $table->foreignId('permission_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ssa_role_permission');
    }
};
