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
        Schema::create('ams_suspend_leader', function (Blueprint $table) {
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ams_suspend_leader');
    }
};
