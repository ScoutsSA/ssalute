<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_user_booking_invoices', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('userID');
            $table->string('description', 1024);
            $table->integer('amount');
            $table->integer('transport')->default(0);
            $table->integer('accomodation')->default(0);
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_user_booking_invoices');
    }
};
