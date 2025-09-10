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
        Schema::create('system_users_forced_logouts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->dateTime('date')->index('date');
            $table->integer('userID');
            $table->text('fromURL');
            $table->text('toURL');
            $table->string('IPAddress')->nullable();
            $table->text('extended')->nullable();
            $table->text('userAgent')->nullable();

            $table->index(['userID', 'date'], 'userid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_users_forced_logouts');
    }
};
