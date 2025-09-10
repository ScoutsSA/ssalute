<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services_purchased_spreadsheets_received', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('groupID');
            $table->dateTime('receivedDate');
            $table->string('location', 1024);
            $table->integer('addedBy');
            $table->integer('active');

            $table->index(['groupID', 'active'], 'groupid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services_purchased_spreadsheets_received');
    }
};
