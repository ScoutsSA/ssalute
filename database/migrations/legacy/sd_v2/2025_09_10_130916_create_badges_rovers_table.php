<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('badges_rovers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(0);
            $table->integer('assocToDistrict')->default(0);
            $table->integer('assocToGroup');
            $table->integer('roverID');
            $table->integer('userID')->nullable();
            $table->integer('firstID')->index('firstid');
            $table->integer('secondID')->nullable();
            $table->date('badgeDate');
            $table->text('notes')->nullable();
            $table->string('PDFLocation')->nullable();
            $table->integer('latest')->default(0)->comment('1 = latest');
            $table->string('instructorsName')->nullable();
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->dateTime('approvedDate')->nullable();
            $table->integer('approvedBy')->nullable();

            $table->index(['assocToDistrict', 'firstID', 'active', 'latest'], 'assoctodistrict');
            $table->index(['assocToGroup', 'firstID', 'active', 'latest'], 'assoctogroup');
            $table->index(['assocToRegion', 'firstID', 'active', 'latest'], 'assoctoregion');
            $table->index(['countryID', 'firstID', 'active', 'latest'], 'countryid');
            $table->index(['roverID', 'firstID', 'secondID', 'active'], 'roverid');
            $table->index(['roverID', 'active', 'secondID'], 'scoutid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('badges_rovers');
    }
};
