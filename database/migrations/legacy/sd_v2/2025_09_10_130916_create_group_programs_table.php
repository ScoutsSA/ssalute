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
        Schema::create('group_programs', function (Blueprint $table) {
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

            $table->index(['assocToGroup', 'active', 'date', 'programType'], 'assoctogroup');
            $table->index(['assocToGroup', 'online', 'active', 'date', 'onlineEndDate'], 'assoctogroup_2');
            $table->index(['programType', 'assocToGroup', 'active', 'date'], 'programtype');
            $table->index(['programType', 'date', 'assocToGroup', 'active'], 'programtype_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_programs');
    }
};
