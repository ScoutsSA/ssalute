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
        Schema::create('telegram_currently_chatting', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('systemUserID');
            $table->integer('chattingToUserID');
            $table->integer('active');
            $table->dateTime('created');

            $table->index(['chattingToUserID', 'active'], 'chattingtouserid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_currently_chatting');
    }
};
