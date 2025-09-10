<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jamboree_application', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->index('userid');
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
            $table->index(['jamboreeID', 'active', 'completed'], 'jamboreeid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jamboree_application');
    }
};
