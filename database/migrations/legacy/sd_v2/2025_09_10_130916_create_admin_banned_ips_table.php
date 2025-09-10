<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_banned_ips', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('ip')->index('ip');
            $table->dateTime('date')->useCurrent();
            $table->string('page')->nullable();

            $table->unique(['ip'], 'ip_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_banned_ips');
    }
};
