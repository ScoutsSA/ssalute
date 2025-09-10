<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services_purchased_spreadsheets_sent', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('groupID');
            $table->dateTime('dateSent');
            $table->integer('sentBy');
            $table->integer('active');

            $table->index(['groupID', 'active'], 'groupid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_purchased_spreadsheets_sent');
    }
};
