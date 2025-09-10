<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_users_form29', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->string('PDFLocation', 1024);
            $table->date('sentToDSD')->nullable();
            $table->string('DSDResponse')->nullable();
            $table->text('DSDResponseNotes')->nullable();
            $table->dateTime('DSDResponseDate')->nullable();
            $table->integer('DSDResponseBy')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['userID', 'active'], 'userid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_users_form29');
    }
};
