<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_users_email_verifications', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->index('userid');
            $table->string('emailAddress', 150);
            $table->integer('emailFailedVerification')->default(0);
            $table->dateTime('dateVerified')->nullable();
            $table->text('response')->nullable();
            $table->string('responseHeading', 25)->nullable();
            $table->dateTime('sentConfirmationEmail')->nullable();
            $table->text('subjectReceivedBack')->nullable();
            $table->text('messageReceivedBack')->nullable();
            $table->dateTime('messageReceivedBackDate')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_users_email_verifications');
    }
};
