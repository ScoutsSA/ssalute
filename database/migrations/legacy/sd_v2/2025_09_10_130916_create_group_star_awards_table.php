<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_star_awards', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID');
            $table->integer('regionID');
            $table->integer('districtID');
            $table->integer('groupID');
            $table->integer('year');
            $table->integer('area');
            $table->integer('multiID');
            $table->integer('awardID');
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['countryID', 'active'], 'countryid');
            $table->index(['districtID', 'active'], 'districtid');
            $table->index(['groupID', 'active'], 'groupid');
            $table->index(['regionID', 'active'], 'regionid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_star_awards');
    }
};
