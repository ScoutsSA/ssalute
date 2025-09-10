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
        Schema::create('telegram_usernames', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->nullable();
            $table->string('username')->nullable()->index('username');
            $table->string('chatID')->nullable()->index('chatid');
            $table->integer('active')->default(1);
            $table->integer('banned')->default(0);
            $table->dateTime('bannedDate')->nullable();
            $table->dateTime('created')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_usernames');
    }
};
