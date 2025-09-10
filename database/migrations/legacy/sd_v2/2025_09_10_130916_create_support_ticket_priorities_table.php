<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_ticket_priorities', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->text('description');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_ticket_priorities');
    }
};
