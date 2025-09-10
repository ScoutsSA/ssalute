<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('badges_meerkats', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion')->default(0);
            $table->integer('assocToDistrict')->default(0);
            $table->integer('assocToGroup')->index('assoctogroup');
            $table->integer('meerkatID')->nullable();
            $table->integer('userID');
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

            $table->index(['countryID', 'firstID', 'secondID'], 'countryid');
            $table->index(['userID', 'active', 'secondID'], 'cubid');
            $table->index(['userID', 'firstID', 'secondID', 'active'], 'userid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('badges_meerkats');
    }
};
