<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_bad_logons', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('username');
            $table->string('password');
            $table->dateTime('date')->index('date');
            $table->string('ip');
            $table->string('userAgent', 1024)->nullable();
            $table->integer('usingMobile')->nullable();

            $table->index(['ip', 'date'], 'ip');
            $table->index(['username', 'date'], 'username');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_bad_logons');
    }
};
