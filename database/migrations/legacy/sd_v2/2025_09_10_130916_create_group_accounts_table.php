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
        Schema::create('group_accounts', function (Blueprint $table) {
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

            $table->index(['assocToGroup', 'active', 'groupAccount'], 'assoctogroup');
            $table->index(['assocToGroup', 'active', 'accountType'], 'assoctogroup_2');
            $table->index(['id', 'assocToGroup', 'active', 'groupAccount'], 'id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_accounts');
    }
};
