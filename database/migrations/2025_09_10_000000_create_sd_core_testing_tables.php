<?php

/**
 * SQLite-compatible minimal schema for the sd-core tables used in tests.
 *
 * The legacy sd_v2 migrations have non-unique index names (fine in MySQL, invalid in SQLite).
 * This migration creates only the tables needed for tests, with unique index names.
 *
 * Only loaded in the test environment — this file sits in the standard migrations directory
 * and is skipped in production via the environment guard below.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! App::environment('testing')) {
            return;
        }

        Schema::create('system_user_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->text('description')->default('');
            $table->integer('sysAdmin')->default(0);
            $table->integer('nationalRole')->default(0);
            $table->integer('regionalRole')->default(0);
            $table->integer('superDistrictRole')->default(0);
            $table->integer('districtRole')->default(0);
            $table->integer('groupRole')->default(0);
            $table->integer('denRole')->default(0);
            $table->integer('packRole')->default(0);
            $table->integer('troopRole')->default(0);
            $table->integer('crewRole')->default(0);
            $table->integer('adultLeaderRole')->default(0);
            $table->integer('parentHelperRole')->default(0);
            $table->integer('alumniRole')->default(0);
            $table->integer('warrantedRole')->default(0);
            $table->integer('appointmentRole')->default(0);
            $table->integer('requiresCriminalClearance')->default(1);
            $table->integer('signsLeft')->nullable();
            $table->integer('signsRight')->nullable();
            $table->integer('chargeRole')->default(0);
            $table->integer('active')->default(1);
            $table->integer('position')->default(0);
            $table->integer('canAdminAlumni')->default(0);
            $table->integer('canSeeAlumni')->default(0);
            $table->integer('canAdminNational')->default(0);
            $table->integer('canSeeNational')->default(0);
            $table->integer('canAdminRegion')->default(0);
            $table->integer('canSeeRegion')->default(0);
            $table->integer('canAdminRegionKids')->default(0);
            $table->integer('canAdminRegionTraining')->default(0);
            $table->integer('canAdminSuperDistrict')->default(0);
            $table->integer('canSeeSuperDistrict')->default(0);
            $table->integer('canAdminDistrict')->default(0);
            $table->integer('canSeeDistrict')->default(0);
            $table->integer('canAdminDistrictKids')->default(0);
            $table->integer('canAdminGroup')->default(0);
            $table->integer('canSeeGroup')->default(0);
            $table->integer('canAdminGroupAdults')->default(0);
            $table->integer('canAwardGroupMeerkats')->default(0);
            $table->integer('canAwardGroupCubs')->default(0);
            $table->integer('canAwardGroupScouts')->default(0);
            $table->integer('canAwardGroupRovers')->default(0);
            $table->integer('canSeeSupport')->default(1);
            $table->integer('canAdminSupport')->default(0);
            $table->integer('canAddWarrants')->default(0);
            $table->integer('canAdminProperty')->default(0);
            $table->integer('canSignWarrants')->default(0);
            $table->integer('canAdminForm29')->default(0);
            $table->integer('canAdminPoliceClearance')->default(0);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(1);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('system_users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('username', 128)->nullable()->unique();
            $table->binary('passwordNew')->nullable();
            $table->string('title', 16)->nullable();
            $table->string('first_name', 128)->nullable();
            $table->string('otherName', 128)->nullable();
            $table->string('surname', 64)->nullable();
            $table->string('knownName', 128)->nullable();
            $table->string('scoutName', 128)->nullable();
            $table->string('sex', 6)->nullable();
            $table->string('race')->nullable();
            $table->date('dob')->nullable();
            $table->date('dateInvested')->nullable();
            $table->string('idNumber', 64)->nullable();
            $table->string('passportNumber', 64)->nullable();
            $table->integer('active')->default(1);
            $table->integer('assoc_to_account')->default(1);
            $table->integer('assoc_to_group')->nullable();
            $table->integer('assoc_to_district')->nullable();
            $table->integer('assoc_to_region')->nullable();
            $table->string('cellNr', 32)->nullable();
            $table->string('officeNr', 32)->nullable();
            $table->string('homeNr', 32)->nullable();
            $table->text('phys_address')->nullable();
            $table->text('postal_address')->nullable();
            $table->integer('canLogon')->default(1);
            $table->integer('mustChangePassword')->nullable();
            $table->string('emergencyContactName', 128)->nullable();
            $table->string('emergencyContactCell', 128)->nullable();
            $table->string('emergencyContactTel', 32)->nullable();
            $table->string('emergencyContactRelationship', 64)->nullable();
            $table->string('occupation', 128)->nullable();
            $table->string('typeOfEmployment', 128)->nullable();
            $table->string('employer', 128)->nullable();
            $table->string('religiousBelief', 128)->nullable();
            $table->text('hobbies')->nullable();
            $table->text('sports')->nullable();
            $table->text('interests')->nullable();
            $table->string('medicalAidName', 128)->nullable();
            $table->string('medicalAidNr', 64)->nullable();
            $table->string('medicalAidPrincipalMember', 128)->nullable();
            $table->string('doctorsName', 128)->nullable();
            $table->string('doctorsPhone', 32)->nullable();
            $table->text('allergies')->nullable();
            $table->text('allergiesInstructions')->nullable();
            $table->text('disabilities')->nullable();
            $table->text('disabilitiesInstructions')->nullable();
            $table->text('medicalConditions')->nullable();
            $table->text('medicalConditionsInstructions')->nullable();
            $table->text('currentMedication')->nullable();
            $table->text('specialMealRequirements')->nullable();
            $table->integer('infoRedacted')->default(0);
            $table->dateTime('created');
            $table->integer('createdby')->default(1);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('regions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->integer('regionID')->default(0);
        });

        Schema::create('groups', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->integer('districtID')->default(0);
        });

        Schema::create('system_users_other_roles', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('countryID')->default(196);
            $table->integer('regionID')->default(0);
            $table->integer('superDistrictID')->nullable();
            $table->integer('districtID')->default(0);
            $table->integer('groupID')->default(0);
            $table->integer('roleID')->default(0);
            $table->integer('defaultRole')->default(0);
            $table->integer('active');
            $table->text('creationNotes')->nullable();
            $table->integer('actionCountryID')->default(0);
            $table->integer('actionRegionID')->default(0);
            $table->integer('actionSuperDistrictID')->default(0);
            $table->integer('actionDistrictID')->default(0);
            $table->integer('actionGroupID')->default(0);
            $table->integer('retired')->default(0);
            $table->integer('resigned')->default(0);
            $table->integer('suspended')->default(0);
            $table->integer('multiID')->default(0);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_warrant_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->string('shortName')->default('');
            $table->integer('countryID')->default(196);
            $table->integer('position')->default(0);
            $table->text('description')->default('');
        });

        Schema::create('ams_warrant_info', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(0);
            $table->integer('assocToDistrict')->default(0);
            $table->integer('assocToGroup')->default(0);
            $table->integer('userID');
            $table->integer('roleID')->nullable();
            $table->integer('warrantTypeID')->nullable();
            $table->string('warrantNr')->default('');
            $table->string('warrantName')->nullable();
            $table->integer('limited')->default(0);
            $table->integer('appointment')->default(0);
            $table->string('PDFLocation', 1024)->nullable();
            $table->date('issueDate');
            $table->date('expireDate');
            $table->integer('cancellationTypeID')->nullable();
            $table->text('cancelationNotes')->nullable();
            $table->integer('expireEmailCount')->default(0);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_document_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->text('description')->default('');
            $table->integer('aamForm')->default(0);
            $table->integer('active')->default(1);
        });

        Schema::create('ams_documents', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('userID');
            $table->integer('assocToRegion')->default(0);
            $table->integer('assocToGroup')->default(0);
            $table->integer('assocToDistrict')->default(0);
            $table->integer('documentTypeID');
            $table->string('description')->default('');
            $table->string('PDFLocation', 1024)->default('');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_training_past_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->string('shortName')->default('');
            $table->integer('code')->nullable();
            $table->text('description')->default('');
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(1);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_training_past', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup')->nullable();
            $table->integer('userID');
            $table->integer('trainingTypeID')->nullable();
            $table->text('courseName')->nullable();
            $table->string('courseNumber')->default('');
            $table->date('completionDate');
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('validated')->default(0);
            $table->dateTime('validatedDate')->nullable();
            $table->integer('validatedby')->nullable();
        });

        Schema::create('ams_award_headings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('reason');
        });

        Schema::create('ams_award_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('headingID');
            $table->integer('position')->default(0);
            $table->string('name');
            $table->string('shortName')->default('');
            $table->text('description')->default('');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_award_info', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(0);
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup')->nullable();
            $table->integer('userID');
            $table->integer('awardHeadingID');
            $table->integer('awardTypeID');
            $table->date('awardDate');
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_police_clearance', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->text('result');
            $table->string('documentLocation', 1024)->nullable();
            $table->date('dateDone');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_past_service_type', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('position')->default(0);
            $table->string('name');
            $table->integer('newID')->nullable();
        });

        Schema::create('ams_past_service_info', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup')->nullable();
            $table->integer('userID');
            $table->integer('pastServiceType')->nullable();
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();
            $table->string('otherRegionName')->nullable();
            $table->string('otherDistrictName')->nullable();
            $table->string('otherGroupName')->nullable();
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('toBeFixed')->default(0);
        });
    }

    public function down(): void
    {
        if (! App::environment('testing')) {
            return;
        }

        Schema::dropIfExists('ams_past_service_info');
        Schema::dropIfExists('ams_past_service_type');
        Schema::dropIfExists('ams_police_clearance');
        Schema::dropIfExists('ams_award_info');
        Schema::dropIfExists('ams_award_types');
        Schema::dropIfExists('ams_award_headings');
        Schema::dropIfExists('ams_training_past');
        Schema::dropIfExists('ams_training_past_types');
        Schema::dropIfExists('ams_documents');
        Schema::dropIfExists('ams_document_types');
        Schema::dropIfExists('ams_warrant_info');
        Schema::dropIfExists('ams_warrant_types');
        Schema::dropIfExists('system_users_other_roles');
        Schema::dropIfExists('system_users');
        Schema::dropIfExists('system_user_types');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('regions');
    }
};
