<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_contact_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_user_id')->index();
            $table->unsignedBigInteger('sender_role_attachment_id')->nullable();
            $table->unsignedBigInteger('recipient_user_id')->index();
            $table->unsignedBigInteger('recipient_role_attachment_id')->nullable();
            $table->string('directory_level', 20);
            $table->string('subject', 150);
            $table->text('message');
            $table->timestamp('sent_at')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_contact_messages');
    }
};
