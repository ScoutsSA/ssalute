<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application_adult_membership_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sd_region_id')->nullable();
            $table->foreignId('sd_district_id')->nullable();
            $table->foreignId('sd_group_id')->nullable();

            $table->string('status');

            $table->string('first_name')->nullable();
            $table->string('other_names')->nullable();
            $table->string('surname')->nullable();
            $table->string('nickname')->nullable();
            $table->string('title');
            $table->string('sex');

            $table->boolean('has_south_african_id');
            $table->string('id_number');
            $table->string('id_document');
            $table->string('criminal_record');
            $table->date('date_of_birth')->nullable();
            $table->string('passport_country')->nullable();
            $table->string('passport_date_of_issue')->nullable();
            $table->string('phone_number');
            $table->string('email');
            $table->text('residential_address')->nullable();

            $table->text('medical_conditions')->nullable();
            $table->string('medical_aid_scheme_name')->nullable();
            $table->string('medical_aid_number')->nullable();
            $table->string('medical_aid_principal_member')->nullable();

            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone_number')->nullable();
            $table->boolean('has_given_public_media_consent');

            $table->string('action_slug');

            $table->boolean('has_group_been_notified')->default(false);
            $table->boolean('has_district_been_notified')->default(false);
            $table->boolean('has_regional_been_notified')->default(false);
            $table->boolean('has_national_been_notified')->default(false);

            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable();
            $table->timestamp('declined_at')->nullable();
            $table->foreignId('declined_by')->nullable();
            $table->text('declined_notes_internal')->nullable();
            $table->text('declined_reason')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_adult_membership_requests');
    }
};
