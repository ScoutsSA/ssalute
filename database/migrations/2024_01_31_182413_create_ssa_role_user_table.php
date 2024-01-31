<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ssa_role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ssa_role_id');
            $table->foreignId('user_id');
            $table->string('related_type')->nullable();
            $table->foreignId('related_id')->nullable();
            $table->foreignId('warrant_id')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ssa_role_user');
    }
};
