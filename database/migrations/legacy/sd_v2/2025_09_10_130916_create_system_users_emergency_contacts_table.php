<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_users_emergency_contacts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->string('contact1Title', 10)->nullable();
            $table->string('contact1FirstName');
            $table->string('contact1Surname');
            $table->string('contact1Cell', 25);
            $table->string('contact1Home', 25)->nullable();
            $table->string('contact1Work', 25)->nullable();
            $table->integer('contact1Relationship')->nullable();
            $table->string('contact2Title', 10)->nullable();
            $table->string('contact2FirstName');
            $table->string('contact12urname');
            $table->string('contact2Cell', 25);
            $table->string('contact2Home', 25)->nullable();
            $table->string('contact2Work', 25)->nullable();
            $table->integer('contact2Relationship')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_users_emergency_contacts');
    }
};
