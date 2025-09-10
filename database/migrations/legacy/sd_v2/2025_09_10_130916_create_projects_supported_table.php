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
        Schema::create('projects_supported', function (Blueprint $table) {
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

            $table->index(['projectID', 'active'], 'projectid');
            $table->index(['projectID', 'createdby'], 'projectid_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects_supported');
    }
};
