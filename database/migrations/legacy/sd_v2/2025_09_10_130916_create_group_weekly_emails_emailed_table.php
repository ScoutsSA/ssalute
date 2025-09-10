<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_weekly_emails_emailed', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup');
            $table->integer('accountID');
            $table->integer('userID');
            $table->integer('programID');
            $table->date('programDate');
            $table->dateTime('sentDate');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->string('mailType', 25);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_weekly_emails_emailed');
    }
};
