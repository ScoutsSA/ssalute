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
        Schema::create('group_rovers_patrol_names', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup')->index('assoctogroup');
            $table->integer('crewID');
            $table->string('name');
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_rovers_patrol_names');
    }
};
