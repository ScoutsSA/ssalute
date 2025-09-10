<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('telegram_sent_human_message', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->date('date');
            $table->text('message');

            $table->index(['userID', 'date'], 'userid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telegram_sent_human_message');
    }
};
