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
        Schema::create('admin_good_logons', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('username');
            $table->string('password')->nullable();
            $table->dateTime('date');
            $table->string('ip');
            $table->integer('roleID')->nullable();
            $table->integer('fromSD')->default(1);
            $table->integer('groupID')->nullable();
            $table->integer('districtID')->nullable();
            $table->integer('regionID')->nullable();
            $table->integer('countryID')->nullable();
            $table->string('userAgent', 1024)->nullable();
            $table->integer('usingMobile')->nullable();

            $table->index(['districtID', 'date'], 'districtid');
            $table->index(['groupID', 'date'], 'groupid');
            $table->index(['regionID', 'date'], 'regionid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_good_logons');
    }
};
