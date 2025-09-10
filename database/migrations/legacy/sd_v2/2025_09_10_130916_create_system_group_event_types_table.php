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
        Schema::create('system_group_event_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('position');
            $table->string('name');
            $table->integer('active')->comment('1 = Active');
            $table->integer('groupType')->default(0);
            $table->integer('districtType')->default(0);
            $table->integer('regionalType')->default(0);
            $table->integer('nationalType')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_group_event_types');
    }
};
