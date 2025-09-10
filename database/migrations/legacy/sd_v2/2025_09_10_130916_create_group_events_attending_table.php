<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_events_attending', function (Blueprint $table) {
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

            $table->index(['groupID', 'eventID', 'attending', 'active'], 'assoctogroup');
            $table->index(['eventID', 'groupID', 'roleID', 'active'], 'eventid');
            $table->index(['groupID', 'eventID', 'userID', 'active'], 'groupid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_events_attending');
    }
};
