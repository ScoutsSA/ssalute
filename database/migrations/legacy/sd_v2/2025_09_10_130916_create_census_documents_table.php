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
        Schema::create('census_documents', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID');
            $table->integer('regionID')->nullable();
            $table->integer('districtID')->nullable();
            $table->integer('groupID')->nullable();
            $table->string('XLSLocation', 1024);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby')->default(0);

            $table->index(['countryID', 'active'], 'countryid');
            $table->index(['districtID', 'active'], 'districtid');
            $table->index(['groupID', 'active'], 'groupid');
            $table->index(['regionID', 'active'], 'regionid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('census_documents');
    }
};
