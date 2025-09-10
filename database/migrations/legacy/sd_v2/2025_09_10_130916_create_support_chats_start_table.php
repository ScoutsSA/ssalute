<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_chats_start', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('countryID');
            $table->integer('regionID')->default(0);
            $table->integer('area');
            $table->text('topic');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('closed')->nullable();
            $table->dateTime('closedDate')->nullable();
            $table->integer('closedBy')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_chats_start');
    }
};
