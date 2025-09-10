<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_users_passwords_emailed', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('username', 1024);
            $table->dateTime('date');
            $table->string('emailed', 3);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_users_passwords_emailed');
    }
};
