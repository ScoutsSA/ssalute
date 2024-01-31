<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_user_requests', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('other_names')->nullable();
            $table->string('surname')->nullable();
            $table->string('nickname')->nullable();
            $table->string('title');
            $table->string('sex');
            $table->string('id_number');
            $table->date('date_of_birth')->nullable();
            $table->string('passport_country')->nullable();
            $table->string('passport_date_of_issue')->nullable();
            $table->string('phone_number');
            $table->string('email');
            $table->text('residential_address')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone_number')->nullable();
            $table->string('id_document_file')->nullable();
            $table->boolean('has_given_public_media_consent');
            $table->unsignedInteger('requested_system_user_type_id')->nullable();
            $table->unsignedInteger('region_id')->nullable();
            $table->unsignedInteger('district_id')->nullable();
            $table->unsignedInteger('group_id')->nullable();

            $table->boolean('has_group_been_notified')->nullable();
            $table->boolean('has_district_been_notified')->nullable();
            $table->boolean('has_regional_been_notified')->nullable();
            $table->boolean('has_national_been_notified')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_user_requests');
    }
};
