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
        Schema::create('advancement_notes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programType')->default(1);
            $table->integer('type')->nullable()->default(0);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup');
            $table->integer('userID')->index('userid');
            $table->text('note');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->integer('advancementFirstID')->index('advancementfirstid');
            $table->integer('advancementSecondID')->index('advancementsecondid');
            $table->integer('advancementThirdID')->nullable()->index('advancementthirdid');
            $table->integer('active')->default(1);

            $table->index(['assocToGroup', 'userID', 'advancementFirstID', 'advancementSecondID', 'advancementThirdID', 'active'], 'assoctogroup');
            $table->index(['assocToGroup', 'userID', 'advancementFirstID', 'advancementSecondID', 'active'], 'assoctogroup_2');
            $table->index(['type', 'active'], 'type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advancement_notes');
    }
};
