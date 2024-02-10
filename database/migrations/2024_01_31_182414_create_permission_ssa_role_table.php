<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permission_ssa_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permission_id')->index();
            $table->foreignId('ssa_role_id')->index();
            $table->timestamps();

            $table->unique(['permission_id', 'ssa_role_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permission_ssa_role');
    }
};
