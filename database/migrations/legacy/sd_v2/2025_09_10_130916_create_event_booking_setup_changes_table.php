<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_booking_setup_changes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('gpsLat')->nullable();
            $table->string('gpsLon')->nullable();
            $table->integer('costPerPerson');
            $table->integer('depositAmount');
            $table->date('depositRequiredDate')->nullable();
            $table->integer('MaxBookings');
            $table->date('lastBookingDate');
            $table->string('emailAddress');
            $table->string('bankName');
            $table->string('bankAccountHoldersName');
            $table->string('banlBranchName');
            $table->string('bankBranchCode');
            $table->string('bankAccountNumber');
            $table->string('paymentRederence');
            $table->date('paymentInFullByDate')->nullable();
            $table->integer('startAge')->nullable();
            $table->integer('endAge')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_booking_setup_changes');
    }
};
