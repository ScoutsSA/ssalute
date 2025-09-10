<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_attendance', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userId');
            $table->string('userSex', 10)->nullable();
            $table->string('type');
            $table->integer('programId')->nullable();
            $table->integer('eventId')->nullable()->default(0);
            $table->date('programDate');
            $table->integer('assocToGroup')->index('assoctogroup');
            $table->integer('attendance')->comment('1 = Attended');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('moved')->default(0);

            $table->index(['eventId', 'userId'], 'eventid');
            $table->index(['eventId', 'type'], 'eventid_2');
            $table->index(['eventId', 'moved'], 'eventid_3');
            $table->index(['programId', 'type', 'assocToGroup', 'attendance', 'programDate'], 'programid');
            $table->index(['programId', 'userId'], 'programid_2');
            $table->index(['programId', 'attendance', 'type'], 'programid_3');
            $table->index(['programId', 'eventId', 'userId'], 'programid_4');
            $table->index(['programId', 'attendance'], 'programid_5');
            $table->index(['userId', 'attendance', 'assocToGroup'], 'userid');
            $table->index(['userId', 'type', 'attendance', 'programDate', 'programId'], 'userid_2');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_attendance');
    }
};
