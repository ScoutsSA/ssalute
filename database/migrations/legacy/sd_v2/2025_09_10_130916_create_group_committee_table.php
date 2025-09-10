<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_committee', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->nullable();
            $table->integer('assocToDistrict')->nullable();
            $table->integer('assocToGroup');
            $table->integer('userID');
            $table->integer('typeID')->index('typeid');
            $table->date('dateAppointed');
            $table->date('dateRemoved')->nullable();
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToGroup', 'userID', 'active'], 'assoctogroup');
            $table->index(['assocToGroup', 'active', 'typeID'], 'assoctogroup_2');
            $table->index(['userID', 'typeID', 'assocToGroup', 'active'], 'userid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_committee');
    }
};
