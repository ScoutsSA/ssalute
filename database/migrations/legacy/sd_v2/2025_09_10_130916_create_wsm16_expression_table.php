<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wsm16_expression', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('roleID');
            $table->integer('active');
            $table->integer('passportCountryID');
            $table->integer('passportChecked')->default(0);
            $table->integer('countryID')->default(196);
            $table->integer('regionID')->default(0);
            $table->integer('districtID')->default(0);
            $table->integer('groupID')->default(0);
            $table->integer('applyRoleID');
            $table->integer('invested')->default(0);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['roleID', 'active'], 'roleid');
            $table->index(['userID', 'active'], 'userid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wsm16_expression');
    }
};
