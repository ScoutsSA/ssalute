<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public static function up()
    {
        Schema::create('admin_404_pages', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->nullable();
            $table->text('refURL')->nullable();
            $table->text('actualURL')->nullable();
            $table->dateTime('created');
        });

        Schema::create('admin_bad_logons', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('username');
            $table->string('password');
            $table->dateTime('date')->index('date');
            $table->string('ip');
            $table->string('userAgent', 1024)->nullable();
            $table->integer('usingMobile')->nullable();

            $table->index(['ip', 'date'], 'ip');
            $table->index(['username', 'date'], 'username');
        });

        Schema::create('admin_banned_ips', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('ip')->index('ip');
            $table->dateTime('date')->useCurrent();
            $table->string('page')->nullable();

            $table->unique(['ip'], 'ip_2');
        });

        Schema::create('admin_good_logons', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('username');
            $table->string('password')->nullable();
            $table->dateTime('date');
            $table->string('ip');
            $table->integer('roleID')->nullable();
            $table->integer('fromSD')->default(1);
            $table->integer('groupID')->nullable();
            $table->integer('districtID')->nullable();
            $table->integer('regionID')->nullable();
            $table->integer('countryID')->nullable();
            $table->string('userAgent', 1024)->nullable();
            $table->integer('usingMobile')->nullable();

            $table->index(['regionID', 'date'], 'regionID');
            $table->index(['groupID', 'date'], 'groupID');
            $table->index(['districtID', 'date'], 'districtID');
        });

        Schema::create('advancement_cubs', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(0);
            $table->integer('assocToDistrict')->default(0);
            $table->integer('assocToGroup');
            $table->integer('cubID');
            $table->integer('userID')->default(0);
            $table->integer('themeID')->default(0);
            $table->integer('advancementID')->index('advancementID');
            $table->integer('advancementSecondID')->nullable();
            $table->integer('advancementThirdID')->nullable();
            $table->text('notes')->nullable();
            $table->string('PDFLocation')->nullable();
            $table->date('advancementDate')->nullable();
            $table->integer('latest')->default(0)->comment('1 = latest');
            $table->integer('active')->default(0)->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['cubID', 'advancementID', 'advancementSecondID', 'advancementThirdID', 'active', 'programType', 'themeID'], 'cubID_4');
            $table->index(['assocToRegion', 'advancementID', 'active', 'latest'], 'assocToRegion');
            $table->index(['assocToGroup', 'cubID', 'active', 'advancementID', 'advancementSecondID', 'advancementThirdID'], 'assocToGroup');
            $table->index(['assocToDistrict', 'advancementID', 'active', 'latest'], 'assocToDistrict');
            $table->index(['cubID', 'advancementID', 'advancementSecondID', 'advancementThirdID', 'themeID', 'active'], 'cubID_8');
            $table->index(['cubID', 'advancementID', 'advancementSecondID', 'advancementThirdID', 'latest', 'active'], 'cubID');
            $table->index(['cubID', 'advancementSecondID', 'advancementThirdID', 'active'], 'cubID_2');
            $table->index(['cubID', 'advancementID', 'advancementThirdID', 'active', 'programType'], 'cubID_7');
            $table->index(['cubID', 'active'], 'cubID_5');
            $table->index(['countryID', 'advancementID', 'active', 'latest'], 'countryID');
            $table->index(['assocToGroup', 'advancementID', 'advancementSecondID', 'advancementThirdID', 'active', 'advancementDate'], 'assocToGroup_4');
            $table->index(['assocToGroup', 'advancementID', 'advancementSecondID', 'advancementThirdID', 'active', 'latest'], 'assocToGroup_3');
            $table->index(['assocToGroup', 'advancementID', 'active', 'latest'], 'assocToGroup_2');
            $table->index(['assocToDistrict', 'advancementID', 'advancementSecondID', 'advancementThirdID', 'active', 'advancementDate'], 'assocToDistrict_2');
            $table->index(['countryID', 'advancementID', 'advancementSecondID', 'advancementThirdID', 'active', 'advancementDate'], 'countryID_2');
            $table->index(['assocToRegion', 'advancementID', 'advancementSecondID', 'advancementThirdID', 'active', 'advancementDate'], 'assocToRegion_2');
            $table->index(['cubID', 'advancementID', 'active'], 'cubID_6');
            $table->index(['assocToGroup', 'active', 'advancementDate'], 'assocToGroup_5');
            $table->index(['userID', 'PDFLocation'], 'userID');
        });

        Schema::create('advancement_documents', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('type')->default(17);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup');
            $table->integer('userID')->index('userID');
            $table->text('description');
            $table->string('PDFLocation', 1024);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('advancementFirstID')->index('advancementFirstID');
            $table->integer('advancementSecondID')->index('advancementSecondID');
            $table->integer('advancementThirdID')->nullable()->index('advancementThirdID');
            $table->integer('active')->default(1);

            $table->index(['assocToGroup', 'userID', 'advancementFirstID', 'advancementSecondID', 'active'], 'assocToGroup');
        });

        Schema::create('advancement_meerkats', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(0);
            $table->integer('assocToDistrict')->default(0);
            $table->integer('assocToGroup');
            $table->integer('meerkatID')->nullable();
            $table->integer('userID')->nullable();
            $table->integer('themeID')->default(0);
            $table->integer('advancementID')->index('advancementID');
            $table->integer('advancementSecondID')->nullable();
            $table->integer('advancementThirdID')->nullable();
            $table->text('notes')->nullable();
            $table->string('PDFLocation')->nullable();
            $table->date('advancementDate')->nullable();
            $table->integer('latest')->default(0)->comment('1 = latest');
            $table->integer('active')->default(0)->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['advancementSecondID', 'advancementThirdID', 'active'], 'cubID_2');
            $table->index(['advancementID', 'advancementSecondID', 'advancementThirdID', 'latest', 'active'], 'cubID');
            $table->index(['assocToGroup', 'active', 'advancementDate'], 'assocToGroup_3');
            $table->index(['userID', 'PDFLocation'], 'userID_4');
            $table->index(['assocToGroup', 'active', 'advancementID', 'advancementSecondID', 'advancementThirdID'], 'assocToGroup');
            $table->index(['assocToDistrict', 'advancementID', 'active', 'latest'], 'assocToDistrict');
            $table->index(['assocToRegion', 'advancementID', 'active', 'latest'], 'assocToRegion');
            $table->index(['countryID', 'advancementID', 'active', 'latest'], 'countryID');
            $table->index(['userID', 'advancementID', 'advancementSecondID', 'advancementThirdID', 'active', 'programType', 'themeID'], 'userID_2');
            $table->index(['userID', 'active', 'latest'], 'userID');
            $table->index(['assocToGroup', 'advancementID', 'active', 'latest'], 'assocToGroup_2');
            $table->index(['userID', 'active'], 'userID_3');
        });

        Schema::create('advancement_notes', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('type')->nullable()->default(0);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup');
            $table->integer('userID')->index('userID');
            $table->text('note');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('advancementFirstID')->index('advancementFirstID');
            $table->integer('advancementSecondID')->index('advancementSecondID');
            $table->integer('advancementThirdID')->nullable()->index('advancementThirdID');
            $table->integer('active')->default(1);

            $table->index(['type', 'active'], 'type');
            $table->index(['assocToGroup', 'userID', 'advancementFirstID', 'advancementSecondID', 'advancementThirdID', 'active'], 'assocToGroup');
            $table->index(['assocToGroup', 'userID', 'advancementFirstID', 'advancementSecondID', 'active'], 'assocToGroup_2');
        });

        Schema::create('advancement_photos', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('type')->default(17);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup');
            $table->integer('userID')->index('userID');
            $table->text('description');
            $table->string('PDFLocation', 1024);
            $table->string('thumbLocation', 1024);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('advancementFirstID')->index('advancementFirstID');
            $table->integer('advancementSecondID')->index('advancementSecondID');
            $table->integer('advancementThirdID')->nullable()->index('advancementThirdID');
            $table->integer('active')->default(1);

            $table->index(['type', 'userID', 'active'], 'type');
            $table->index(['assocToGroup', 'userID', 'advancementFirstID', 'advancementSecondID', 'active'], 'assocToGroup');
        });

        Schema::create('advancement_rovers', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(0);
            $table->integer('assocToDistrict')->default(0);
            $table->integer('assocToGroup');
            $table->integer('roverID')->index('roverID');
            $table->integer('userID')->default(0);
            $table->integer('themeID')->default(0);
            $table->integer('advancementID')->index('advancementID');
            $table->integer('advancement2ID')->nullable();
            $table->date('advancementDate');
            $table->text('notes')->nullable();
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('latest')->default(0)->comment('1 = Active');
            $table->integer('active')->comment('1 = Latest');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToRegion', 'advancementID', 'active', 'latest'], 'assocToRegion');
            $table->index(['assocToGroup', 'advancementID', 'active', 'latest'], 'assocToGroup');
            $table->index(['assocToDistrict', 'advancementID', 'active', 'latest'], 'assocToDistrict');
            $table->index(['countryID', 'advancementID', 'active', 'latest'], 'countryID');
            $table->index(['roverID', 'active'], 'roverID_4');
            $table->index(['userID', 'PDFLocation'], 'userID');
            $table->index(['roverID', 'advancementID', 'advancement2ID', 'active', 'programType'], 'roverID_3');
            $table->index(['roverID', 'advancementID', 'advancement2ID', 'latest', 'active'], 'roverID_2');
            $table->index(['assocToGroup', 'active', 'advancementDate'], 'assocToGroup_2');
        });

        Schema::create('advancement_scouters', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('assocToGroup')->index('assocToGroup');
            $table->integer('scouterID')->index('scoutID');
            $table->integer('advancementID')->index('advancementID');
            $table->date('advancementDate');
            $table->text('notes')->nullable();
            $table->integer('latest')->comment('1 = latest');
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('advancement_scouts', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(0);
            $table->integer('assocToDistrict')->default(0);
            $table->integer('assocToGroup');
            $table->integer('scoutProgramTypeID')->default(1);
            $table->integer('scoutID');
            $table->integer('userID')->nullable()->default(0);
            $table->integer('themeID')->default(0);
            $table->integer('advancementID')->index('advancementID');
            $table->integer('advancement2ID')->nullable();
            $table->date('advancementDate');
            $table->text('notes')->nullable();
            $table->string('PDFLocation')->nullable();
            $table->integer('latest')->default(0)->comment('1 = latest');
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->dateTime('approvedDate')->nullable();
            $table->integer('approvedBy')->nullable();

            $table->index(['countryID', 'advancementID', 'advancement2ID', 'active'], 'countryID');
            $table->index(['assocToGroup', 'advancementID', 'advancement2ID', 'themeID', 'active', 'advancementDate'], 'assocToGroup_2');
            $table->index(['scoutID', 'advancementID', 'active'], 'scoutID_7');
            $table->index(['createdby', 'programType', 'approvedBy', 'active'], 'createdby');
            $table->index(['assocToDistrict', 'advancementID', 'advancement2ID', 'themeID', 'active', 'advancementDate'], 'assocToDistrict_2');
            $table->index(['countryID', 'advancementID', 'advancement2ID', 'themeID', 'active', 'advancementDate'], 'countryID_3');
            $table->index(['scoutProgramTypeID', 'scoutID', 'advancementID', 'advancement2ID', 'latest', 'active'], 'scoutProgramTypeID');
            $table->index(['assocToRegion', 'advancementID', 'advancement2ID', 'themeID', 'active', 'advancementDate'], 'assocToRegion_2');
            $table->index(['scoutID', 'advancementID', 'advancement2ID', 'active', 'programType', 'themeID'], 'scoutID_6');
            $table->index(['programType', 'scoutID', 'advancementID', 'advancement2ID'], 'programType');
            $table->index(['scoutID', 'advancementID', 'advancement2ID', 'latest', 'active'], 'scoutID_2');
            $table->index(['assocToGroup', 'advancementID', 'active', 'latest'], 'assocToGroup');
            $table->index(['userID', 'PDFLocation'], 'userID');
            $table->index(['assocToRegion', 'advancementID', 'active', 'latest'], 'assocToRegion');
            $table->index(['scoutID', 'advancementID', 'advancement2ID', 'active'], 'scoutID_4');
            $table->index(['scoutID', 'advancementID', 'themeID', 'active', 'advancement2ID'], 'scoutID_5');
            $table->index(['assocToDistrict', 'advancementID', 'active', 'latest'], 'assocToDistrict');
            $table->index(['countryID', 'advancementID', 'active', 'latest'], 'countryID_2');
            $table->index(['scoutID', 'active'], 'scoutID');
            $table->index(['createdby', 'approvedBy', 'active'], 'createdby_2');
            $table->index(['programType', 'scoutID', 'advancement2ID', 'active'], 'programType_2');
            $table->index(['assocToGroup', 'active', 'advancementDate'], 'assocToGroup_3');
            $table->index(['scoutID', 'assocToGroup', 'advancementID', 'advancement2ID', 'active'], 'scoutID_3');
        });

        Schema::create('ams_adult_leader_moves', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->index('assocToRegion');
            $table->integer('userID')->index('userID');
            $table->integer('fromPosition');
            $table->integer('ToPosition');
            $table->integer('fromGroup');
            $table->integer('toGroup');
            $table->integer('fromDistrict');
            $table->integer('toDistrict');
            $table->date('effectiveDate');
            $table->dateTime('created');
            $table->integer('createdby');
        });

        Schema::create('ams_award_applications', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->index('assocToRegion');
            $table->integer('userID')->index('userID');
            $table->integer('awardHeadingID');
            $table->integer('awardTypeID');
            $table->string('PDFLocation', 1024);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->dateTime('awardDate')->nullable();
            $table->integer('awardedBy')->nullable();
            $table->dateTime('declinedDate')->nullable();
            $table->integer('declinedBy')->nullable();
            $table->string('awardType')->nullable();
            $table->text('awardDescription')->nullable();
        });

        Schema::create('ams_award_headings', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('reason');
        });

        Schema::create('ams_award_info', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->index('assocToRegion');
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup')->nullable();
            $table->integer('userID')->index('userID');
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

        Schema::create('ams_award_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('headingID')->index('headingID');
            $table->integer('position');
            $table->string('name');
            $table->string('shortName');
            $table->text('description');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_charge_info', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->index('assocToRegion');
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup')->nullable();
            $table->integer('userID')->index('userID');
            $table->integer('chargeTypeID');
            $table->string('chargeNr', 225);
            $table->string('PDFLocation', 1024)->nullable();
            $table->date('issueDate');
            $table->date('expireDate');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_charge_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->string('name');
            $table->integer('forScouts')->default(0);
            $table->string('shortName');
            $table->text('description');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['countryID', 'active'], 'countryID');
        });

        Schema::create('ams_criminal_check', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->index('assocToRegion');
            $table->integer('userID')->index('userID');
            $table->string('criminalType');
            $table->string('PDFLocation', 1024);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_disciplinary_headings', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('reason');
        });

        Schema::create('ams_disciplinary_info', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->index('assocToRegion');
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup')->nullable();
            $table->integer('userID')->index('userID');
            $table->integer('disciplinaryHeadingID');
            $table->integer('disciplinaryType');
            $table->string('sanction');
            $table->date('expireDate')->nullable();
            $table->string('PDFLocation', 1024);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_disciplinary_offences', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('headingID');
            $table->text('offense');
            $table->integer('active')->default(1);
        });

        Schema::create('ams_document_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->text('description');
            $table->integer('aamForm')->nullable();
            $table->integer('active')->default(1);
        });

        Schema::create('ams_document_types_groups', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->text('description');
        });

        Schema::create('ams_documents', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('userID');
            $table->integer('assocToRegion')->index('assocToRegion');
            $table->integer('assocToGroup')->index('assocToGroup');
            $table->integer('assocToDistrict')->index('assocToDistrict');
            $table->integer('documentTypeID')->index('documentTypeID');
            $table->string('description');
            $table->string('PDFLocation', 1024);
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['userID', 'active'], 'userID');
            $table->index(['userID', 'documentTypeID', 'active'], 'userID_2');
        });

        Schema::create('ams_documents_groups', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->index('assocToRegion');
            $table->integer('assocToGroup')->index('assocToGroup');
            $table->integer('assocToDistrict')->index('assocToDistrict');
            $table->integer('documentTypeID');
            $table->string('description', 1024);
            $table->string('PDFLocation', 1024);
            $table->date('validUntilDate');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_highest_education', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
        });

        Schema::create('ams_languages', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('language');
        });

        Schema::create('ams_marital_status', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100);
        });

        Schema::create('ams_past_service_info', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->index('assocToRegion');
            $table->integer('assocToDistrict');
            $table->integer('userID')->index('userID');
            $table->integer('pastServiceType');
            $table->integer('assocToGroup');
            $table->date('startDate');
            $table->date('endDate');
            $table->string('otherRegionName')->nullable();
            $table->string('otherDistrictName')->nullable();
            $table->string('otherGroupName')->nullable();
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('toBeFixed')->default(1);
        });

        Schema::create('ams_past_service_type', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->string('name');
            $table->integer('newID')->default(0);
        });

        Schema::create('ams_police_clearance', static function (Blueprint $table) {
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

            $table->index(['userID', 'active'], 'userID');
        });

        Schema::create('ams_resign_leader', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup')->nullable();
            $table->integer('userID')->index('userID');
            $table->date('resignDate');
            $table->integer('resignReasonID');
            $table->string('PDFLocation', 1024)->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_resign_reasons', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('reason', 1024);
        });

        Schema::create('ams_retire_leader', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup')->nullable();
            $table->integer('userID')->index('userID');
            $table->date('retiredDate');
            $table->integer('retiredReasonID');
            $table->string('PDFLocation', 1024)->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_retire_reasons', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('reason');
        });

        Schema::create('ams_suspend_leader', static function (Blueprint $table) {
            $table->integer('id', true)->unique('id');
            $table->integer('countryID');
            $table->integer('assocToRegion')->nullable()->default(0);
            $table->integer('assocToDistrict')->nullable()->default(0);
            $table->integer('assocToGroup')->nullable()->default(0);
            $table->integer('userID');
            $table->date('suspendDate')->nullable();
            $table->integer('suspenReasonID')->nullable();
            $table->dateTime('unsuspendDate')->nullable();
            $table->integer('unsuspendedby')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_suspend_reasons', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('reason', 1024);
        });

        Schema::create('ams_terminate_leader', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup')->nullable();
            $table->integer('userID')->index('userID');
            $table->date('terminateDate');
            $table->integer('terminateReasonID');
            $table->string('PDFLocation', 1024)->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_terminate_reasons', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('reason');
        });

        Schema::create('ams_training_courses', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('courseType')->nullable();
            $table->integer('assocToRegion')->index('assocToRegion');
            $table->string('name');
            $table->string('agendaPDFLocation', 1024)->nullable();
            $table->string('materialPDFLocation', 1024)->nullable();
            $table->integer('nrOfDays');
            $table->integer('trainingSeats')->nullable();
            $table->integer('maxBookings')->nullable();
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_training_courses_annual', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('forAdultLeadersAndRovers')->default(1);
            $table->integer('forParents')->default(0);
            $table->integer('forScouts')->default(0);
            $table->integer('assocToRegion');
            $table->string('courseID')->index('courseID');
            $table->string('courseNumber');
            $table->integer('directorID');
            $table->string('name');
            $table->text('description');
            $table->integer('locationID');
            $table->integer('courseCost')->default(0);
            $table->date('bookingCutOffDate');
            $table->date('startDate');
            $table->date('endDate');
            $table->string('previousQuali')->nullable();
            $table->integer('maxBookings')->nullable();
            $table->integer('warrantCourse')->nullable();
            $table->string('ical', 1024)->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToRegion', 'active', 'bookingCutOffDate'], 'assocToRegion');
            $table->index(['countryID', 'assocToRegion', 'startDate', 'active'], 'countryID');
            $table->index(['countryID', 'assocToRegion', 'endDate', 'active'], 'countryID_2');
            $table->index(['locationID', 'startDate', 'active'], 'locationID');
        });

        Schema::create('ams_training_courses_annual_attendance', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->index('assocToRegion');
            $table->integer('annualCourseID');
            $table->integer('dayID');
            $table->date('dayDate');
            $table->integer('userID')->index('userID');
            $table->integer('attendance');
            $table->integer('active')->index('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['annualCourseID', 'userID', 'active', 'dayID'], 'annualCourseID');
            $table->index(['annualCourseID', 'userID', 'active', 'attendance'], 'annualCourseID_2');
        });

        Schema::create('ams_training_courses_annual_bookings', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('status')->index('status')->comment('1 = Provisional, 2 = Confirmed, 3 = Guaranteed, 4 = Cancelled');
            $table->integer('assocToRegion')->index('assocToRegion');
            $table->string('bookingLocation', 100)->default('AMS');
            $table->integer('annualCourseID');
            $table->integer('userID');
            $table->text('instructions')->nullable();
            $table->text('previousCourses')->nullable();
            $table->string('invoiceLocation', 1024)->nullable();
            $table->string('POPLocation', 1024)->nullable();
            $table->integer('bugMailCount')->nullable()->default(0);
            $table->integer('active')->default(1);
            $table->integer('completionConfirmed')->default(0);
            $table->string('userPIN')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['annualCourseID', 'active', 'status'], 'annualCourseID');
            $table->index(['userID', 'active', 'created'], 'userID_2');
            $table->index(['userID', 'active', 'status', 'created'], 'userID');
            $table->index(['active', 'assocToRegion'], 'active');
        });

        Schema::create('ams_training_courses_annual_bookings_notes', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('bookingID');
            $table->integer('annualCourseID');
            $table->integer('userID');
            $table->text('note');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby')->nullable();
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['annualCourseID', 'userID', 'active'], 'annualCourseID');
            $table->index(['userID', 'bookingID', 'annualCourseID', 'active'], 'userID');
        });

        Schema::create('ams_training_courses_annual_bookings_tracking', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('bookingID')->index('bookingID');
            $table->integer('annualCourseID')->index('annualCourseID');
            $table->integer('userID')->index('userID');
            $table->integer('fromStatus');
            $table->integer('toStatus');
            $table->dateTime('created');
            $table->integer('createdby')->nullable();
        });

        Schema::create('ams_training_courses_annual_dates', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(1);
            $table->integer('courseID')->index('courseID');
            $table->integer('dayNr');
            $table->date('startDate');
            $table->time('startTime');
            $table->time('endTime');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_training_courses_annual_lecturers', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('annualCourseID');
            $table->integer('lecturerID');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['annualCourseID', 'active'], 'annualCourseID');
            $table->index(['lecturerID', 'annualCourseID', 'active'], 'lecturerID');
        });

        Schema::create('ams_training_courses_annual_warrants_available', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('annualCourseID');
            $table->integer('warrantID');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['annualCourseID', 'active'], 'annualCourseID');
        });

        Schema::create('ams_training_courses_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->string('colour', 100);
            $table->integer('active');
        });

        Schema::create('ams_training_locations', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion');
            $table->string('name');
            $table->text('address');
            $table->string('gpsLat');
            $table->string('gpsLon');
            $table->integer('trainingSeats');
            $table->string('contact');
            $table->string('tel')->nullable();
            $table->string('cell')->nullable();
            $table->string('email')->nullable();
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['countryID', 'assocToRegion', 'active'], 'countryID');
        });

        Schema::create('ams_training_past', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable()->index('assocToRegion');
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup')->nullable();
            $table->integer('userID');
            $table->integer('trainingTypeID')->nullable();
            $table->text('courseName')->nullable();
            $table->string('courseNumber');
            $table->date('completionDate');
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('validated')->default(0)->comment('1 = Validated');
            $table->dateTime('validatedDate')->nullable();
            $table->integer('validatedby')->nullable();

            $table->index(['userID', 'active', 'trainingTypeID'], 'userID');
        });

        Schema::create('ams_training_past_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->integer('code')->nullable();
            $table->string('calendarColour', 25)->nullable();
            $table->string('shortName');
            $table->text('description');
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(2);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_warrant_applications', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable()->index('assocToRegion');
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup')->nullable();
            $table->integer('userID')->index('userID');
            $table->integer('warrantTypeID');
            $table->string('PDFLocation', 1024);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->dateTime('awardDate')->nullable();
            $table->integer('awardedBy')->nullable();
            $table->dateTime('declinedDate')->nullable();
            $table->integer('declinedBy')->nullable();
            $table->string('awardType')->nullable();
            $table->text('awardDescription')->nullable();
        });

        Schema::create('ams_warrant_cancellation_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->integer('active')->default(1);
        });

        Schema::create('ams_warrant_extensions', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable()->index('assocToRegion');
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup')->nullable();
            $table->integer('warrantID')->index('warrantID');
            $table->integer('userID')->index('userID');
            $table->date('oldExpireDate');
            $table->date('newExpireDate');
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('ams_warrant_info', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(0)->index('assocToRegion');
            $table->integer('assocToDistrict')->default(0);
            $table->integer('assocToGroup')->default(0);
            $table->integer('userID');
            $table->integer('roleID')->nullable();
            $table->integer('warrantTypeID')->nullable();
            $table->string('warrantNr', 225);
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

            $table->index(['userID', 'expireDate', 'active'], 'userID');
            $table->index(['userID', 'countryID', 'assocToRegion', 'assocToDistrict', 'assocToGroup', 'active', 'expireDate', 'roleID'], 'userID_2');
            $table->index(['countryID', 'warrantNr', 'active'], 'countryID');
        });

        Schema::create('ams_warrant_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('position')->default(0);
            $table->string('name');
            $table->string('shortName');
            $table->text('description');
            $table->integer('national')->default(0);
            $table->integer('region')->default(0);
            $table->integer('district')->default(0);
            $table->integer('group')->default(0);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(2);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('api_keys', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->longText('key');
            $table->integer('issuedToUserID');
            $table->longText('information');
            $table->integer('active');
            $table->dateTime('created');
        });

        Schema::create('api_usage', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('IPAddress', 45)->nullable();
            $table->string('APICalled', 45)->nullable();
            $table->longText('userAgent')->nullable();
            $table->longText('keyUsed')->nullable();
            $table->longText('presented')->nullable();
            $table->longText('response')->nullable();
            $table->dateTime('created');
        });

        Schema::create('badges_cubs', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(0);
            $table->integer('assocToDistrict')->default(0);
            $table->integer('assocToGroup');
            $table->integer('cubID');
            $table->integer('userID')->nullable();
            $table->integer('firstID')->index('firstID');
            $table->integer('secondID')->nullable();
            $table->date('badgeDate');
            $table->text('notes')->nullable();
            $table->string('PDFLocation')->nullable();
            $table->integer('latest')->default(0)->comment('1 = latest');
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToDistrict', 'firstID', 'active', 'latest'], 'assocToDistrict');
            $table->index(['countryID', 'firstID', 'active', 'latest'], 'countryID_2');
            $table->index(['assocToGroup', 'firstID', 'active', 'latest'], 'assocToGroup');
            $table->index(['assocToRegion', 'firstID', 'active', 'latest'], 'assocToRegion');
            $table->index(['cubID', 'active', 'secondID'], 'cubID');
            $table->index(['userID', 'PDFLocation'], 'userID');
            $table->index(['cubID', 'firstID', 'secondID', 'active'], 'cubID_2');
            $table->index(['countryID', 'firstID', 'secondID'], 'countryID');
        });

        Schema::create('badges_documents', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('type')->default(17);
            $table->integer('assocToGroup')->index('assocToGroup');
            $table->integer('userID');
            $table->text('description');
            $table->string('PDFLocation', 1024);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('badgeFirstID')->index('advancementFirstID');
            $table->integer('badgeSecondID')->index('advancementSecondID');
            $table->integer('active')->default(1);

            $table->index(['userID', 'badgeFirstID', 'badgeSecondID', 'type', 'active'], 'userID');
        });

        Schema::create('badges_meerkats', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(0);
            $table->integer('assocToDistrict')->default(0);
            $table->integer('assocToGroup')->index('assocToGroup');
            $table->integer('meerkatID')->nullable();
            $table->integer('userID');
            $table->integer('firstID')->index('firstID');
            $table->integer('secondID')->nullable();
            $table->date('badgeDate');
            $table->text('notes')->nullable();
            $table->string('PDFLocation')->nullable();
            $table->integer('latest')->default(0)->comment('1 = latest');
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['countryID', 'firstID', 'secondID'], 'countryID');
            $table->index(['userID', 'firstID', 'secondID', 'active'], 'userID');
            $table->index(['userID', 'active', 'secondID'], 'cubID');
        });

        Schema::create('badges_notes', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('type')->default(17);
            $table->integer('assocToGroup')->index('assocToGroup');
            $table->integer('userID');
            $table->text('note');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('firstID')->index('firstID');
            $table->integer('secondID')->index('secondID');
            $table->integer('thirdID')->nullable()->index('thirdID');
            $table->integer('active')->default(1);

            $table->index(['userID', 'firstID', 'secondID', 'type', 'active'], 'userID');
        });

        Schema::create('badges_photos', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('type')->default(17);
            $table->integer('assocToGroup')->index('assocToGroup');
            $table->integer('userID')->index('userID');
            $table->text('description');
            $table->string('PDFLocation', 1024);
            $table->string('thumbLocation', 1024);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('badgeFirstID')->index('advancementFirstID');
            $table->integer('badgeSecondID')->index('advancementSecondID');
            $table->integer('active')->default(1);
        });

        Schema::create('badges_rovers', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(0);
            $table->integer('assocToDistrict')->default(0);
            $table->integer('assocToGroup');
            $table->integer('roverID');
            $table->integer('userID')->nullable();
            $table->integer('firstID')->index('firstID');
            $table->integer('secondID')->nullable();
            $table->date('badgeDate');
            $table->text('notes')->nullable();
            $table->string('PDFLocation')->nullable();
            $table->integer('latest')->default(0)->comment('1 = latest');
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->dateTime('approvedDate')->nullable();
            $table->integer('approvedBy')->nullable();

            $table->index(['assocToRegion', 'firstID', 'active', 'latest'], 'assocToRegion');
            $table->index(['roverID', 'active', 'secondID'], 'scoutID');
            $table->index(['assocToDistrict', 'firstID', 'active', 'latest'], 'assocToDistrict');
            $table->index(['countryID', 'firstID', 'active', 'latest'], 'countryID');
            $table->index(['assocToGroup', 'firstID', 'active', 'latest'], 'assocToGroup');
            $table->index(['roverID', 'firstID', 'secondID', 'active'], 'roverID');
        });

        Schema::create('badges_scouts', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(0);
            $table->integer('assocToDistrict')->default(0);
            $table->integer('assocToGroup');
            $table->integer('scoutID');
            $table->integer('userID')->nullable();
            $table->integer('firstID')->index('firstID');
            $table->integer('secondID')->nullable();
            $table->date('badgeDate');
            $table->text('notes')->nullable();
            $table->string('PDFLocation')->nullable();
            $table->integer('latest')->default(0)->comment('1 = latest');
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->dateTime('approvedDate')->nullable();
            $table->integer('approvedBy')->nullable();

            $table->index(['assocToRegion', 'firstID', 'active', 'latest'], 'assocToRegion');
            $table->index(['scoutID', 'firstID', 'secondID', 'active'], 'scoutID_2');
            $table->index(['assocToDistrict', 'firstID', 'active', 'latest'], 'assocToDistrict');
            $table->index(['scoutID', 'active', 'secondID'], 'scoutID');
            $table->index(['countryID', 'firstID', 'active', 'latest'], 'countryID');
            $table->index(['assocToGroup', 'firstID', 'active', 'latest'], 'assocToGroup');
        });

        Schema::create('census_documents', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID');
            $table->integer('regionID')->nullable();
            $table->integer('districtID')->nullable();
            $table->integer('groupID')->nullable();
            $table->string('XLSLocation', 1024);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby')->default(0);

            $table->index(['districtID', 'active'], 'districtID');
            $table->index(['groupID', 'active'], 'groupID');
            $table->index(['countryID', 'active'], 'countryID');
            $table->index(['regionID', 'active'], 'regionID');
        });

        Schema::create('commerce_cart', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('accountID');
            $table->integer('qty');
            $table->integer('productID');
            $table->integer('active');
            $table->integer('deliveryAddressID')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['accountID', 'active'], 'accountID');
        });

        Schema::create('commerce_delivery_address', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('accountID')->nullable();
            $table->integer('defaultAddress')->default(0);
            $table->string('name');
            $table->string('unitNr')->nullable();
            $table->string('complexName')->nullable();
            $table->string('streetNr', 10);
            $table->string('streetName');
            $table->string('suburb')->nullable();
            $table->string('city');
            $table->string('province');
            $table->string('postCode', 5);
            $table->string('country');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['id', 'accountID'], 'id');
            $table->index(['accountID', 'active', 'defaultAddress'], 'accountID');
        });

        Schema::create('commerce_delivery_providers', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->string('location');
        });

        Schema::create('commerce_delivery_providers_delivery_options', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('providerID');
            $table->text('description');
        });

        Schema::create('commerce_group_fees', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('accountID');
            $table->integer('countryID');
            $table->integer('regionID');
            $table->integer('districtID');
            $table->integer('groupID');
            $table->decimal('amount', 10);
            $table->integer('paidOutToGroup')->nullable();
            $table->dateTime('paidOutDate')->nullable();
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
        });

        Schema::create('commerce_order_status', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->integer('active');
        });

        Schema::create('commerce_orders', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('groupProduct')->nullable();
            $table->integer('userID');
            $table->integer('countryID')->nullable();
            $table->integer('regionID')->nullable();
            $table->integer('districtID')->nullable();
            $table->integer('groupID')->nullable();
            $table->integer('deliveryAddressID');
            $table->string('deliveryOption');
            $table->decimal('deliveryAmountIncVAT', 11)->default(0);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->integer('status')->nullable();
            $table->integer('active');
        });

        Schema::create('commerce_orders_details', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('orderID');
            $table->integer('userID');
            $table->integer('productID');
            $table->integer('qty');
            $table->decimal('unitPriceIncVat', 7);
            $table->integer('active');
        });

        Schema::create('commerce_payfast_transactions', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('accountID');
            $table->integer('userID');
            $table->string('status', 100);
            $table->decimal('amount', 10);

            $table->index(['accountID', 'status'], 'accountID');
        });

        Schema::create('commerce_products', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('groupID')->default(0);
            $table->integer('stockLocationID')->nullable()->index('stockLocationID');
            $table->integer('stockSupplierID')->nullable();
            $table->integer('catID')->nullable();
            $table->integer('subCatID')->nullable();
            $table->integer('subSubCatID')->nullable();
            $table->string('image', 1024)->nullable();
            $table->string('thumb', 1024)->nullable();
            $table->string('name')->fulltext('name');
            $table->string('slug');
            $table->text('description')->fulltext('description');
            $table->text('extended')->nullable()->fulltext('extended');
            $table->integer('featured')->default(0);
            $table->integer('onSale')->default(0);
            $table->decimal('priceIncVAT', 7);
            $table->decimal('salePriceIncVAT', 7)->nullable();
            $table->decimal('costPriceIncVAT', 7)->nullable();
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['groupID', 'onSale', 'active'], 'groupID_3');
            $table->index(['catID', 'subCatID', 'subSubCatID'], 'catID');
            $table->index(['groupID', 'active'], 'groupID');
            $table->fullText(['name'], 'name_2');
            $table->index(['groupID', 'featured', 'active'], 'groupID_2');
            $table->index(['groupID', 'catID', 'active'], 'groupID_4');
        });

        Schema::create('commerce_products_cat', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->integer('active')->index('active');
        });

        Schema::create('commerce_products_images', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('productID');
            $table->string('thumb', 1024);
            $table->string('image', 1024);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('commerce_products_reviews', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('productID');
            $table->integer('userID');
            $table->text('review');
            $table->integer('stars')->nullable();
            $table->integer('active');
            $table->dateTime('created')->index('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['userID', 'active'], 'userID');
            $table->index(['productID', 'active'], 'productID');
        });

        Schema::create('commerce_products_stock', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('productID')->index('productID');
            $table->integer('stockIn')->nullable();
            $table->integer('stockOut')->nullable();
            $table->dateTime('date');
        });

        Schema::create('commerce_products_sub_subcat', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('catID');
            $table->integer('subCatID');
            $table->string('name');
            $table->text('description');
            $table->integer('active');
        });

        Schema::create('commerce_products_subcat', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('catID');
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->integer('active');
        });

        Schema::create('commerce_search_queries', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('name')->nullable();
            $table->integer('catID')->nullable();
            $table->integer('userID')->nullable();
            $table->integer('countryID');
            $table->integer('regionID');
            $table->integer('districtID');
            $table->integer('groupID');
            $table->date('date');
            $table->string('time', 10);
        });

        Schema::create('commerce_shoppers_logins', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->dateTime('date');
            $table->string('ip');
            $table->string('fromLocation');
            $table->text('userAgent');
        });

        Schema::create('commerce_stock_locations', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('name');
            $table->text('physAddress');
            $table->string('gpsLat', 12);
            $table->string('gpsLon', 12);
            $table->string('contactName');
            $table->string('contactCell', 25);
            $table->string('contactEmail');
            $table->integer('active');
        });

        Schema::create('commerce_stock_suppliers', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('name');
            $table->text('physAddress');
            $table->string('gpsLat', 12);
            $table->string('gpsLon', 12);
            $table->string('contactName');
            $table->string('contactCell', 25);
            $table->string('contactEmail');
            $table->integer('active');
        });

        Schema::create('commerce_wallet', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('accountID');
            $table->integer('transactionType');
            $table->string('transactionID', 1024);
            $table->decimal('transactionAmountINCVAT', 10);
            $table->dateTime('transactionDate');
            $table->integer('active');
            $table->integer('paidToGroup')->default(0);
            $table->date('paidToGroupDate')->nullable();

            $table->index(['accountID', 'transactionType', 'transactionAmountINCVAT'], 'accountID');
        });

        Schema::create('commerce_wallets_transaction_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->text('description');
        });

        Schema::create('commerce_wish_list', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('accountID');
            $table->integer('productID');
            $table->integer('qty');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['accountID', 'active'], 'accountID');
            $table->index(['userID', 'id'], 'userID');
        });

        Schema::create('directory_professional', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('companyName');
            $table->integer('countryID')->default(196);
            $table->string('locationName');
            $table->text('bio');
            $table->text('skills');
            $table->integer('likes')->default(0);
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('pintrest')->nullable();
            $table->string('googlePlus', 1024)->nullable();
            $table->string('website')->nullable();
            $table->string('contactPersonName');
            $table->string('contactEmail')->nullable();
            $table->string('contactTel')->nullable();
            $table->integer('active')->default(1);
            $table->integer('approved')->default(0);
            $table->integer('approvedBy')->nullable();
            $table->dateTime('approvedDate')->nullable();
            $table->integer('declined')->nullable()->default(0);
            $table->integer('declinedBy')->nullable();
            $table->dateTime('declinedDate')->nullable();
            $table->string('declinedReason', 1024)->nullable();
            $table->text('declinedNotes')->nullable();
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['countryID', 'active', 'approved', 'createdby'], 'countryID');
        });

        Schema::create('directory_professional_likes', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('directoryID');
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby');

            $table->index(['directoryID', 'active', 'createdby'], 'directoryID');
        });

        Schema::create('directory_professional_reviews', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('directoryID');
            $table->text('review');
            $table->integer('stars');
            $table->integer('active')->default(1);
            $table->integer('approved')->default(0);
            $table->integer('approvedBy')->nullable();
            $table->dateTime('approvedDate')->nullable();
            $table->integer('declined')->default(0);
            $table->integer('declinedReasonID')->default(0);
            $table->integer('declinedby')->default(0);
            $table->dateTime('declinedDate')->nullable();
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['directoryID', 'active'], 'directoryID');
        });

        Schema::create('directory_skills', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('skill');
            $table->integer('timesUsed')->default(0);
            $table->integer('active')->default(1);
        });

        Schema::create('districts', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('regionID');
            $table->integer('superDistrictID')->default(0);
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('phys_address')->nullable();
            $table->integer('countryID')->default(196);
            $table->integer('active')->default(1);
            $table->integer('accountID')->default(0);
            $table->integer('censusDone')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['countryID', 'active'], 'countryID');
            $table->index(['regionID', 'active'], 'regionID');
            $table->index(['countryID', 'regionID', 'active'], 'phys_country_id');
        });

        Schema::create('districts_super', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('regionID');
            $table->string('name');
            $table->text('description');
            $table->integer('active')->default(1)->index('countryID');
            $table->integer('accountID')->default(0);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['countryID', 'regionID', 'active'], 'phys_country_id');
            $table->index(['regionID', 'active'], 'regionID');
        });

        Schema::create('event_booking_setup_changes', static function (Blueprint $table) {
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

        Schema::create('event_competition_score_adjudication', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('teamID');
            $table->integer('scoringAreaID');
            $table->integer('adjudicationScore');
            $table->integer('active');
            $table->text('notes')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'teamID', 'scoringAreaID', 'active'], 'eventID');
        });

        Schema::create('event_competitions_answers', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('questionID');
            $table->string('answer');
            $table->integer('score');
            $table->integer('position');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'questionID', 'answer', 'active'], 'eventID');
        });

        Schema::create('event_competitions_finances_invoices', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('teamID');
            $table->integer('amount');
            $table->date('date');
            $table->string('PDFLocation', 1024);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'teamID', 'active'], 'eventID');
        });

        Schema::create('event_competitions_finances_payments', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('teamID');
            $table->integer('amount');
            $table->date('date');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'teamID', 'active'], 'eventID');
        });

        Schema::create('event_competitions_gps', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->decimal('GPSLong', 11, 8);
            $table->decimal('GPSLat', 11, 8);
            $table->integer('position')->index('position');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'active'], 'eventID');
        });

        Schema::create('event_competitions_groups_attending', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('groupID');
            $table->integer('teamNumber');
            $table->string('teamName');
            $table->integer('scoreComplete');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'active'], 'eventID');
        });

        Schema::create('event_competitions_groups_participating', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('teamID');
            $table->integer('internalCompetitionID');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'active'], 'eventID');
        });

        Schema::create('event_competitions_internal_competitions', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->string('name');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'active'], 'eventID');
        });

        Schema::create('event_competitions_judges', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('userID');
            $table->integer('judgeTypeID');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'active', 'userID'], 'eventID');
        });

        Schema::create('event_competitions_judges_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->integer('canAdmin')->default(0);
            $table->integer('canCaptureScores')->default(0);
            $table->integer('canAdminJudges')->default(0);
            $table->integer('canAdminFinances')->default(0);
            $table->integer('canAdminTeams')->default(0);
            $table->integer('medical')->default(0);
            $table->integer('seaWorthiness')->default(0);
            $table->integer('active')->default(1)->index('active');
        });

        Schema::create('event_competitions_location_logging', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID')->nullable();
            $table->integer('groupID')->nullable();
            $table->integer('districtID')->nullable();
            $table->integer('regionID')->nullable();
            $table->integer('roleID')->nullable();
            $table->integer('userID');
            $table->string('userAgent')->nullable();
            $table->decimal('accuracy', 11)->nullable()->comment('radius of accuracy meters');
            $table->decimal('altitude', 11, 3)->nullable()->comment('meters above sea level');
            $table->string('altitudeAccuracy')->nullable()->comment('radius of altitude accuracy meters');
            $table->string('heading')->nullable()->comment('Degrees from true North');
            $table->decimal('latitude', 11, 8);
            $table->decimal('longitude', 11, 8);
            $table->decimal('speed', 11, 3)->nullable()->comment('meters per second');
            $table->integer('speedDone')->default(0);
            $table->date('date')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
            $table->integer('used')->default(0);

            $table->index(['eventID', 'groupID', 'active', 'roleID', 'created'], 'eventID');
            $table->index(['groupID', 'roleID', 'active', 'created'], 'groupID_2');
            $table->index(['eventID', 'userID', 'speed', 'active'], 'userID');
            $table->index(['groupID', 'active', 'speed'], 'For Speed');
            $table->index(['groupID', 'roleID', 'active', 'latitude', 'longitude', 'used'], 'groupID');
            $table->index(['eventID', 'active'], 'eventID_3');
            $table->index(['eventID', 'groupID', 'active', 'roleID', 'latitude', 'longitude'], 'eventID_2');
        });

        Schema::create('event_competitions_questions', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('internalCompetitionID');
            $table->integer('scoringAreaID');
            $table->integer('scoringSheetID');
            $table->integer('headingID');
            $table->string('question', 1024);
            $table->integer('position');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'active', 'internalCompetitionID', 'scoringAreaID', 'scoringSheetID', 'headingID'], 'eventID');
        });

        Schema::create('event_competitions_scoring', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('teamID');
            $table->integer('scoringAreaID');
            $table->integer('scoringSheetID');
            $table->integer('questionID');
            $table->integer('answerID');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedBy')->nullable();
            $table->text('notes')->nullable();

            $table->index(['eventID', 'scoringAreaID', 'teamID', 'active'], 'eventID_2');
            $table->index(['eventID', 'active', 'scoringSheetID', 'questionID', 'answerID'], 'eventID');
        });

        Schema::create('event_competitions_scoring_areas', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('internalCompetitionID');
            $table->string('name');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'active', 'internalCompetitionID'], 'eventID');
        });

        Schema::create('event_competitions_scoring_dnp', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('teamID');
            $table->integer('scoringSheetID');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'teamID', 'scoringSheetID', 'active'], 'eventID');
        });

        Schema::create('event_competitions_scoring_sheets', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('internalCompetitionID');
            $table->string('name');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->date('startDate');
            $table->string('startTime', 5);
            $table->date('endDate');
            $table->string('endTime', 5);
            $table->integer('usesGPS')->default(0);
            $table->integer('pdf')->default(1);
            $table->integer('registration')->default(0);
            $table->integer('medicalScore')->default(0);
            $table->integer('seaWorthynessScore')->default(0);

            $table->index(['eventID', 'active', 'internalCompetitionID'], 'eventID');
        });

        Schema::create('event_competitions_scoring_sheets_headings', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('internalCompetitionID');
            $table->integer('scoringSheetID');
            $table->string('heading');
            $table->integer('position');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedBy')->nullable();

            $table->index(['eventID', 'active', 'internalCompetitionID', 'scoringSheetID'], 'eventID');
        });

        Schema::create('event_competitions_survey_responses', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->text('cookieID')->nullable();
            $table->string('userIP')->nullable();
            $table->string('teamName')->nullable();
            $table->integer('initialRegistration')->nullable();
            $table->text('improveInitialRegistration')->nullable();
            $table->integer('communicationPrior')->nullable();
            $table->text('improveCommunicationsPrior')->nullable();
            $table->integer('communicationDuring')->nullable();
            $table->integer('qualityCommunicationDuring')->nullable();
            $table->integer('judging')->nullable();
            $table->integer('judgesEngageWithPL')->nullable();
            $table->text('judgingSuggestions')->nullable();
            $table->text('improveCommunicationsDuring')->nullable();
            $table->text('improveJudging')->nullable();
            $table->text('suggestions')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent()->index('created');

            $table->index(['eventID', 'active'], 'eventID');
        });

        Schema::create('event_user_booking', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('status')->comment('1 = Provisional. 2 = Confirmed, 3 = Guaranteed, 4 = Cancelled');
            $table->integer('userID');
            $table->integer('travelArrangements')->nullable()->default(0);
            $table->integer('accommodationArrangements')->nullable()->default(0);
            $table->integer('apparelOption')->nullable();
            $table->integer('patrolID')->nullable();
            $table->integer('canAdmin');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['userID', 'active'], 'userID');
        });

        Schema::create('event_user_booking_accomodation', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->string('name', 1024);
            $table->integer('cost');
            $table->integer('nrAvailable')->default(0);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'active'], 'eventID');
        });

        Schema::create('event_user_booking_credit_notes', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('userID');
            $table->integer('amount');
            $table->text('notes')->nullable();
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('event_user_booking_invoices', static function (Blueprint $table) {
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

        Schema::create('event_user_booking_notes', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('userID');
            $table->text('note');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'userID', 'active'], 'eventID');
        });

        Schema::create('event_user_booking_other_options', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->string('name');
            $table->integer('cost')->default(0);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'active'], 'eventID');
        });

        Schema::create('event_user_booking_patrol_allocation', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('userID');
            $table->integer('patrolID');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['userID', 'eventID', 'active'], 'userID');
            $table->index(['eventID', 'userID', 'active'], 'eventID');
        });

        Schema::create('event_user_booking_patrols', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->string('name');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'active'], 'eventID');
        });

        Schema::create('event_user_booking_payments', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('userID');
            $table->integer('amount');
            $table->date('date');
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('event_user_booking_pops', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('userID');
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('event_user_booking_roles', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->integer('roleID');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'roleID', 'active'], 'eventID');
        });

        Schema::create('event_user_booking_transport', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->string('name');
            $table->integer('cost')->default(0);
            $table->integer('nrAvailable')->default(0);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'active'], 'eventID');
        });

        Schema::create('group_account_transfers_notes', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('transferID');
            $table->text('note');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['transferID', 'active'], 'transferID');
        });

        Schema::create('group_accounts', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('accountName');
            $table->integer('accountType');
            $table->integer('assocToRegion')->default(0);
            $table->integer('assocToDistrict')->default(0);
            $table->integer('assocToGroup')->default(0);
            $table->integer('nationalAccount')->default(0);
            $table->integer('regionalAccount')->default(0);
            $table->integer('districtAccount')->default(0);
            $table->integer('groupAccount')->default(0);
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['id', 'assocToGroup', 'active', 'groupAccount'], 'id');
            $table->index(['assocToGroup', 'active', 'accountType'], 'assocToGroup_2');
            $table->index(['assocToGroup', 'active', 'groupAccount'], 'assocToGroup');
        });

        Schema::create('group_accounts_transfers', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('fromCountryID');
            $table->integer('fromRegionID');
            $table->integer('fromDistrictID');
            $table->integer('fromGroupID');
            $table->integer('toCountryID');
            $table->integer('toRegionID');
            $table->integer('toDistrictID');
            $table->integer('toGroupID');
            $table->integer('accountID');
            $table->integer('action')->comment('1 = From SGL Must Approve, 2 = From Treasurer Must Approve, 3 = To SGL Must Approve');
            $table->text('notes');
            $table->integer('fromSGLApproved')->nullable();
            $table->integer('fromSGLID')->nullable();
            $table->dateTime('fromSGLApprovedDate')->nullable();
            $table->text('fromSGLNotes')->nullable();
            $table->integer('fromTreasurerApproved')->nullable();
            $table->integer('fromTreasurerID')->nullable();
            $table->dateTime('fromTreasurerApprovedDate')->nullable();
            $table->text('fromTreasurerNotes')->nullable();
            $table->integer('toSGLApproved')->nullable();
            $table->integer('toSGLID')->nullable();
            $table->dateTime('toSGLApprovedDate')->nullable();
            $table->text('toSGLNotes')->nullable();
            $table->dateTime('actualTransferDate')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['fromGroupID', 'action'], 'fromGroupID');
            $table->index(['toGroupID', 'action'], 'toGroupID');
        });

        Schema::create('group_accounts_transfers_stages', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
        });

        Schema::create('group_advancements_in_events', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup');
            $table->integer('scoutProgramTypeID')->default(1);
            $table->string('type', 15)->comment('Cub Or Scout');
            $table->integer('eventID');
            $table->integer('firstID')->default(0);
            $table->integer('secondID')->default(0);
            $table->integer('thirdID')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('group_advancements_in_programs', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup');
            $table->integer('scoutProgramTypeID')->default(1);
            $table->string('type', 15)->comment('Cub Or Scout');
            $table->integer('programID');
            $table->integer('firstID')->default(0);
            $table->integer('secondID')->default(0);
            $table->integer('thirdID')->default(0);
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['programID', 'active'], 'programID');
            $table->index(['assocToGroup', 'programID', 'firstID', 'secondID', 'active', 'thirdID'], 'assocToGroup');
        });

        Schema::create('group_attendance', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userId');
            $table->string('userSex', 10)->nullable();
            $table->string('type');
            $table->integer('programId')->nullable();
            $table->integer('eventId')->nullable()->default(0);
            $table->date('programDate');
            $table->integer('assocToGroup')->index('assocToGroup');
            $table->integer('attendance')->comment('1 = Attended');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('moved')->default(0);

            $table->index(['programId', 'attendance', 'type'], 'programId_3');
            $table->index(['programId', 'userId'], 'programId_2');
            $table->index(['programId', 'type', 'assocToGroup', 'attendance', 'programDate'], 'programId');
            $table->index(['eventId', 'userId'], 'eventId');
            $table->index(['userId', 'attendance', 'assocToGroup'], 'userId');
            $table->index(['programId', 'attendance'], 'programId_5');
            $table->index(['userId', 'type', 'attendance', 'programDate', 'programId'], 'userId_2');
            $table->index(['eventId', 'type'], 'eventId_2');
            $table->index(['eventId', 'moved'], 'eventId_3');
            $table->index(['programId', 'eventId', 'userId'], 'programId_4');
        });

        Schema::create('group_badges_in_events', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup');
            $table->integer('scoutProgramTypeID')->default(1);
            $table->string('type', 15)->comment('Cub Or Scout');
            $table->integer('eventID');
            $table->integer('firstID')->default(0);
            $table->integer('secondID')->default(0);
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToGroup', 'eventID', 'active'], 'assocToGroup');
        });

        Schema::create('group_badges_in_programs', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup');
            $table->integer('scoutProgramTypeID')->default(1);
            $table->string('type', 15)->comment('Cub Or Scout');
            $table->integer('programID');
            $table->integer('firstID')->default(0);
            $table->integer('secondID')->default(0);
            $table->integer('thirdID')->default(0);
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToGroup', 'programID', 'firstID', 'secondID', 'active'], 'assocToGroup_2');
            $table->index(['assocToGroup', 'programID', 'active'], 'assocToGroup');
        });

        Schema::create('group_committee', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup');
            $table->integer('userID');
            $table->integer('typeID')->index('typeID');
            $table->date('dateAppointed');
            $table->date('dateRemoved')->nullable();
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToGroup', 'userID', 'active'], 'assocToGroup');
            $table->index(['userID', 'typeID', 'assocToGroup', 'active'], 'userID');
            $table->index(['assocToGroup', 'active', 'typeID'], 'assocToGroup_2');
        });

        Schema::create('group_council', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup');
            $table->integer('userID')->index('userID');
            $table->integer('typeID')->index('typeID');
            $table->date('dateAppointed');
            $table->date('dateRemoved')->nullable();
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToGroup', 'userID', 'active'], 'assocToGroup');
        });

        Schema::create('group_cub_packs', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('assocToGroup');
            $table->string('name');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('group_cubs_sixes_names', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup');
            $table->integer('packID')->nullable();
            $table->string('name');
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');

            $table->index(['assocToGroup', 'active'], 'assocToGroup');
        });

        Schema::create('group_district_reports', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup');
            $table->date('reportMonth');
            $table->string('area');
            $table->integer('boys');
            $table->integer('girls');
        });

        Schema::create('group_district_reports_cubs', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID');
            $table->integer('assocToRegion');
            $table->integer('assocToDistrict');
            $table->integer('assocToGroup');
            $table->date('reportMonth');
            $table->date('LastMonth');
            $table->integer('lastMonthBoys');
            $table->integer('lastMonthGirls');
            $table->integer('thisMonthBoys');
            $table->integer('thisMonthGirls');
            $table->integer('jtpBoys');
            $table->integer('jtpGirls');
            $table->integer('ltpBoys');
            $table->integer('ltpGirls');
            $table->integer('leavingBoys');
            $table->integer('leavingGirls');
            $table->integer('toScoutsBoys');
            $table->integer('toScoutsGirls');
            $table->integer('usMale');
            $table->integer('usFemale');
            $table->integer('parentHelperMale');
            $table->integer('parentHelperFemale');
            $table->integer('committeeMale');
            $table->integer('committeeFemale');
            $table->integer('membershipBoys');
            $table->integer('membershipGirls');
            $table->integer('swBoys');
            $table->integer('swGirls');
            $table->integer('gwBoys');
            $table->integer('gwGirls');
            $table->integer('lwBoys');
            $table->integer('lwGirls');
            $table->integer('badgesBoys');
            $table->integer('badgesGirls');
            $table->integer('advBoys');
            $table->integer('advGirls');
            $table->text('advancement');
            $table->text('packActivity');
            $table->text('groupActivity');
        });

        Schema::create('group_district_reports_cubs_attendance', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion');
            $table->integer('assocToDistrict');
            $table->integer('assocToGroup');
            $table->string('reportMonth', 10);
            $table->integer('nr');
            $table->date('date');
            $table->integer('strength');
            $table->integer('present');
            $table->integer('percent');
            $table->string('comments');
        });

        Schema::create('group_district_reports_scouts', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID');
            $table->integer('assocToRegion');
            $table->integer('assocToDistrict');
            $table->integer('assocToGroup');
            $table->date('reportMonth');
            $table->date('LastMonth');
            $table->integer('lastMonthBoys');
            $table->integer('lastMonthGirls');
            $table->integer('thisMonthBoys');
            $table->integer('thisMonthGirls');
            $table->integer('jttBoys');
            $table->integer('jttGirls');
            $table->integer('lttBoys');
            $table->integer('lttGirls');
            $table->integer('leavingBoys');
            $table->integer('leavingGirls');
            $table->integer('toRoversBoys');
            $table->integer('toRoversGirls');
            $table->integer('usMale');
            $table->integer('usFemale');
            $table->integer('parentHelperMale');
            $table->integer('parentHelperFemale');
            $table->integer('committeeMale');
            $table->integer('committeeFemale');
            $table->integer('membershipBoys');
            $table->integer('membershipGirls');
            $table->integer('pfBoys');
            $table->integer('pfGirls');
            $table->integer('adBoys');
            $table->integer('adGirls');
            $table->integer('fcBoys');
            $table->integer('fcGirls');
            $table->integer('exBoys');
            $table->integer('exGirls');
            $table->integer('spBoys');
            $table->integer('spGirls');
            $table->integer('badgesBoys');
            $table->integer('badgesGirls');
            $table->integer('advBoys');
            $table->integer('advGirls');
            $table->text('advancement');
            $table->text('troopActivity');
            $table->text('groupActivity');
        });

        Schema::create('group_district_reports_scouts_attendance', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('assocToGroup');
            $table->string('reportMonth', 10);
            $table->integer('nr');
            $table->date('date');
            $table->integer('strength');
            $table->integer('present');
            $table->integer('percent');
            $table->string('comments');
        });

        Schema::create('group_documents', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('docType');
            $table->string('docArea')->nullable();
            $table->integer('assocToPerson')->nullable();
            $table->integer('assocToAccount')->default(0);
            $table->integer('assocToGroup');
            $table->string('description');
            $table->string('location', 1024);
            $table->date('expiryDate')->nullable();
            $table->integer('active')->default(1);
            $table->date('created');
            $table->integer('createdby')->default(0);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToGroup', 'assocToAccount', 'active'], 'assocToGroup');
        });

        Schema::create('group_edit_record', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('groupID')->nullable()->index('idx_group_edit_record_groupID');
            $table->longText('fromData')->nullable();
            $table->longText('toData')->nullable();
            $table->dateTime('created')->nullable();
            $table->integer('createdByID')->nullable();
        });

        Schema::create('group_equipment', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup');
            $table->string('name');
            $table->text('description');
            $table->integer('locationID');
            $table->integer('purchased')->comment('2 = Purchased, 1 = Donated');
            $table->integer('purchaseCost')->nullable();
            $table->integer('replacementCost')->nullable();
            $table->integer('totalPurchaseCost');
            $table->integer('totalReplacementCost');
            $table->date('purchaseDate');
            $table->text('purchaseLocation')->nullable();
            $table->integer('qty');
            $table->integer('insured')->comment('1 = Insured');
            $table->string('expectedLifeFromPurchaseDate');
            $table->string('assetCondition');
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('group_equipment_store', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('group_event_documents', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('eventID');
            $table->text('name');
            $table->string('PDFLocation', 1024);
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'active'], 'programID');
        });

        Schema::create('group_events', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('nationalEvent')->default(0);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup');
            $table->integer('assocToDistrict');
            $table->integer('assocToRegion');
            $table->integer('associatedToNationalEventID')->default(0);
            $table->integer('associatedToRegionEventID')->default(0);
            $table->integer('associatedToDistrictEventID')->default(0);
            $table->integer('eventFor')->default(0)->comment('1 = Cubs Only, 2 = Scouts Only, 3 = Rovers Only, 4 = Adults Only, 5 = Group, 6 = Meerkats Only');
            $table->integer('eventFor2')->default(2)->comment('1 = Groups, 2 = Adult Leaders');
            $table->integer('eventAway')->default(0)->comment('1 = Away, 2 = At Scout Hall');
            $table->integer('eventPatrolID')->default(0);
            $table->integer('multiID')->nullable();
            $table->integer('denID')->nullable();
            $table->integer('packID')->nullable();
            $table->integer('troopID')->nullable();
            $table->integer('crewID')->nullable();
            $table->string('name');
            $table->text('description');
            $table->integer('heldInDistrict');
            $table->string('uploadedDoc', 1000)->nullable()->comment('Location Of The Uploaded Doc');
            $table->string('locationName');
            $table->text('locationAddress');
            $table->string('locationLat')->nullable();
            $table->string('locationLon')->nullable();
            $table->date('startDate');
            $table->string('startTime', 15);
            $table->date('endDate');
            $table->string('endTime', 15);
            $table->integer('scouterResponsible');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->decimal('costPerPerson', 7)->nullable();
            $table->string('costPerPersonPer')->nullable();
            $table->integer('nightUnderCanvas')->nullable();
            $table->decimal('kmHike', 4, 1)->nullable();
            $table->integer('eventTypeID');
            $table->string('permitDocLocation')->nullable();
            $table->string('uniqueID', 100)->index('uniqueID');
            $table->integer('eventPSPin');
            $table->integer('eventTSPin');
            $table->integer('eventSGLPin');
            $table->integer('eventDCPin');
            $table->integer('eventOtherDCPin');
            $table->integer('active');
            $table->integer('approved')->default(1);
            $table->string('planningDoc')->nullable();
            $table->string('marketingDoc', 1024)->nullable();
            $table->integer('competition')->default(0);
            $table->decimal('competitionScoringFactor', 11, 8)->default(1);
            $table->integer('addedIn')->default(1);
            $table->integer('bookingPossible')->default(0);
            $table->date('latestBookingDate')->nullable();
            $table->integer('maxNrOfBookings')->default(0);
            $table->string('managementEmail')->nullable();
            $table->integer('depositRequired')->default(0);
            $table->date('depositRequiredDate')->nullable();
            $table->date('paymentInFullByDate')->nullable();
            $table->text('travelArrangements')->nullable();
            $table->integer('bookingLive')->default(0);
            $table->string('bankName')->nullable();
            $table->string('bankAccountName')->nullable();
            $table->string('bankBranch')->nullable();
            $table->string('bankCode')->nullable();
            $table->string('bankAccountNumber')->nullable();
            $table->string('BAReferenceStart', 6)->nullable();
            $table->integer('startAge')->nullable();
            $table->integer('endAge')->nullable();
            $table->integer('GPSTrackingRequired')->default(0);
            $table->integer('noCopy')->default(0);
            $table->string('surveyURL')->nullable();
            $table->string('leaderboardURL')->nullable();
            $table->string('calendarURL')->nullable();

            $table->index(['assocToRegion', 'countryID', 'active', 'endDate', 'eventFor'], 'assocToRegion');
            $table->index(['assocToDistrict', 'countryID', 'active', 'endDate', 'eventFor'], 'assocToDistrict');
            $table->index(['assocToGroup', 'countryID', 'active', 'endDate'], 'assocToGroup');
            $table->index(['bookingPossible', 'active'], 'bookingPossible');
            $table->index(['countryID', 'nationalEvent', 'active', 'endDate', 'eventFor'], 'countryID');
            $table->index(['competition', 'active', 'noCopy', 'id'], 'competition');
        });

        Schema::create('group_events_attending', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('groupID');
            $table->integer('eventID');
            $table->integer('userID')->default(0);
            $table->integer('roleID');
            $table->integer('attending')->comment('0 = Not Attending, 1 = Attending, 2 = Maybe Attending');
            $table->decimal('cost', 10)->nullable()->default(0);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['eventID', 'groupID', 'roleID', 'active'], 'eventID');
            $table->index(['groupID', 'eventID', 'userID', 'active'], 'groupID');
            $table->index(['groupID', 'eventID', 'attending', 'active'], 'assocToGroup');
        });

        Schema::create('group_financial_annual_invoice_discounts', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup')->index('assocToGroup');
            $table->integer('accountID');
            $table->string('description');
            $table->decimal('amount', 10);
            $table->integer('amountIncludesVAT')->comment('1 = Yes');
            $table->integer('financialYear');
            $table->integer('active')->comment('1 = active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['accountID', 'financialYear', 'active'], 'accountID');
        });

        Schema::create('group_financial_credit_notes', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('invoiceID')->nullable();
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup');
            $table->integer('accountID');
            $table->integer('financialYearID');
            $table->string('PDFLocation')->nullable();
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToGroup', 'accountID', 'active'], 'assocToGroup');
        });

        Schema::create('group_financial_credit_notes_items', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('invoiceID')->nullable();
            $table->integer('creditNoteID');
            $table->integer('assocToGroup');
            $table->integer('accountID');
            $table->integer('financialYearID');
            $table->string('feeArea')->nullable();
            $table->string('name')->nullable();
            $table->string('description');
            $table->decimal('amount', 10);
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('group_financial_fee_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup');
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('canBeProrated')->comment('1 = Yes');
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('group_financial_fees', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup');
            $table->integer('financialYearID');
            $table->integer('feeTypeID');
            $table->decimal('feeAmount', 10);
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToGroup', 'active'], 'assocToGroup');
        });

        Schema::create('group_financial_invoices', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup');
            $table->integer('accountID');
            $table->integer('financialYearID');
            $table->date('dueDate');
            $table->integer('annualInvoice')->default(0);
            $table->string('PDFLocation')->nullable();
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToGroup', 'accountID', 'active', 'financialYearID'], 'assocToGroup');
        });

        Schema::create('group_financial_invoices_emailed', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup');
            $table->integer('accountID');
            $table->integer('financialYearID');
            $table->integer('invoiceID');
            $table->dateTime('sentDate');
            $table->dateTime('created');
            $table->integer('createdby');
        });

        Schema::create('group_financial_invoices_items', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('invoiceID');
            $table->integer('assocToGroup')->index('assocToGroup');
            $table->integer('accountID');
            $table->integer('financialYearID');
            $table->string('feeArea');
            $table->string('name');
            $table->string('description');
            $table->decimal('amount', 10);
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('group_financial_payments_made', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('invoiceID')->default(0);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup');
            $table->integer('accountID');
            $table->decimal('amount', 10);
            $table->date('payment_date');
            $table->integer('paymentType')->default(1)->comment('1 = Group Captured, 2 = From Wallet');
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToGroup', 'paymentType', 'active'], 'assocToGroup');
            $table->index(['assocToGroup', 'accountID', 'active'], 'assocToGroup_2');
        });

        Schema::create('group_financial_years', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup')->index('assocToGroup');
            $table->date('startDate');
            $table->date('endDate');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('group_meerkat_dens', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('assocToGroup');
            $table->string('name');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToGroup', 'active'], 'assocToGroup');
        });

        Schema::create('group_meerkats_patrol_names', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup')->index('assocToGroup');
            $table->integer('packID');
            $table->string('name');
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
        });

        Schema::create('group_newsletters', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->nullable()->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup');
            $table->date('newsletterDate');
            $table->string('newsletterTitle');
            $table->string('uploadedFile');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToGroup', 'active'], 'assocToGroup');
        });

        Schema::create('group_parents_committee_minutes', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup');
            $table->date('newsletterDate');
            $table->string('newsletterTitle');
            $table->string('uploadedFile');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('group_programs', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup');
            $table->string('programAreaName', 100)->nullable();
            $table->integer('multiID')->default(0);
            $table->integer('denID')->default(0);
            $table->integer('packID')->nullable()->default(0);
            $table->integer('troopID')->nullable()->default(0);
            $table->integer('crewID')->default(0);
            $table->integer('programType');
            $table->integer('meerkatProgramTypeID')->default(0);
            $table->integer('cubProgramTypeID')->default(0);
            $table->integer('scoutProgramTypeID')->default(1);
            $table->integer('roverProgramTypeID')->nullable()->default(0);
            $table->integer('responsibleScouter')->nullable();
            $table->integer('dutyPatrol')->nullable()->default(0);
            $table->string('title');
            $table->text('description');
            $table->date('date')->index('date');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->string('document')->nullable();
            $table->integer('active')->comment('1 = active');
            $table->integer('shared')->default(0);
            $table->integer('sharedby')->nullable();
            $table->date('sharedDate')->nullable();
            $table->integer('roverProgramType')->nullable();
            $table->integer('online')->default(0);
            $table->integer('onlineActive')->default(0);
            $table->date('onlineEndDate')->nullable();

            $table->index(['assocToGroup', 'online', 'active', 'date', 'onlineEndDate'], 'assocToGroup_2');
            $table->index(['programType', 'date', 'assocToGroup', 'active'], 'programType_2');
            $table->index(['assocToGroup', 'active', 'date', 'programType'], 'assocToGroup');
            $table->index(['programType', 'assocToGroup', 'active', 'date'], 'programType');
        });

        Schema::create('group_programs_documents', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programID');
            $table->text('name');
            $table->string('PDFLocation', 1024);
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['programID', 'active'], 'programID');
        });

        Schema::create('group_programs_online_tasks', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programID');
            $table->integer('position')->index('position');
            $table->text('task');
            $table->text('needs')->nullable();
            $table->text('description');
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('advancementID')->nullable();
            $table->integer('badgeID')->nullable();
            $table->integer('points')->nullable()->default(0);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['programID', 'active'], 'programID');
        });

        Schema::create('group_programs_online_tasks_completion', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programID');
            $table->integer('taskID');
            $table->integer('userID');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['programID', 'taskID', 'userID', 'active'], 'programID');
            $table->index(['userID', 'active', 'programID', 'taskID'], 'userID');
        });

        Schema::create('group_programs_online_tasks_documents', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programID');
            $table->integer('taskID');
            $table->integer('userID');
            $table->text('description')->nullable();
            $table->string('location', 1024);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['programID', 'taskID', 'userID', 'active'], 'programID');
            $table->index(['userID', 'active', 'programID', 'taskID'], 'userID');
        });

        Schema::create('group_programs_online_tasks_images', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programID');
            $table->integer('taskID');
            $table->integer('userID');
            $table->text('description')->nullable();
            $table->string('location', 1024);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['programID', 'taskID', 'userID', 'active'], 'programID');
            $table->index(['userID', 'active', 'programID', 'taskID'], 'userID');
        });

        Schema::create('group_programs_online_tasks_notes', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programID');
            $table->integer('taskID');
            $table->integer('userID');
            $table->text('note');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['programID', 'taskID', 'userID', 'active'], 'programID');
            $table->index(['userID', 'active', 'programID', 'taskID'], 'userID');
        });

        Schema::create('group_programs_online_tasks_penalty', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programID');
            $table->integer('taskID');
            $table->integer('userID');
            $table->integer('penalty');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['programID', 'taskID', 'userID', 'active'], 'programID');
            $table->index(['userID', 'active', 'programID', 'taskID'], 'userID');
        });

        Schema::create('group_programs_online_working_on', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programID');
            $table->integer('userID');
            $table->dateTime('created')->index('created');
            $table->integer('createdby');

            $table->index(['programID', 'userID'], 'programID');
            $table->index(['userID', 'programID'], 'userID');
        });

        Schema::create('group_rover_crews', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup');
            $table->string('name');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('group_rovers_patrol_names', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup')->index('assocToGroup');
            $table->integer('crewID');
            $table->string('name');
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
        });

        Schema::create('group_scout_troops', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup');
            $table->string('name');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToGroup', 'active'], 'assocToGroup');
        });

        Schema::create('group_scouts_charges', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion');
            $table->integer('assocToDistrict');
            $table->integer('assocToGroup');
            $table->integer('scoutID');
            $table->integer('chargeID');
            $table->string('chargeNr');
            $table->date('awardDate');
            $table->date('expireDate');
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('group_scouts_patrol_names', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup');
            $table->integer('troopID');
            $table->string('name');
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');

            $table->index(['assocToGroup', 'active'], 'assocToGroup');
        });

        Schema::create('group_send_logon_details', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->dateTime('created');
            $table->integer('createdby');
        });

        Schema::create('group_star_awards', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID');
            $table->integer('regionID');
            $table->integer('districtID');
            $table->integer('groupID');
            $table->integer('year');
            $table->integer('area');
            $table->integer('multiID');
            $table->integer('awardID');
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['districtID', 'active'], 'districtID');
            $table->index(['groupID', 'active'], 'groupID');
            $table->index(['countryID', 'active'], 'countryID');
            $table->index(['regionID', 'active'], 'regionID');
        });

        Schema::create('group_user_picture_changes', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->index('userID');
            $table->text('pictureLocation');
            $table->dateTime('created');
            $table->integer('createdby');
        });

        Schema::create('group_weekly_emails_emailed', static function (Blueprint $table) {
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

        Schema::create('group_youth_charges', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('type', 12);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion');
            $table->integer('assocToDistrict');
            $table->integer('assocToGroup');
            $table->integer('userID');
            $table->integer('chargeTypeID');
            $table->string('chargeNr');
            $table->date('awardDate');
            $table->date('expireDate');
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('groups', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->integer('sdLiteOnly')->default(0);
            $table->integer('usesGoScan')->nullable()->default(0);
            $table->integer('usesShop')->default(0);
            $table->integer('usesPayFees')->default(0);
            $table->integer('groupAccountID')->default(0);
            $table->string('scarf')->nullable();
            $table->integer('groupTypeID');
            $table->text('description')->nullable();
            $table->integer('multiDen')->default(0);
            $table->integer('multiPack')->default(0);
            $table->integer('multiTroop')->default(0);
            $table->integer('multiCrew')->default(0);
            $table->integer('meerkatProgramType')->default(1);
            $table->integer('cubProgramType')->default(1);
            $table->integer('scoutProgramType')->default(2)->comment('1 = Normal Scout Program, 2 = Entsha Scout Program');
            $table->integer('roverProgramType')->default(1);
            $table->integer('amsOnly')->default(0)->comment('1 = Yes, 0 = No');
            $table->integer('hasMeerkats')->default(0);
            $table->integer('hasCubs')->nullable()->default(1)->comment('1 = Yes');
            $table->integer('hasScouts')->nullable()->default(1)->comment('1 = Yes');
            $table->integer('hasRovers')->nullable()->default(0)->comment('1 = Yes');
            $table->integer('hasBranch1')->default(0);
            $table->integer('hasBranch2')->default(0);
            $table->integer('hasBranch3')->default(0);
            $table->integer('hasBranch4')->default(0);
            $table->integer('hasBranch5')->default(0);
            $table->integer('sendWeeklyMails')->default(0);
            $table->integer('assoc_to_district');
            $table->integer('assoc_to_region');
            $table->integer('roverAssocToGroup')->nullable()->default(0);
            $table->text('phys_address')->nullable();
            $table->text('postalAddress')->nullable();
            $table->integer('postalCountryID')->nullable()->default(196);
            $table->integer('phys_country_id')->nullable()->default(196);
            $table->text('bankingDetails')->nullable();
            $table->string('bankAccountName')->nullable();
            $table->string('bankName')->nullable();
            $table->string('branchName')->nullable();
            $table->string('branchCode')->nullable();
            $table->string('bankAccountNumber')->nullable();
            $table->text('invoiceNotes')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('googleplus')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('pintrest')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tumblr')->nullable();
            $table->string('googleMaps')->nullable();
            $table->string('gpsLat')->nullable();
            $table->string('gpsLon')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('active')->comment('1 = Active');
            $table->string('weatherID', 25)->nullable();
            $table->string('weatherLocationName')->nullable();
            $table->integer('managedRegionally')->default(0)->comment('1 = Yrs, 0 = No');
            $table->integer('canMoveToEntsha')->default(1);
            $table->integer('using20')->default(1);
            $table->string('groupRegNr', 25)->nullable();
            $table->integer('censusDone')->nullable();
            $table->dateTime('groupLastUpdated')->nullable();
            $table->integer('groupLastUpdatedBy')->nullable();

            $table->index(['roverAssocToGroup', 'active'], 'roverAssocToGroup');
            $table->index(['active', 'phys_country_id', 'managedRegionally'], 'active_3');
            $table->index(['assoc_to_district', 'active', 'groupTypeID'], 'assoc_to_district');
            $table->index(['phys_country_id', 'active', 'groupTypeID'], 'phys_country_id');
            $table->index(['active', 'assoc_to_district', 'assoc_to_region'], 'active');
            $table->index(['assoc_to_region', 'active', 'groupTypeID'], 'active_2');
        });

        Schema::create('groups_entsha_move', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID');
            $table->integer('regionID')->index('regionID');
            $table->integer('districtID')->index('districtID');
            $table->integer('groupID')->index('groupID');
            $table->dateTime('created');
            $table->integer('createdby');
        });

        Schema::create('groups_multi', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('type', 15);
            $table->integer('groupID');
            $table->string('name');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['groupID', 'type', 'active'], 'groupID');
        });

        Schema::create('groups_property', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('groupID')->index('groupID');
            $table->integer('districtID')->index('districtID');
            $table->integer('regionID')->index('regionID');
            $table->integer('countryID')->default(196)->index('countryID');
            $table->integer('ownedRented')->nullable()->comment('1 = Owned, 2 = Rented');
            $table->string('landlordName')->nullable();
            $table->string('landlordContactPerson')->nullable();
            $table->string('landlordContactPersonCell', 25)->nullable();
            $table->string('landlordContactPersonEmail')->nullable();
            $table->text('propertyDescription')->nullable();
            $table->string('ERFno', 1024)->nullable();
            $table->string('ERFSize', 10)->nullable();
            $table->integer('propertyValuation')->nullable();
            $table->date('lastValuationDate')->nullable();
            $table->integer('improvementValue')->nullable();
            $table->date('leaseStartDate')->nullable();
            $table->date('leaseEndDate')->nullable();
            $table->date('leaseRenewalDate')->nullable();
            $table->text('leaseConditions')->nullable();
            $table->text('improvementsDescription')->nullable();
            $table->integer('monthlyRentalAmount')->nullable();
            $table->integer('monthlyRates')->nullable();
            $table->integer('monthlyElectricity')->nullable();
            $table->integer('monthlyWaterSewerage')->nullable();
            $table->string('insuranceCompany')->nullable();
            $table->string('insuranceContactPerson')->nullable();
            $table->string('insuranceContactPersonEmail', 100)->nullable();
            $table->string('insuranceContactPersonCell', 15)->nullable();
            $table->integer('insuranceValue')->nullable();
            $table->text('insuranceDetails')->nullable();
            $table->text('groupNotes')->nullable();
            $table->dateTime('created')->nullable();
            $table->integer('createdby')->nullable();
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('groups_property_ownership_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->integer('owned')->default(0);
            $table->integer('rented')->default(0);
            $table->integer('active')->default(1);
        });

        Schema::create('groups_property_updates', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('groupID')->index('groupID');
            $table->integer('updatedby');
            $table->dateTime('updatedDate');
        });

        Schema::create('groups_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->text('description');
        });

        Schema::create('info_sharing', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('region');
            $table->integer('type')->comment('1 = Hiking, 2 = Camping, 3 = Supplier');
            $table->string('name');
            $table->text('description');
            $table->string('contactPerson');
            $table->string('email')->nullable();
            $table->string('tel')->nullable();
            $table->string('website')->nullable();
            $table->text('address');
            $table->string('gpsLat', 100)->nullable();
            $table->string('gpsLon', 100)->nullable();
            $table->integer('active');
            $table->integer('approved')->default(0);
            $table->integer('approvedby')->nullable();
            $table->dateTime('approvedDate')->nullable();
            $table->integer('declined')->default(0);
            $table->integer('declinedby')->nullable();
            $table->dateTime('declinedDate')->nullable();
            $table->string('declinedReason', 1024)->nullable();
            $table->text('declinedNotes')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['active', 'approved'], 'active');
            $table->index(['type', 'active', 'approved'], 'type');
        });

        Schema::create('info_sharing_likes', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('infoID');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');

            $table->index(['infoID', 'active'], 'infoID');
            $table->index(['createdby', 'active'], 'createdby');
        });

        Schema::create('info_sharing_reviews', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('infoID');
            $table->string('title');
            $table->text('review');
            $table->integer('stars')->nullable();
            $table->integer('active');
            $table->integer('approved')->default(0);
            $table->integer('declined')->default(0);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->integer('approvedby')->nullable();
            $table->dateTime('approvedDate')->nullable();
            $table->dateTime('declinedDate')->nullable();
            $table->integer('declinedby')->nullable();
            $table->string('declineReason', 1024)->nullable();
            $table->text('declinedNotes')->nullable();

            $table->index(['createdby', 'active', 'approved'], 'createdby');
            $table->index(['infoID', 'active', 'approved'], 'infoID');
        });

        Schema::create('info_sharing_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->integer('active');
        });

        Schema::create('jamboree_activity_center_bases', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('centerID');
            $table->string('name');
            $table->integer('active');
            $table->integer('concurrentPatrols');
            $table->decimal('hoursLong', 2, 1);
            $table->integer('slots');
        });

        Schema::create('jamboree_activity_centers', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->string('name');
            $table->integer('active');
        });

        Schema::create('jamboree_adult_allocations', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->integer('subCampID')->default(0);
            $table->integer('activityCenterID')->default(0);
            $table->integer('baseID')->default(0);
            $table->integer('roleID');
            $table->integer('userID');
            $table->text('notes')->nullable();
            $table->integer('active');
            $table->integer('position')->nullable()->default(0);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('jamboree_adult_roles', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->string('name');
            $table->integer('active');
            $table->integer('position');
        });

        Schema::create('jamboree_application', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->index('userID');
            $table->integer('active')->default(1);
            $table->integer('jamboreeID');
            $table->string('jamboreeNumber', 4)->nullable();
            $table->integer('stepComplete')->default(0);
            $table->dateTime('step1Complete')->nullable();
            $table->dateTime('step2Complete')->nullable();
            $table->dateTime('step3Complete')->nullable();
            $table->dateTime('step4Complete')->nullable();
            $table->dateTime('step5Complete')->nullable();
            $table->dateTime('step6Complete')->nullable();
            $table->dateTime('step7Complete')->nullable();
            $table->dateTime('step8Complete')->nullable();
            $table->text('step1notes')->nullable();
            $table->text('step2notes')->nullable();
            $table->text('step3notes')->nullable();
            $table->text('step4notes')->nullable();
            $table->text('step5notes')->nullable();
            $table->text('step6notes')->nullable();
            $table->text('step7notes')->nullable();
            $table->text('step8notes')->nullable();
            $table->string('currentGrade', 3)->nullable();
            $table->string('advancementLevel')->nullable();
            $table->string('pltuAttendedYear')->nullable();
            $table->text('trainingAttended')->nullable();
            $table->text('previousNational')->nullable();
            $table->string('jamboreeAttended', 3)->nullable();
            $table->string('jamboreeYear', 4)->nullable();
            $table->string('capSize', 25)->nullable();
            $table->string('tShirtSize', 25)->nullable();
            $table->string('golfShirtSize', 25)->nullable();
            $table->integer('busRegionID')->nullable();
            $table->integer('TravelingWithChildren')->default(0);
            $table->integer('completed')->default(0);
            $table->integer('gpsCheckDone')->nullable();
            $table->string('ConsentLocation', 1024)->nullable();
            $table->string('busInvoiceLocation')->nullable();
            $table->integer('applicationApproved')->nullable();
            $table->dateTime('applicationApprovedDate')->nullable();
            $table->integer('applicationApprovedBy')->nullable();
            $table->integer('declinedPosition')->nullable();
            $table->dateTime('declinedPositionDate')->nullable();
            $table->integer('declinedPositionBy')->nullable();
            $table->text('declinedReason')->nullable();
            $table->integer('passportGenerated')->nullable();
            $table->date('startDate')->default('2017-12-08');
            $table->date('endDate')->default('2017-12-16');
            $table->integer('nrOfDays')->default(8);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(2);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['active', 'completed', 'passportGenerated'], 'active');
            $table->index(['jamboreeID', 'active', 'completed'], 'jamboreeID');
        });

        Schema::create('jamboree_beds', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('subcampID');
            $table->integer('type')->comment('1 = Adults, 2 = Kids');
            $table->string('name');
            $table->integer('nrBeds');
        });

        Schema::create('jamboree_beds_allocations', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('subcampID');
            $table->integer('troopID');
            $table->integer('patrolID');
            $table->integer('bedID');
            $table->integer('active')->default(1);

            $table->index(['patrolID', 'active'], 'subcampID');
        });

        Schema::create('jamboree_bus_info', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID')->default(0);
            $table->integer('regionID');
            $table->string('provider');
            $table->decimal('totalBusCost', 10)->nullable();
            $table->decimal('perSeatInvoiceAmountExVAT', 6)->nullable()->default(0);
            $table->string('busNr')->nullable();
            $table->integer('availableSeats');
            $table->string('departureLocation');
            $table->date('departureDate');
            $table->string('departureTime');
            $table->string('arrivalLocation')->nullable();
            $table->date('arrivalDate')->nullable();
            $table->string('arrivalTime', 100)->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('jamboree_buses_users', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->integer('userID');
            $table->integer('busID');
            $table->text('notes')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['jamboreeID', 'active'], 'jamboreeID');
        });

        Schema::create('jamboree_core_team', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID')->default(2);
            $table->integer('userID');
            $table->integer('canAdmin')->default(0);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
        });

        Schema::create('jamboree_eoi', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->integer('userID');
            $table->integer('roleID');
            $table->integer('countryID');
            $table->integer('regionID');
            $table->integer('districtID');
            $table->integer('groupID');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('jamboree_expr_of_interest', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID')->default(1);
            $table->integer('countryID')->default(196)->index('countryID');
            $table->integer('regionID');
            $table->integer('districtID');
            $table->integer('groupID');
            $table->integer('userID');
            $table->integer('parentID')->nullable();
            $table->integer('positionID')->index('positionID');
            $table->integer('passportCountryID')->nullable()->default(0);
            $table->integer('passportCheck')->nullable()->default(0);
            $table->text('notes');
            $table->dateTime('created');
            $table->integer('active')->default(1);
            $table->integer('offeredPosition')->nullable();
            $table->dateTime('offeredPositionDate')->nullable();
            $table->integer('offeredPositionBy')->nullable();
            $table->integer('declinedPosition')->nullable();
            $table->dateTime('declinedPositionDate')->nullable();
            $table->integer('declinedPositionBy')->nullable();
            $table->text('declinedReason')->nullable();

            $table->index(['jamboreeID', 'active'], 'jamboreeID');
        });

        Schema::create('jamboree_generated_pdfs', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->integer('subCampID')->default(0);
            $table->integer('troopID')->default(0);
            $table->integer('busID')->default(0);
            $table->integer('userID')->default(0);
            $table->string('type')->default('0');
            $table->string('PDFLocation');
            $table->dateTime('created');
            $table->integer('createdby');
        });

        Schema::create('jamboree_info', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID');
            $table->integer('year');
            $table->string('currency', 10);
            $table->decimal('scoutCostExVAT', 6);
            $table->decimal('adultCostExVAT', 6);
            $table->decimal('kidCostExVAT', 6);
            $table->decimal('busDepositExVAT', 6);
            $table->integer('depositPercent');
            $table->integer('active');
        });

        Schema::create('jamboree_initial_thoughts', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID')->default(2);
            $table->integer('userID');
            $table->text('thought');
            $table->integer('active');
            $table->dateTime('created');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('jamboree_invoices', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('userID');
            $table->decimal('invoiceAmountExVat')->nullable();
            $table->decimal('invoiceVATAmount')->nullable();
            $table->decimal('invoiceTotalAmount')->nullable();
            $table->date('dueDate');
            $table->string('PDFLocation')->nullable();
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('jamboree_invoices_items', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('invoiceID')->index('invoiceID');
            $table->integer('applicantID');
            $table->string('description');
            $table->integer('number');
            $table->decimal('unitAmount');
            $table->decimal('totalAmount', 10);
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('jamboree_patrols', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->integer('troopID');
            $table->string('name', 100);
            $table->integer('active');
        });

        Schema::create('jamboree_payment_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->string('name');
        });

        Schema::create('jamboree_payments', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->integer('userID');
            $table->integer('paymentType');
            $table->decimal('amount', 10);
            $table->date('paymentDate');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->text('notes')->nullable();

            $table->index(['jamboreeID', 'active'], 'jamboreeID_2');
            $table->index(['jamboreeID', 'userID', 'active'], 'jamboreeID');
        });

        Schema::create('jamboree_position_offered', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('regionID');
            $table->integer('districtID');
            $table->integer('groupID');
            $table->integer('userID');
            $table->integer('parentID')->nullable();
            $table->integer('positionID');
            $table->integer('passportCountryID');
            $table->integer('passportCheck');
            $table->text('notes');
            $table->dateTime('created');
            $table->integer('offeredPosition')->nullable();
            $table->dateTime('offeredPositionDate')->nullable();
            $table->integer('offeredPositionBy')->nullable();
        });

        Schema::create('jamboree_scouters', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->index('userID');
            $table->string('scouterPosition');
            $table->string('scouterFirst');
            $table->string('scouterSurname');
            $table->string('scouterEmail', 25);
            $table->string('scouterCellNr');
        });

        Schema::create('jamboree_sub_camp_troop_allocations', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->integer('subCampID');
            $table->integer('troopID');
            $table->integer('active');
        });

        Schema::create('jamboree_sub_camps', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->string('name');
            $table->integer('active');
        });

        Schema::create('jamboree_troop_patrol_allocations', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('troopID');
            $table->integer('patrolID')->nullable();
            $table->integer('roleID');
            $table->integer('active')->default(1);
            $table->text('notes')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['troopID', 'roleID', 'active'], 'troopID');
        });

        Schema::create('jamboree_troops', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->string('name');
            $table->integer('subCampID')->nullable();
            $table->string('colour', 25);
            $table->integer('active')->default(1);
        });

        Schema::create('national', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->integer('countryID');
            $table->integer('active')->nullable()->default(0);
        });

        Schema::create('notifications', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('groupID');
            $table->integer('districtID');
            $table->integer('regionID');
            $table->integer('countryID');
            $table->string('title');
            $table->string('description');
            $table->text('extended');
            $table->string('colour', 100)->comment('colours are teal, amethyst, ruby, tangerine, lemon, lime, ebony, smoke');
            $table->integer('active')->default(1);
            $table->date('doNotShowBefore');
            $table->date('doNotShowAfter');
            $table->integer('forType')->comment('1 = Group, 2 = District, 3 = Region, 4 = National');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->integer('shown')->default(0);
            $table->dateTime('dismissDate')->nullable();

            $table->index(['userID', 'active', 'shown', 'doNotShowBefore', 'doNotShowAfter'], 'userID_2');
        });

        Schema::create('notifications_archive', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('groupID');
            $table->integer('districtID');
            $table->integer('regionID');
            $table->integer('countryID');
            $table->string('title');
            $table->string('description');
            $table->text('extended');
            $table->string('colour', 100)->comment('colours are teal, amethyst, ruby, tangerine, lemon, lime, ebony, smoke');
            $table->integer('active')->default(1);
            $table->date('doNotShowBefore');
            $table->date('doNotShowAfter');
            $table->integer('forType')->comment('1 = Group, 2 = District, 3 = Region, 4 = National');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->integer('shown')->default(0);
            $table->dateTime('dismissDate')->nullable();
        });

        Schema::create('payment_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
        });

        Schema::create('projects', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('projectForID');
            $table->integer('countryID')->default(0);
            $table->integer('regionID')->default(0);
            $table->integer('districtID')->default(0);
            $table->integer('groupID')->default(0);
            $table->integer('typeID');
            $table->string('name', 1024);
            $table->text('description');
            $table->text('aim');
            $table->date('startDate');
            $table->date('endDate')->nullable();
            $table->string('document')->nullable();
            $table->string('contactPerson');
            $table->string('contactEmail')->nullable();
            $table->string('contactCell')->nullable();
            $table->string('contactWebsite', 1024)->nullable();
            $table->integer('active');
            $table->integer('approved')->nullable()->default(0);
            $table->integer('approvedby')->nullable();
            $table->dateTime('approveddate')->nullable();
            $table->integer('declined')->nullable()->default(0);
            $table->integer('declinedby')->nullable();
            $table->dateTime('declineddate')->nullable();
            $table->text('declinedReason')->nullable();
            $table->text('declinedNotes')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['regionID', 'active', 'approved'], 'regionID');
            $table->index(['groupID', 'active', 'approved'], 'groupID');
            $table->index(['districtID', 'active', 'approved'], 'districtID');
            $table->index(['countryID', 'active', 'approved'], 'countryID');
            $table->index(['countryID', 'active', 'approved', 'typeID'], 'countryID_2');
        });

        Schema::create('projects_for', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->integer('active')->default(1)->index('active');
        });

        Schema::create('projects_supported', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('projectID');
            $table->integer('countryID')->default(0);
            $table->integer('regionID')->default(0);
            $table->integer('districtID')->default(0);
            $table->integer('groupID')->default(0);
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['projectID', 'active'], 'projectID');
            $table->index(['projectID', 'createdby'], 'projectID_2');
        });

        Schema::create('regions', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('position')->default(0);
            $table->string('name');
            $table->string('short', 3)->nullable();
            $table->integer('usingAMS')->default(0)->comment('1 = Yes, 0 = No');
            $table->text('description');
            $table->text('phys_address');
            $table->integer('countryID');
            $table->integer('active')->default(1);
            $table->integer('accountID')->default(0);
            $table->integer('censusDone')->default(1);

            $table->index(['countryID', 'active'], 'phys_country_id');
        });

        Schema::create('reports_numbers', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion');
            $table->integer('assocToDistrict');
            $table->integer('assocToGroup');
            $table->date('month');
            $table->integer('meerkatsM')->default(0);
            $table->integer('meerkatsF')->default(0);
            $table->integer('cubsM')->nullable()->default(0);
            $table->integer('cubsF')->nullable()->default(0);
            $table->integer('scoutsM')->nullable()->default(0);
            $table->integer('scoutsF')->nullable()->default(0);
            $table->integer('roversM')->nullable()->default(0);
            $table->integer('roversF')->nullable()->default(0);
            $table->integer('adultsDenM')->default(0);
            $table->integer('adultsDenF')->default(0);
            $table->integer('adultsPackM')->nullable()->default(0);
            $table->integer('adultsPackF')->nullable()->default(0);
            $table->integer('adultsTroopM')->nullable()->default(0);
            $table->integer('adultsTroopF')->nullable()->default(0);
            $table->integer('adultsCrewM')->default(0);
            $table->integer('adultsCrewF')->default(0);
            $table->integer('adultsGroupM')->nullable()->default(0);
            $table->integer('adultsGroupF')->nullable()->default(0);
            $table->integer('committee')->nullable()->default(0);
            $table->integer('helpers')->nullable()->default(0);
            $table->dateTime('created');

            $table->index(['month', 'assocToRegion'], 'assocToDistrict');
            $table->index(['month', 'countryID'], 'assocToRegion');
            $table->index(['month', 'assocToGroup'], 'month');
            $table->index(['month', 'assocToDistrict'], 'assocToGroup');
        });

        Schema::create('scouter_reviews', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('countryID');
            $table->integer('regionID');
            $table->integer('districtID');
            $table->integer('groupID');
            $table->integer('roleID');
            $table->text('review');
            $table->string('reviewedFor');
            $table->integer('stars');
            $table->integer('active');
            $table->integer('approved')->default(0);
            $table->integer('approvedby')->nullable();
            $table->dateTime('approvedDate')->nullable();
            $table->integer('declined')->default(0);
            $table->integer('declinedby')->nullable();
            $table->dateTime('declinedDate')->nullable();
            $table->text('declinedReason')->nullable();
            $table->text('declinedNotes')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['userID', 'active', 'approved'], 'userID');
            $table->index(['active', 'approved', 'declined'], 'active');
            $table->index(['districtID', 'active', 'approved'], 'districtID');
            $table->index(['regionID', 'active', 'approved'], 'regionID');
            $table->index(['countryID', 'active', 'approved'], 'countryID');
            $table->index(['groupID', 'active', 'approved'], 'groupID');
        });

        Schema::create('scouter_reviews_likes', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('reviewID');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');

            $table->index(['reviewID', 'active'], 'infoID');
            $table->index(['createdby', 'active'], 'createdby');
        });

        Schema::create('sd_article_cats', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->string('slug');
        });

        Schema::create('sd_articles', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('catID')->index('catID');
            $table->integer('groupID')->nullable()->default(0);
            $table->string('title')->fulltext('title');
            $table->string('slug');
            $table->text('intro')->fulltext('intro');
            $table->text('article')->fulltext('article');
            $table->integer('active')->index('active');
            $table->dateTime('created');
            $table->string('createdby');
            $table->integer('views')->default(0);
        });

        Schema::create('services_purchased', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('emailAddress');
            $table->string('paymentType');
            $table->decimal('amountInclVAT', 10);
            $table->text('serviceName');
            $table->text('productDescription');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('processed')->default(0);
            $table->dateTime('processedDate')->nullable();
            $table->integer('cancelled')->default(0);
            $table->dateTime('cancelledDate')->nullable();
            $table->integer('groupID')->nullable();
            $table->dateTime('associatedToGroupDate')->nullable();
            $table->integer('associatedToGroupBy')->nullable();
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();

            $table->index(['groupID', 'active', 'processed', 'endDate'], 'groupID_2');
            $table->index(['groupID', 'serviceName', 'active', 'processed'], 'groupID');
            $table->index(['processed', 'groupID', 'active'], 'processed');
            $table->index(['emailAddress', 'serviceName', 'active', 'processed'], 'emailAddress');
        });

        Schema::create('services_purchased_spreadsheets_received', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('groupID');
            $table->dateTime('receivedDate');
            $table->string('location', 1024);
            $table->integer('addedBy');
            $table->integer('active');

            $table->index(['groupID', 'active'], 'groupID');
        });

        Schema::create('services_purchased_spreadsheets_sent', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('groupID');
            $table->dateTime('dateSent');
            $table->integer('sentBy');
            $table->integer('active');

            $table->index(['groupID', 'active'], 'groupID');
        });

        Schema::create('star_awards', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('year');
            $table->integer('countryID');
            $table->integer('regionID');
            $table->integer('districtID');
            $table->integer('groupID');
            $table->integer('denID')->nullable();
            $table->integer('packID')->nullable();
            $table->integer('troopID')->nullable();
            $table->integer('patrolID')->nullable();
            $table->integer('crewID')->nullable();
            $table->string('scouterAskedAward', 25)->nullable();
            $table->dateTime('scouterAskedAwardDate')->nullable();
            $table->integer('scouterAskedAwardUserID')->nullable();
            $table->text('scouterMotivation')->nullable();
            $table->string('nptmRecommended', 25)->nullable();
            $table->dateTime('nptmAskedAwardDate')->nullable();
            $table->integer('nptmAskedAwardUserID')->nullable();
            $table->text('nptmMotivation')->nullable();
            $table->string('rtcRecommended', 25)->nullable();
            $table->dateTime('rtcRecommendedDate')->nullable();
            $table->integer('rtcRecommendedUserID')->nullable();
            $table->text('rtcMotivation')->nullable();
            $table->integer('chairAwarded')->nullable();
            $table->dateTime('chairAwardedDate')->nullable();
            $table->integer('chairAwardedUserID')->nullable();
            $table->integer('active');

            $table->index(['groupID', 'year', 'active'], 'groupID');
        });

        Schema::create('star_awards_notes', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('groupID');
            $table->integer('denID')->nullable();
            $table->integer('packID')->nullable();
            $table->integer('troopID')->nullable();
            $table->integer('patrolID')->nullable();
            $table->integer('crewID')->nullable();
            $table->integer('noteType')->comment('1 = Group, 2 = District, 3 - Region, 4 = National');
            $table->text('note');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['groupID', 'active', 'noteType', 'created'], 'groupID');
        });

        Schema::create('support_chats', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('supportID');
            $table->integer('userID');
            $table->integer('direction')->comment('1 = From User, 2 = From Admin');
            $table->text('chat');
            $table->dateTime('created');
            $table->integer('active');
        });

        Schema::create('support_chats_standard_answers', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('answer');
            $table->integer('autoClose')->default(0);
            $table->integer('active')->default(1);
        });

        Schema::create('support_chats_start', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('countryID');
            $table->integer('regionID')->default(0);
            $table->integer('area');
            $table->text('topic');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('closed')->nullable();
            $table->dateTime('closedDate')->nullable();
            $table->integer('closedBy')->nullable();
        });

        Schema::create('support_chats_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->integer('active')->default(1);
        });

        Schema::create('support_ticket_priorities', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->text('description');
        });

        Schema::create('support_ticket_status', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->text('description');
        });

        Schema::create('system_account_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->text('description');
            $table->integer('active')->default(1);
        });

        Schema::create('system_advancement_cubs_challenges', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->string('name');
        });

        Schema::create('system_advancement_cubs_levels', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->string('name');
            $table->text('description');
            $table->integer('highLevel')->default(0);
            $table->integer('investment')->default(0);
            $table->string('colour', 25)->nullable();
            $table->integer('active')->default(1);
        });

        Schema::create('system_advancement_cubs_second', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->integer('advancmentID')->index('advancmentID');
            $table->string('advancementArea')->nullable();
            $table->string('name');
            $table->text('description');
        });

        Schema::create('system_advancement_cubs_third', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->integer('advancmentID')->index('advancmentID');
            $table->integer('secondID')->index('secondID');
            $table->string('challenge', 50)->nullable();
            $table->integer('theme')->default(0);
            $table->string('note')->nullable();
            $table->string('name');
            $table->text('description');
            $table->string('short')->nullable();
            $table->integer('campingTask')->default(0);
            $table->integer('badgeTask')->default(0);
            $table->integer('active')->default(1);

            $table->index(['challenge', 'active', 'programType'], 'challenge');
        });

        Schema::create('system_advancement_meerkats_challenges', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->string('name');
        });

        Schema::create('system_advancement_meerkats_levels', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->string('name');
            $table->text('description');
            $table->integer('highLevel')->default(1);
            $table->integer('investment')->default(0);
            $table->integer('active')->default(1);
        });

        Schema::create('system_advancement_meerkats_second', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->integer('advancmentID')->index('advancmentID');
            $table->string('advancementArea')->nullable();
            $table->string('name');
            $table->string('short');
            $table->text('description');
            $table->integer('badgeTask')->default(0);
            $table->integer('theme')->default(0);
            $table->integer('active')->default(1);
        });

        Schema::create('system_advancement_meerkats_third', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->integer('advancmentID')->index('advancmentID');
            $table->integer('secondID')->index('secondID');
            $table->integer('challenge')->default(0);
            $table->integer('theme')->nullable()->default(0);
            $table->string('note')->nullable();
            $table->string('name');
            $table->text('description');
            $table->string('short')->nullable();
            $table->integer('campingTask')->default(0);
            $table->integer('badgeTask')->default(0);
            $table->integer('active')->default(1);
        });

        Schema::create('system_advancement_rovers_challenges', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->text('description');
        });

        Schema::create('system_advancement_rovers_levels', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->string('name');
            $table->text('description');
            $table->string('htmlColor', 25)->nullable();
            $table->integer('highLevel')->default(1);
            $table->integer('investment')->default(0);
            $table->integer('active')->default(1);
        });

        Schema::create('system_advancement_rovers_second', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->integer('advancmentID');
            $table->integer('theme')->default(0);
            $table->string('name');
            $table->text('description');
            $table->string('short')->nullable();
            $table->integer('campingTask')->default(0);
            $table->integer('badgeTask')->default(0);
            $table->integer('active')->default(1);
        });

        Schema::create('system_advancement_scouts_levels', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('scoutProgramTypeID')->default(1);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->string('name');
            $table->text('description');
            $table->string('htmlColor', 15)->nullable();
            $table->string('colour', 100)->nullable();
            $table->integer('highLevel')->default(1);
            $table->integer('investment')->default(0);
            $table->integer('active')->default(1);
        });

        Schema::create('system_advancement_scouts_second', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('scoutProgramTypeID')->default(2);
            $table->integer('programType')->default(2);
            $table->integer('countryID')->default(196);
            $table->integer('position')->default(0);
            $table->integer('advancmentID')->index('advancmentID');
            $table->integer('theme')->nullable();
            $table->string('name')->nullable();
            $table->text('description');
            $table->string('short')->nullable();
            $table->integer('campingTask')->default(0);
            $table->integer('badgeTask')->default(0);
            $table->string('oldID', 11)->default('0');
            $table->integer('active')->default(1);
            $table->integer('PGATask')->default(0);

            $table->index(['programType', 'advancmentID', 'active'], 'programType');
            $table->index(['programType', 'active'], 'programType_2');
        });

        Schema::create('system_advancement_scouts_second_entsha_badges', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('taskID');
            $table->integer('badgeID')->index('badgeID');
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(1);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('system_advancement_scouts_second_entsha_themes', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(2);
            $table->string('themeName');
            $table->text('description');
        });

        Schema::create('system_asset_condition', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->string('description');
            $table->integer('active');
        });

        Schema::create('system_awards_rovers_levels', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->string('name');
            $table->text('description');
            $table->string('htmlColor', 15)->nullable();
        });

        Schema::create('system_badge_cubs_first', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->string('type')->nullable();
            $table->text('note')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(1);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('system_badge_cubs_second', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('firstID')->index('firstID');
            $table->string('heading')->nullable();
            $table->text('task');
            $table->integer('position')->default(0);
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(1);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('system_badge_meerkats_first', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->string('type')->default('Special');
            $table->text('note')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(1);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('system_badge_meerkats_second', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('firstID')->index('firstID');
            $table->string('heading')->nullable();
            $table->text('task');
            $table->integer('position')->default(0);
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(1);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('system_badge_rovers_first', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->string('type', 25);
            $table->string('name');
            $table->text('note')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(1);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('system_badge_rovers_second', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('firstID')->index('firstID');
            $table->string('heading')->nullable();
            $table->text('task');
            $table->integer('position')->default(0);
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(1);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('system_badge_scouts_first', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1)->index('programType');
            $table->integer('countryID')->default(196);
            $table->string('type', 25);
            $table->string('name');
            $table->text('note')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(1);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('system_badge_scouts_second', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('countryID')->default(196);
            $table->integer('firstID')->index('firstID');
            $table->string('heading')->nullable();
            $table->text('task');
            $table->integer('position')->default(0);
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby')->default(1);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('system_badge_scouts_to_badge', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('badgeID');
            $table->integer('toBadgeTaskID');
            $table->integer('active')->default(1);
        });

        Schema::create('system_cities', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->integer('active');

            $table->index(['countryID', 'active'], 'countryID');
        });

        Schema::create('system_committee_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->string('description');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
        });

        Schema::create('system_council_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->string('description');
            $table->dateTime('created');
            $table->integer('createdby');
        });

        Schema::create('system_country_names', static function (Blueprint $table) {
            $table->bigInteger('country_id', true);
            $table->string('country_code', 3);
            $table->string('country_name', 50);
            $table->string('continent_name')->nullable();
            $table->string('region_name')->nullable();
            $table->integer('usingSD')->default(0);
            $table->string('associationName')->nullable();
            $table->string('branch1Name')->nullable();
            $table->integer('branch1ID')->nullable();
            $table->decimal('branch1StartingAge', 3, 1)->default(5);
            $table->decimal('branch1EndingAge', 3, 1)->default(7);
            $table->string('branch2Name')->nullable();
            $table->integer('branch2ID')->nullable();
            $table->decimal('branch2StartingAge', 3, 1)->default(7);
            $table->decimal('branch2EndingAge', 3, 1)->default(11);
            $table->string('branch3Name')->nullable();
            $table->integer('branch3ID')->nullable();
            $table->decimal('branch3StartingAge', 3, 1)->default(11);
            $table->decimal('branch3EndingAge', 3, 1)->default(18);
            $table->string('branch4Name')->nullable();
            $table->integer('branch4ID')->nullable();
            $table->decimal('branch4StartingAge', 3, 1)->default(18);
            $table->decimal('branch4EndingAge', 3, 1)->default(25);
            $table->string('branch5Name')->nullable();
            $table->integer('branch5ID')->nullable();
            $table->decimal('branch5StartingAge', 3, 1)->default(25);
            $table->decimal('branch5EndingAge', 3, 1)->default(35);

            $table->primary(['country_id', 'country_code']);
        });

        Schema::create('system_cubs_tasks', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->integer('active')->comment('1 = Active');
        });

        Schema::create('system_document_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->string('description');
            $table->integer('youth')->default(0);
        });

        Schema::create('system_faq', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('catID');
            $table->integer('targetID')->default(0);
            $table->string('q');
            $table->text('a');
            $table->integer('active')->default(1);
            $table->integer('position')->default(0);
        });

        Schema::create('system_faq_cats', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('faqGroup')->default(0)->comment('1 = Scouters, 2 = Parents, 3 = Scouts, 4 = AMS');
            $table->integer('position')->default(0);
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('forNational')->default(0);
            $table->integer('forRegion')->default(0);
            $table->integer('forDistrict')->default(0);
            $table->integer('forGroupAdults')->default(0);
            $table->integer('forGroupParents')->default(0);
            $table->integer('forGroupScouts')->default(0);
            $table->integer('forGroupRovers')->default(0);
            $table->integer('forAlumni')->default(0);
            $table->integer('active')->default(1);
        });

        Schema::create('system_financial_fee_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->text('description');
            $table->integer('canBeProrated')->default(0)->comment('1 = Yes, 0 = No');
            $table->integer('active');
        });

        Schema::create('system_group_event_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->string('name');
            $table->integer('active')->comment('1 = Active');
            $table->integer('groupType')->default(0);
            $table->integer('districtType')->default(0);
            $table->integer('regionalType')->default(0);
            $table->integer('nationalType')->default(0);
        });

        Schema::create('system_group_management_level', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('type', 10);
            $table->string('name');
            $table->text('description');
            $table->dateTime('created');
            $table->integer('createdby');
        });

        Schema::create('system_parent_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
        });

        Schema::create('system_program_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->integer('area')->default(0);
            $table->integer('active')->default(1);
        });

        Schema::create('system_program_types_cubs', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
        });

        Schema::create('system_program_types_meerkats', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
        });

        Schema::create('system_program_types_rovers', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
        });

        Schema::create('system_program_types_scouts', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
        });

        Schema::create('system_roadmap_little', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('area');
            $table->text('text');
            $table->date('releaseDate');
            $table->integer('active')->index('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });

        Schema::create('system_rover_meeting_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
        });

        Schema::create('system_rover_tasks', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->integer('active')->default(1);
        });

        Schema::create('system_scout_tasks', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->integer('active')->default(1);
        });

        Schema::create('system_settings', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('maintenance')->default(0);
        });

        Schema::create('system_star_award_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->integer('area');
            $table->integer('active')->default(1);
            $table->integer('position');
        });

        Schema::create('system_titles', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title');
        });

        Schema::create('system_user_logging', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->nullable();
            $table->integer('regionID')->nullable();
            $table->integer('districtID')->nullable();
            $table->integer('groupID')->nullable()->index('assocToGroup');
            $table->integer('userID')->nullable()->index('userID');
            $table->string('page', 1024)->index('page');
            $table->string('IP', 40);
            $table->string('userAgent', 1024)->nullable();
            $table->text('post')->nullable();
            $table->dateTime('created')->index('created');

            $table->index(['countryID', 'IP'], 'countryID');
            $table->index(['IP', 'userID'], 'IP');
            $table->index(['IP', 'page'], 'IP_2');
        });

        Schema::create('system_user_types', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('name');
            $table->text('description');
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

            $table->index(['id', 'countryID'], 'id');
            $table->index(['id', 'adultLeaderRole', 'warrantedRole'], 'id_2');
        });

        Schema::create('system_users', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('oldID')->default(0);
            $table->string('username', 128)->nullable()->index('username');
            $table->binary('passwordNew')->nullable();
            $table->dateTime('lastPasswordChange')->nullable();
            $table->integer('passwordChangedBy')->nullable();
            $table->dateTime('lastLoginDate')->nullable()->index('lastLoginDate');
            $table->date('startDate')->nullable();
            $table->string('title', 32)->nullable();
            $table->string('first_name', 128)->nullable();
            $table->string('otherName', 128)->nullable();
            $table->string('surname', 64)->nullable();
            $table->string('previousSurname', 128)->nullable();
            $table->string('knownName', 128)->nullable();
            $table->string('scoutName', 64)->nullable();
            $table->string('photo', 128)->nullable();
            $table->string('thumb', 128)->nullable();
            $table->string('idNumber', 13)->nullable();
            $table->string('IDBookLocation', 2048)->nullable();
            $table->string('passportNumber', 24)->nullable();
            $table->integer('passportCountry')->nullable()->default(196);
            $table->string('partnersFullName', 128)->nullable();
            $table->string('sex', 6)->nullable();
            $table->string('race', 10)->nullable();
            $table->date('dob')->nullable();
            $table->date('dateInvested')->nullable();
            $table->integer('multiID')->default(0);
            $table->integer('packID')->nullable()->default(0);
            $table->integer('troopID')->nullable()->default(0);
            $table->dateTime('dateToCubs')->nullable();
            $table->dateTime('dateToScouts')->nullable();
            $table->integer('scoutPatrolID')->nullable();
            $table->integer('scoutPatrolTaskID')->nullable();
            $table->dateTime('dateToRovers')->nullable();
            $table->text('phys_address')->nullable();
            $table->string('gpsLat', 25)->nullable();
            $table->string('gpsLon', 25)->nullable();
            $table->string('gpsAccuracy', 7)->nullable();
            $table->integer('phys_country_id')->default(196);
            $table->text('postal_address')->nullable();
            $table->integer('postal_country_id')->nullable();
            $table->dateTime('created');
            $table->integer('createdby')->default(0);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('user_type')->nullable()->index('user_type');
            $table->integer('parentType')->nullable();
            $table->integer('active')->index('orphanedVulnerable')->comment('1 = active');
            $table->dateTime('dateDeactivated')->nullable();
            $table->integer('deactivatedBy')->nullable();
            $table->integer('assoc_to_account');
            $table->integer('assoc_to_group')->nullable();
            $table->string('branch', 6)->nullable();
            $table->integer('assoc_to_district')->nullable();
            $table->integer('assoc_to_region')->nullable();
            $table->string('trainingRegionName', 24)->nullable();
            $table->string('trainingDistrictName', 64)->nullable();
            $table->string('trainingGroupName', 64)->nullable();
            $table->string('language', 5)->nullable();
            $table->string('cellNr', 32)->nullable();
            $table->string('officeNr', 32)->nullable();
            $table->string('homeNr', 32)->nullable();
            $table->string('faxNr', 64)->nullable();
            $table->integer('responsible_for_payment')->nullable()->comment('1 = Yes');
            $table->integer('mustChangePassword')->nullable()->comment('1 = Must change password');
            $table->integer('canLogon')->comment('1 = Can Logon');
            $table->string('medicalAidName', 128)->nullable();
            $table->string('medicalAidNr', 128)->nullable();
            $table->string('medicalAidPrincipalMember', 128)->nullable();
            $table->string('doctorsName', 128)->nullable();
            $table->string('doctorsPhone', 128)->nullable();
            $table->string('allergies')->nullable();
            $table->text('allergiesInstructions')->nullable();
            $table->text('disabilities')->nullable();
            $table->text('disabilitiesInstructions')->nullable();
            $table->string('medicalConditions', 128)->nullable();
            $table->text('medicalConditionsInstructions')->nullable();
            $table->text('currentMedication')->nullable();
            $table->string('emergencyContactName', 128)->nullable();
            $table->string('emergencyContactCell', 128)->nullable();
            $table->string('emergencyContactTel', 128)->nullable();
            $table->string('emergencyContactRelationship', 64)->nullable();
            $table->text('specialMealRequirements')->nullable();
            $table->string('religiousAffilliation', 128)->nullable();
            $table->string('school', 128)->nullable();
            $table->string('religion', 128)->nullable();
            $table->string('religiousAffiliation', 128)->nullable();
            $table->text('hobbies')->nullable();
            $table->text('sports')->nullable();
            $table->text('interests')->nullable();
            $table->integer('canAdmin')->default(0);
            $table->string('100CharID', 100)->nullable()->index('100CharID');
            $table->integer('uniquePIN')->nullable();
            $table->integer('weeklyEmailUnsubscribe')->default(0);
            $table->text('weeklyEmailUnsubscribeText')->nullable();
            $table->dateTime('weeklyEmailUnsubscribeDate')->nullable();
            $table->integer('logonEmailSent')->nullable()->comment('1 = Yes');
            $table->dateTime('LogonEmailDate')->nullable();
            $table->integer('amsOnly')->default(0)->comment('1 = Only AMS');
            $table->integer('amsRole')->default(0);
            $table->integer('homeLanguage')->nullable();
            $table->integer('otherLanguage')->nullable();
            $table->text('otherLanguages')->nullable();
            $table->integer('proficiencyInEnglish')->nullable()->default(0);
            $table->string('religiousBelief', 32)->nullable();
            $table->integer('highestEducation')->nullable();
            $table->integer('nrOfChildrenBoys')->nullable();
            $table->integer('nrOfChildrenGirls')->nullable();
            $table->string('occupation', 64)->nullable();
            $table->string('typeOfEmployment', 10)->nullable();
            $table->string('employer', 128)->nullable();
            $table->integer('maritalStatus')->nullable();
            $table->string('ref1Name', 128)->nullable();
            $table->text('ref1Address')->nullable();
            $table->string('ref1Tel', 128)->nullable();
            $table->string('ref2Name', 128)->nullable();
            $table->text('ref2Address')->nullable();
            $table->string('ref2Tel', 128)->nullable();
            $table->integer('newsletterUnsubscribe')->nullable()->default(0);
            $table->dateTime('newsletterUnsubscribeDate')->nullable();
            $table->integer('reportView')->nullable()->default(10);
            $table->integer('roverGroupID')->nullable()->default(0);
            $table->integer('roverGroupRoleID')->nullable()->default(0);
            $table->integer('roverGroupAccountID')->nullable()->default(0);
            $table->integer('24WSJ')->nullable()->default(0);
            $table->integer('24WSJRole')->nullable()->default(0);
            $table->string('24wsjNotListedDistrict', 64)->nullable();
            $table->string('24wsjNotListedGroup', 64)->nullable();
            $table->integer('SANJamb2017')->default(0);
            $table->string('SANJamb2017Role', 3)->default('0');
            $table->string('sanJambNotListedRegion', 64)->nullable();
            $table->string('sanJambNotListedDistrict', 64)->nullable();
            $table->string('sanJambNotListedGroup', 64)->nullable();
            $table->integer('infoRedacted')->default(0)->comment('0 = Not Redacted, 1 = Redacted on screen');
            $table->string('SSANumber', 32)->nullable();
            $table->integer('orphaned')->default(0);
            $table->integer('vulnerable')->default(0);
            $table->integer('sendAMSMail')->default(1);
            $table->text('generalNotes')->nullable();
            $table->integer('form29Generated')->default(0);
            $table->integer('logonEmail')->default(0);
            $table->integer('weeklyProgramEmail')->default(1);
            $table->integer('profileChangesEmail')->default(1);
            $table->integer('newsletterEmail')->default(1);
            $table->integer('lowerStaffProfileChanges')->default(1);
            $table->integer('loggedInTo20')->default(0);
            $table->integer('canLogonTo20')->default(1);
            $table->integer('adultRecruit')->default(0);
            $table->integer('addedIn')->default(1);
            $table->integer('canAdminElearning')->default(0);
            $table->integer('canAdminElearningCourses')->default(0);
            $table->integer('view')->default(1)->comment('1 = Line, 2 = Grid');
            $table->integer('docsDeleted')->nullable();
            $table->integer('takenSurvey')->nullable()->default(0);
            $table->integer('ddValue')->default(25);

            $table->index(['active', 'SANJamb2017', 'user_type', 'username', 'assoc_to_account'], 'active');
            $table->index(['assoc_to_region', 'active', 'user_type', 'dateInvested'], 'assoc_to_region_5');
            $table->index(['assoc_to_region', 'amsRole', 'active', 'sendAMSMail'], 'assoc_to_region');
            $table->index(['assoc_to_group', 'user_type', 'title', 'active'], 'assoc_to_group_6');
            $table->index(['id', 'active'], 'id_4');
            $table->index(['assoc_to_group', 'user_type', 'active'], 'assoc_to_group_2');
            $table->index(['assoc_to_account', 'assoc_to_group', 'active'], 'assoc_to_account');
            $table->index(['assoc_to_region', 'user_type', 'active', 'sendAMSMail'], 'assoc_to_region_2');
            $table->index(['assoc_to_group', 'user_type', 'created', 'active'], 'assoc_to_group_7');
            $table->index(['assoc_to_group', 'user_type', 'scoutPatrolTaskID', 'active'], 'assoc_to_group_8');
            $table->index(['phys_country_id', 'user_type', 'orphaned', 'vulnerable', 'active'], 'phys_country_id_2');
            $table->index(['active', 'modified', 'addedIn'], 'Move To 2.0');
            $table->index(['active', 'docsDeleted', 'dateDeactivated'], 'active_2');
            $table->index(['id', 'assoc_to_region'], 'id_2');
            $table->index(['id', 'assoc_to_account', 'active'], 'id');
            $table->index(['active', 'form29Generated', 'IDBookLocation'], 'Form29');
            $table->index(['id', 'assoc_to_group'], 'id_3');
            $table->index(['assoc_to_account', 'user_type', 'active'], 'assoc_to_account_2');
            $table->index(['id', 'active', 'gpsLat', 'gpsLon'], 'GPS');
            $table->index(['assoc_to_region', 'active', 'amsRole'], 'assoc_to_region_6');
            $table->index(['assoc_to_group', 'user_type', 'amsRole', 'active'], 'assoc_to_group_5');
            $table->index(['assoc_to_group', 'dob', 'active'], 'assoc_to_group_3');
            $table->index(['assoc_to_district', 'user_type', 'dob', 'active'], 'assoc_to_district');
            $table->index(['assoc_to_group', 'amsRole', 'active'], 'assoc_to_group');
            $table->index(['username', 'active', 'canLogon'], 'username_2');
            $table->index(['assoc_to_region', 'assoc_to_district', 'user_type', 'orphaned', 'vulnerable', 'active'], 'assoc_to_region_3');
            $table->index(['username', 'passwordNew', 'active', 'canLogon', 'phys_country_id'], 'Logon');
            $table->index(['active', 'generalNotes', 'startDate'], 'UsingSDLite');
            $table->index(['assoc_to_group', 'active', 'SANJamb2017Role'], 'assoc_to_group_4');
            $table->index(['assoc_to_region', 'user_type', 'orphaned', 'vulnerable', 'active'], 'assoc_to_region_4');
            $table->index(['assoc_to_account', 'parentType', 'active'], 'assoc_to_account_3');
        });

        Schema::create('system_users_email_verifications', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->index('userID');
            $table->string('emailAddress', 150);
            $table->integer('emailFailedVerification')->default(0);
            $table->dateTime('dateVerified')->nullable();
            $table->text('response')->nullable();
            $table->string('responseHeading', 25)->nullable();
            $table->dateTime('sentConfirmationEmail')->nullable();
            $table->text('subjectReceivedBack')->nullable();
            $table->text('messageReceivedBack')->nullable();
            $table->dateTime('messageReceivedBackDate')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
        });

        Schema::create('system_users_emergency_contacts', static function (Blueprint $table) {
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

        Schema::create('system_users_fingerprint', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->nullable();
            $table->text('agent')->nullable();
            $table->string('ipAddress', 25)->nullable();
            $table->dateTime('created');

            $table->index(['userID', 'agent', 'ipAddress'], 'userID');
        });

        Schema::create('system_users_forced_logouts', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->dateTime('date')->index('date');
            $table->integer('userID');
            $table->text('fromURL');
            $table->text('toURL');
            $table->string('IPAddress')->nullable();
            $table->text('extended')->nullable();
            $table->text('userAgent')->nullable();

            $table->index(['userID', 'date'], 'userID');
        });

        Schema::create('system_users_form29', static function (Blueprint $table) {
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

            $table->index(['userID', 'active'], 'userID');
        });

        Schema::create('system_users_other_roles', static function (Blueprint $table) {
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

            $table->index(['actionGroupID', 'active', 'roleID'], 'actionGroupID');
            $table->index(['actionRegionID', 'active', 'roleID'], 'actionRegionID');
            $table->index(['userID', 'actionRegionID', 'active', 'roleID'], 'userID_5');
            $table->index(['groupID', 'userID', 'active', 'roleID'], 'groupID');
            $table->index(['districtID', 'userID', 'active', 'roleID'], 'districtID');
            $table->index(['countryID', 'userID', 'active', 'roleID'], 'countryID');
            $table->index(['userID', 'active', 'id'], 'userID_2');
            $table->index(['roleID', 'active', 'defaultRole'], 'roleID_2');
            $table->index(['regionID', 'userID', 'active', 'roleID'], 'regionID');
            $table->index(['actionCountryID', 'userID', 'active'], 'actionCountryID_2');
            $table->index(['regionID', 'active'], 'regionID_3');
            $table->index(['countryID', 'roleID', 'active'], 'countryID_3');
            $table->index(['districtID', 'active'], 'districtID_3');
            $table->index(['districtID', 'roleID', 'active'], 'districtID_2');
            $table->index(['countryID', 'active'], 'countryID_4');
            $table->index(['actionCountryID', 'active', 'roleID'], 'actionCountryID');
            $table->index(['userID', 'active', 'actionGroupID'], 'userID_4');
            $table->index(['actionDistrictID', 'active', 'roleID'], 'actionDistrictID');
            $table->index(['groupID', 'active'], 'groupID_3');
            $table->index(['roleID', 'active'], 'roleID');
            $table->index(['actionCountryID', 'active', 'defaultRole'], 'form29');
            $table->index(['userID', 'active', 'defaultRole'], 'userID');
            $table->index(['regionID', 'roleID', 'active'], 'regionID_2');
            $table->index(['groupID', 'roleID', 'active'], 'groupID_2');
            $table->index(['userID', 'roleID', 'active', 'actionCountryID', 'actionRegionID', 'actionDistrictID', 'actionGroupID'], 'userID_3');
        });

        Schema::create('system_users_passwords_emailed', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('username', 1024);
            $table->dateTime('date');
            $table->string('emailed', 3);
        });

        Schema::create('telegram_ban_count', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->nullable();
            $table->string('chatID');
            $table->integer('count');
            $table->dateTime('firstAdded')->useCurrent();
            $table->text('why')->nullable();

            $table->index(['userID', 'chatID'], 'userID');
        });

        Schema::create('telegram_currently_chatting', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('systemUserID');
            $table->integer('chattingToUserID');
            $table->integer('active');
            $table->dateTime('created');

            $table->index(['chattingToUserID', 'active'], 'chattingToUserID');
        });

        Schema::create('telegram_messages', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->nullable()->default(0);
            $table->string('telegramUserID')->nullable()->index('telegramUserID');
            $table->string('telegramFirstName')->nullable();
            $table->string('telegramSurname')->nullable();
            $table->string('telegramUsername')->nullable();
            $table->text('message');
            $table->string('direction', 12)->comment('\'To SD\' or \'From SD\'');
            $table->integer('sentByID')->default(0);
            $table->dateTime('date')->useCurrent();
            $table->dateTime('markedRead')->nullable();
            $table->integer('markedReadBy')->nullable();
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();

            $table->index(['userID', 'active', 'markedRead'], 'userID');
            $table->index(['userID', 'date', 'direction'], 'userID_2');
        });

        Schema::create('telegram_random_message', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('message');
            $table->integer('active')->default(1);
        });

        Schema::create('telegram_sent_human_message', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->date('date');
            $table->text('message');

            $table->index(['userID', 'date'], 'userID');
        });

        Schema::create('telegram_standard_messages', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('message');
            $table->integer('active')->default(1);
        });

        Schema::create('telegram_usernames', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->nullable();
            $table->string('username')->nullable()->index('username');
            $table->string('chatID')->nullable()->index('chatID');
            $table->integer('active')->default(1);
            $table->integer('banned')->default(0);
            $table->dateTime('bannedDate')->nullable();
            $table->dateTime('created')->useCurrent();
        });

        Schema::create('translations', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('fromText');
            $table->text('toText');
            $table->integer('active')->default(1);

            $table->index(['countryID', 'active'], 'countryID');
        });

        Schema::create('wsm16_expression', static function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('roleID');
            $table->integer('active');
            $table->integer('passportCountryID');
            $table->integer('passportChecked')->default(0);
            $table->integer('countryID')->default(196);
            $table->integer('regionID')->default(0);
            $table->integer('districtID')->default(0);
            $table->integer('groupID')->default(0);
            $table->integer('applyRoleID');
            $table->integer('invested')->default(0);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['userID', 'active'], 'userID');
            $table->index(['roleID', 'active'], 'roleID');
        });
    }

    public static function down()
    {
        Schema::dropIfExists('wsm16_expression');

        Schema::dropIfExists('translations');

        Schema::dropIfExists('telegram_usernames');

        Schema::dropIfExists('telegram_standard_messages');

        Schema::dropIfExists('telegram_sent_human_message');

        Schema::dropIfExists('telegram_random_message');

        Schema::dropIfExists('telegram_messages');

        Schema::dropIfExists('telegram_currently_chatting');

        Schema::dropIfExists('telegram_ban_count');

        Schema::dropIfExists('system_users_passwords_emailed');

        Schema::dropIfExists('system_users_other_roles');

        Schema::dropIfExists('system_users_form29');

        Schema::dropIfExists('system_users_forced_logouts');

        Schema::dropIfExists('system_users_fingerprint');

        Schema::dropIfExists('system_users_emergency_contacts');

        Schema::dropIfExists('system_users_email_verifications');

        Schema::dropIfExists('system_users');

        Schema::dropIfExists('system_user_types');

        Schema::dropIfExists('system_user_logging');

        Schema::dropIfExists('system_titles');

        Schema::dropIfExists('system_star_award_types');

        Schema::dropIfExists('system_settings');

        Schema::dropIfExists('system_scout_tasks');

        Schema::dropIfExists('system_rover_tasks');

        Schema::dropIfExists('system_rover_meeting_types');

        Schema::dropIfExists('system_roadmap_little');

        Schema::dropIfExists('system_program_types_scouts');

        Schema::dropIfExists('system_program_types_rovers');

        Schema::dropIfExists('system_program_types_meerkats');

        Schema::dropIfExists('system_program_types_cubs');

        Schema::dropIfExists('system_program_types');

        Schema::dropIfExists('system_parent_types');

        Schema::dropIfExists('system_group_management_level');

        Schema::dropIfExists('system_group_event_types');

        Schema::dropIfExists('system_financial_fee_types');

        Schema::dropIfExists('system_faq_cats');

        Schema::dropIfExists('system_faq');

        Schema::dropIfExists('system_document_types');

        Schema::dropIfExists('system_cubs_tasks');

        Schema::dropIfExists('system_country_names');

        Schema::dropIfExists('system_council_types');

        Schema::dropIfExists('system_committee_types');

        Schema::dropIfExists('system_cities');

        Schema::dropIfExists('system_badge_scouts_to_badge');

        Schema::dropIfExists('system_badge_scouts_second');

        Schema::dropIfExists('system_badge_scouts_first');

        Schema::dropIfExists('system_badge_rovers_second');

        Schema::dropIfExists('system_badge_rovers_first');

        Schema::dropIfExists('system_badge_meerkats_second');

        Schema::dropIfExists('system_badge_meerkats_first');

        Schema::dropIfExists('system_badge_cubs_second');

        Schema::dropIfExists('system_badge_cubs_first');

        Schema::dropIfExists('system_awards_rovers_levels');

        Schema::dropIfExists('system_asset_condition');

        Schema::dropIfExists('system_advancement_scouts_second_entsha_themes');

        Schema::dropIfExists('system_advancement_scouts_second_entsha_badges');

        Schema::dropIfExists('system_advancement_scouts_second');

        Schema::dropIfExists('system_advancement_scouts_levels');

        Schema::dropIfExists('system_advancement_rovers_second');

        Schema::dropIfExists('system_advancement_rovers_levels');

        Schema::dropIfExists('system_advancement_rovers_challenges');

        Schema::dropIfExists('system_advancement_meerkats_third');

        Schema::dropIfExists('system_advancement_meerkats_second');

        Schema::dropIfExists('system_advancement_meerkats_levels');

        Schema::dropIfExists('system_advancement_meerkats_challenges');

        Schema::dropIfExists('system_advancement_cubs_third');

        Schema::dropIfExists('system_advancement_cubs_second');

        Schema::dropIfExists('system_advancement_cubs_levels');

        Schema::dropIfExists('system_advancement_cubs_challenges');

        Schema::dropIfExists('system_account_types');

        Schema::dropIfExists('support_ticket_status');

        Schema::dropIfExists('support_ticket_priorities');

        Schema::dropIfExists('support_chats_types');

        Schema::dropIfExists('support_chats_start');

        Schema::dropIfExists('support_chats_standard_answers');

        Schema::dropIfExists('support_chats');

        Schema::dropIfExists('star_awards_notes');

        Schema::dropIfExists('star_awards');

        Schema::dropIfExists('services_purchased_spreadsheets_sent');

        Schema::dropIfExists('services_purchased_spreadsheets_received');

        Schema::dropIfExists('services_purchased');

        Schema::dropIfExists('sd_articles');

        Schema::dropIfExists('sd_article_cats');

        Schema::dropIfExists('scouter_reviews_likes');

        Schema::dropIfExists('scouter_reviews');

        Schema::dropIfExists('reports_numbers');

        Schema::dropIfExists('regions');

        Schema::dropIfExists('projects_supported');

        Schema::dropIfExists('projects_for');

        Schema::dropIfExists('projects');

        Schema::dropIfExists('payment_types');

        Schema::dropIfExists('notifications_archive');

        Schema::dropIfExists('notifications');

        Schema::dropIfExists('national');

        Schema::dropIfExists('jamboree_troops');

        Schema::dropIfExists('jamboree_troop_patrol_allocations');

        Schema::dropIfExists('jamboree_sub_camps');

        Schema::dropIfExists('jamboree_sub_camp_troop_allocations');

        Schema::dropIfExists('jamboree_scouters');

        Schema::dropIfExists('jamboree_position_offered');

        Schema::dropIfExists('jamboree_payments');

        Schema::dropIfExists('jamboree_payment_types');

        Schema::dropIfExists('jamboree_patrols');

        Schema::dropIfExists('jamboree_invoices_items');

        Schema::dropIfExists('jamboree_invoices');

        Schema::dropIfExists('jamboree_initial_thoughts');

        Schema::dropIfExists('jamboree_info');

        Schema::dropIfExists('jamboree_generated_pdfs');

        Schema::dropIfExists('jamboree_expr_of_interest');

        Schema::dropIfExists('jamboree_eoi');

        Schema::dropIfExists('jamboree_core_team');

        Schema::dropIfExists('jamboree_buses_users');

        Schema::dropIfExists('jamboree_bus_info');

        Schema::dropIfExists('jamboree_beds_allocations');

        Schema::dropIfExists('jamboree_beds');

        Schema::dropIfExists('jamboree_application');

        Schema::dropIfExists('jamboree_adult_roles');

        Schema::dropIfExists('jamboree_adult_allocations');

        Schema::dropIfExists('jamboree_activity_centers');

        Schema::dropIfExists('jamboree_activity_center_bases');

        Schema::dropIfExists('info_sharing_types');

        Schema::dropIfExists('info_sharing_reviews');

        Schema::dropIfExists('info_sharing_likes');

        Schema::dropIfExists('info_sharing');

        Schema::dropIfExists('groups_types');

        Schema::dropIfExists('groups_property_updates');

        Schema::dropIfExists('groups_property_ownership_types');

        Schema::dropIfExists('groups_property');

        Schema::dropIfExists('groups_multi');

        Schema::dropIfExists('groups_entsha_move');

        Schema::dropIfExists('groups');

        Schema::dropIfExists('group_youth_charges');

        Schema::dropIfExists('group_weekly_emails_emailed');

        Schema::dropIfExists('group_user_picture_changes');

        Schema::dropIfExists('group_star_awards');

        Schema::dropIfExists('group_send_logon_details');

        Schema::dropIfExists('group_scouts_patrol_names');

        Schema::dropIfExists('group_scouts_charges');

        Schema::dropIfExists('group_scout_troops');

        Schema::dropIfExists('group_rovers_patrol_names');

        Schema::dropIfExists('group_rover_crews');

        Schema::dropIfExists('group_programs_online_working_on');

        Schema::dropIfExists('group_programs_online_tasks_penalty');

        Schema::dropIfExists('group_programs_online_tasks_notes');

        Schema::dropIfExists('group_programs_online_tasks_images');

        Schema::dropIfExists('group_programs_online_tasks_documents');

        Schema::dropIfExists('group_programs_online_tasks_completion');

        Schema::dropIfExists('group_programs_online_tasks');

        Schema::dropIfExists('group_programs_documents');

        Schema::dropIfExists('group_programs');

        Schema::dropIfExists('group_parents_committee_minutes');

        Schema::dropIfExists('group_newsletters');

        Schema::dropIfExists('group_meerkats_patrol_names');

        Schema::dropIfExists('group_meerkat_dens');

        Schema::dropIfExists('group_financial_years');

        Schema::dropIfExists('group_financial_payments_made');

        Schema::dropIfExists('group_financial_invoices_items');

        Schema::dropIfExists('group_financial_invoices_emailed');

        Schema::dropIfExists('group_financial_invoices');

        Schema::dropIfExists('group_financial_fees');

        Schema::dropIfExists('group_financial_fee_types');

        Schema::dropIfExists('group_financial_credit_notes_items');

        Schema::dropIfExists('group_financial_credit_notes');

        Schema::dropIfExists('group_financial_annual_invoice_discounts');

        Schema::dropIfExists('group_events_attending');

        Schema::dropIfExists('group_events');

        Schema::dropIfExists('group_event_documents');

        Schema::dropIfExists('group_equipment_store');

        Schema::dropIfExists('group_equipment');

        Schema::dropIfExists('group_edit_record');

        Schema::dropIfExists('group_documents');

        Schema::dropIfExists('group_district_reports_scouts_attendance');

        Schema::dropIfExists('group_district_reports_scouts');

        Schema::dropIfExists('group_district_reports_cubs_attendance');

        Schema::dropIfExists('group_district_reports_cubs');

        Schema::dropIfExists('group_district_reports');

        Schema::dropIfExists('group_cubs_sixes_names');

        Schema::dropIfExists('group_cub_packs');

        Schema::dropIfExists('group_council');

        Schema::dropIfExists('group_committee');

        Schema::dropIfExists('group_badges_in_programs');

        Schema::dropIfExists('group_badges_in_events');

        Schema::dropIfExists('group_attendance');

        Schema::dropIfExists('group_advancements_in_programs');

        Schema::dropIfExists('group_advancements_in_events');

        Schema::dropIfExists('group_accounts_transfers_stages');

        Schema::dropIfExists('group_accounts_transfers');

        Schema::dropIfExists('group_accounts');

        Schema::dropIfExists('group_account_transfers_notes');

        Schema::dropIfExists('event_user_booking_transport');

        Schema::dropIfExists('event_user_booking_roles');

        Schema::dropIfExists('event_user_booking_pops');

        Schema::dropIfExists('event_user_booking_payments');

        Schema::dropIfExists('event_user_booking_patrols');

        Schema::dropIfExists('event_user_booking_patrol_allocation');

        Schema::dropIfExists('event_user_booking_other_options');

        Schema::dropIfExists('event_user_booking_notes');

        Schema::dropIfExists('event_user_booking_invoices');

        Schema::dropIfExists('event_user_booking_credit_notes');

        Schema::dropIfExists('event_user_booking_accomodation');

        Schema::dropIfExists('event_user_booking');

        Schema::dropIfExists('event_competitions_survey_responses');

        Schema::dropIfExists('event_competitions_scoring_sheets_headings');

        Schema::dropIfExists('event_competitions_scoring_sheets');

        Schema::dropIfExists('event_competitions_scoring_dnp');

        Schema::dropIfExists('event_competitions_scoring_areas');

        Schema::dropIfExists('event_competitions_scoring');

        Schema::dropIfExists('event_competitions_questions');

        Schema::dropIfExists('event_competitions_location_logging');

        Schema::dropIfExists('event_competitions_judges_types');

        Schema::dropIfExists('event_competitions_judges');

        Schema::dropIfExists('event_competitions_internal_competitions');

        Schema::dropIfExists('event_competitions_groups_participating');

        Schema::dropIfExists('event_competitions_groups_attending');

        Schema::dropIfExists('event_competitions_gps');

        Schema::dropIfExists('event_competitions_finances_payments');

        Schema::dropIfExists('event_competitions_finances_invoices');

        Schema::dropIfExists('event_competitions_answers');

        Schema::dropIfExists('event_competition_score_adjudication');

        Schema::dropIfExists('event_booking_setup_changes');

        Schema::dropIfExists('districts_super');

        Schema::dropIfExists('districts');

        Schema::dropIfExists('directory_skills');

        Schema::dropIfExists('directory_professional_reviews');

        Schema::dropIfExists('directory_professional_likes');

        Schema::dropIfExists('directory_professional');

        Schema::dropIfExists('commerce_wish_list');

        Schema::dropIfExists('commerce_wallets_transaction_types');

        Schema::dropIfExists('commerce_wallet');

        Schema::dropIfExists('commerce_stock_suppliers');

        Schema::dropIfExists('commerce_stock_locations');

        Schema::dropIfExists('commerce_shoppers_logins');

        Schema::dropIfExists('commerce_search_queries');

        Schema::dropIfExists('commerce_products_subcat');

        Schema::dropIfExists('commerce_products_sub_subcat');

        Schema::dropIfExists('commerce_products_stock');

        Schema::dropIfExists('commerce_products_reviews');

        Schema::dropIfExists('commerce_products_images');

        Schema::dropIfExists('commerce_products_cat');

        Schema::dropIfExists('commerce_products');

        Schema::dropIfExists('commerce_payfast_transactions');

        Schema::dropIfExists('commerce_orders_details');

        Schema::dropIfExists('commerce_orders');

        Schema::dropIfExists('commerce_order_status');

        Schema::dropIfExists('commerce_group_fees');

        Schema::dropIfExists('commerce_delivery_providers_delivery_options');

        Schema::dropIfExists('commerce_delivery_providers');

        Schema::dropIfExists('commerce_delivery_address');

        Schema::dropIfExists('commerce_cart');

        Schema::dropIfExists('census_documents');

        Schema::dropIfExists('badges_scouts');

        Schema::dropIfExists('badges_rovers');

        Schema::dropIfExists('badges_photos');

        Schema::dropIfExists('badges_notes');

        Schema::dropIfExists('badges_meerkats');

        Schema::dropIfExists('badges_documents');

        Schema::dropIfExists('badges_cubs');

        Schema::dropIfExists('api_usage');

        Schema::dropIfExists('api_keys');

        Schema::dropIfExists('ams_warrant_types');

        Schema::dropIfExists('ams_warrant_info');

        Schema::dropIfExists('ams_warrant_extensions');

        Schema::dropIfExists('ams_warrant_cancellation_types');

        Schema::dropIfExists('ams_warrant_applications');

        Schema::dropIfExists('ams_training_past_types');

        Schema::dropIfExists('ams_training_past');

        Schema::dropIfExists('ams_training_locations');

        Schema::dropIfExists('ams_training_courses_types');

        Schema::dropIfExists('ams_training_courses_annual_warrants_available');

        Schema::dropIfExists('ams_training_courses_annual_lecturers');

        Schema::dropIfExists('ams_training_courses_annual_dates');

        Schema::dropIfExists('ams_training_courses_annual_bookings_tracking');

        Schema::dropIfExists('ams_training_courses_annual_bookings_notes');

        Schema::dropIfExists('ams_training_courses_annual_bookings');

        Schema::dropIfExists('ams_training_courses_annual_attendance');

        Schema::dropIfExists('ams_training_courses_annual');

        Schema::dropIfExists('ams_training_courses');

        Schema::dropIfExists('ams_terminate_reasons');

        Schema::dropIfExists('ams_terminate_leader');

        Schema::dropIfExists('ams_suspend_reasons');

        Schema::dropIfExists('ams_suspend_leader');

        Schema::dropIfExists('ams_retire_reasons');

        Schema::dropIfExists('ams_retire_leader');

        Schema::dropIfExists('ams_resign_reasons');

        Schema::dropIfExists('ams_resign_leader');

        Schema::dropIfExists('ams_police_clearance');

        Schema::dropIfExists('ams_past_service_type');

        Schema::dropIfExists('ams_past_service_info');

        Schema::dropIfExists('ams_marital_status');

        Schema::dropIfExists('ams_languages');

        Schema::dropIfExists('ams_highest_education');

        Schema::dropIfExists('ams_documents_groups');

        Schema::dropIfExists('ams_documents');

        Schema::dropIfExists('ams_document_types_groups');

        Schema::dropIfExists('ams_document_types');

        Schema::dropIfExists('ams_disciplinary_offences');

        Schema::dropIfExists('ams_disciplinary_info');

        Schema::dropIfExists('ams_disciplinary_headings');

        Schema::dropIfExists('ams_criminal_check');

        Schema::dropIfExists('ams_charge_types');

        Schema::dropIfExists('ams_charge_info');

        Schema::dropIfExists('ams_award_types');

        Schema::dropIfExists('ams_award_info');

        Schema::dropIfExists('ams_award_headings');

        Schema::dropIfExists('ams_award_applications');

        Schema::dropIfExists('ams_adult_leader_moves');

        Schema::dropIfExists('advancement_scouts');

        Schema::dropIfExists('advancement_scouters');

        Schema::dropIfExists('advancement_rovers');

        Schema::dropIfExists('advancement_photos');

        Schema::dropIfExists('advancement_notes');

        Schema::dropIfExists('advancement_meerkats');

        Schema::dropIfExists('advancement_documents');

        Schema::dropIfExists('advancement_cubs');

        Schema::dropIfExists('admin_good_logons');

        Schema::dropIfExists('admin_banned_ips');

        Schema::dropIfExists('admin_bad_logons');

        Schema::dropIfExists('admin_404_pages');
    }
};
