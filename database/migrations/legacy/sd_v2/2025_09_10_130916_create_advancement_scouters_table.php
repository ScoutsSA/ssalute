<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advancement_scouters', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('assocToGroup')->index('assoctogroup');
            $table->integer('scouterID')->index('scoutid');
            $table->integer('advancementID')->index('advancementid');
            $table->date('advancementDate');
            $table->text('notes')->nullable();
            $table->integer('latest')->comment('1 = latest');
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advancement_scouters');
    }
};
