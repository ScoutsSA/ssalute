<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_chats_standard_answers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('answer');
            $table->integer('autoClose')->default(0);
            $table->integer('active')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_chats_standard_answers');
    }
};
