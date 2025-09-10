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
        Schema::create('telegram_ban_count', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->nullable();
            $table->string('chatID');
            $table->integer('count');
            $table->dateTime('firstAdded')->useCurrent();
            $table->text('why')->nullable();

            $table->index(['userID', 'chatID'], 'userid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_ban_count');
    }
};
