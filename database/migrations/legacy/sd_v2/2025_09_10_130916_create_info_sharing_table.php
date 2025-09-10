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
        Schema::create('info_sharing', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('region');
            $table->integer('type')->comment('1 = Hiking, 2 = Camping, 3 = Supplier');
            $table->string('name');
            $table->text('description');
            $table->string('contactPerson');
            $table->string('email')->nullable();
            $table->string('tel')->nullable();
            $table->string('website')->nullable();
            $table->text('address');
            $table->string('gpsLat', 100)->nullable();
            $table->string('gpsLon', 100)->nullable();
            $table->integer('active');
            $table->integer('approved')->default(0);
            $table->integer('approvedby')->nullable();
            $table->dateTime('approvedDate')->nullable();
            $table->integer('declined')->default(0);
            $table->integer('declinedby')->nullable();
            $table->dateTime('declinedDate')->nullable();
            $table->string('declinedReason', 1024)->nullable();
            $table->text('declinedNotes')->nullable();
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['active', 'approved'], 'active');
            $table->index(['type', 'active', 'approved'], 'type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_sharing');
    }
};
