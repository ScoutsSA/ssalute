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
        Schema::create('badges_documents', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('type')->default(17);
            $table->integer('assocToGroup')->index('assoctogroup');
            $table->integer('userID');
            $table->text('description');
            $table->string('PDFLocation', 1024);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('badgeFirstID')->index('advancementfirstid');
            $table->integer('badgeSecondID')->index('advancementsecondid');
            $table->integer('active')->default(1);

            $table->index(['userID', 'badgeFirstID', 'badgeSecondID', 'type', 'active'], 'userid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badges_documents');
    }
};
