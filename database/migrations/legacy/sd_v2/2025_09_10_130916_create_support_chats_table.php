<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_chats', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('supportID');
            $table->integer('userID');
            $table->integer('direction')->comment('1 = From User, 2 = From Admin');
            $table->text('chat');
            $table->dateTime('created');
            $table->integer('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_chats');
    }
};
