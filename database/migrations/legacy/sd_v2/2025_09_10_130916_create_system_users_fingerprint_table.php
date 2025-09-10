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
        Schema::create('system_users_fingerprint', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->nullable();
            $table->text('agent')->nullable();
            $table->string('ipAddress', 25)->nullable();
            $table->dateTime('created');

            $table->index(['userID', 'agent', 'ipAddress'], 'userid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_users_fingerprint');
    }
};
