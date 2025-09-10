<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group_events', function (Blueprint $table) {
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
            $table->string('uniqueID', 100)->index('uniqueid');
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
            $table->integer('competitionScoringDefaultPage')->nullable()->default(0);
            $table->integer('competitionScorePrecheck')->nullable()->default(0);
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

            $table->index(['assocToDistrict', 'countryID', 'active', 'endDate', 'eventFor'], 'assoctodistrict');
            $table->index(['assocToGroup', 'countryID', 'active', 'endDate'], 'assoctogroup');
            $table->index(['assocToRegion', 'countryID', 'active', 'endDate', 'eventFor'], 'assoctoregion');
            $table->index(['bookingPossible', 'active'], 'bookingpossible');
            $table->index(['competition', 'active', 'noCopy', 'id'], 'competition');
            $table->index(['countryID', 'nationalEvent', 'active', 'endDate', 'eventFor'], 'countryid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_events');
    }
};
