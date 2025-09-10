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
        Schema::create('telegram_messages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->nullable()->default(0);
            $table->string('telegramUserID')->nullable()->index('telegramuserid');
            $table->string('telegramFirstName')->nullable();
            $table->string('telegramSurname')->nullable();
            $table->string('telegramUsername')->nullable();
            $table->text('message');
            $table->string('direction', 12)->comment('\'To SD\' or \'From SD\'');
            $table->integer('sentByID')->default(0);
            $table->dateTime('date')->useCurrent();
            $table->dateTime('markedRead')->nullable();
            $table->integer('markedReadBy')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();

            $table->index(['userID', 'active', 'markedRead'], 'userid');
            $table->index(['userID', 'date', 'direction'], 'userid_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_messages');
    }
};
