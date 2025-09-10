<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_advancement_scouts_second_entsha_badges', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('taskID');
            $table->integer('badgeID')->index('badgeid');
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(1);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_advancement_scouts_second_entsha_badges');
    }
};
