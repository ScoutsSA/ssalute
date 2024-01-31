<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('sd_system_user_id')->nullable();
            $table->string('ssa_number', 32)->nullable();
            $table->foreignId('active_user_ssa_role_id')->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->timestamp('password_changed_at')->nullable();
            $table->timestamp('last_login_at')->nullable();

            $table->string('first_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('phone_number', 32)->nullable();
            $table->string('photo')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('id_number', 64)->nullable();
            $table->string('id_verified_file')->nullable();
            $table->string('sex', 6)->nullable();
            $table->string('race', 10)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('date_invested')->nullable();

            $table->text('address')->nullable();
            $table->string('language', 5)->nullable();
            $table->string('medical_aid_name')->nullable();
            $table->string('medical_aid_number', 128)->nullable();
            $table->string('medical_aid_principal_member')->nullable();
            $table->string('doctors_name')->nullable();
            $table->string('doctors_phone_number', 32)->nullable();
            $table->text('allergies')->nullable();
            $table->text('medical_conditions')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone_number', 32)->nullable();
            $table->string('emergency_contact_relationship', 64)->nullable();
            $table->text('dietary_requirements')->nullable();
            $table->string('religion')->nullable();

            $table->json('features_flags')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
