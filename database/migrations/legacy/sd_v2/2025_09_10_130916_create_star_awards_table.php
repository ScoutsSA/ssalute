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
        Schema::create('star_awards', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('year');
            $table->integer('countryID');
            $table->integer('regionID');
            $table->integer('districtID');
            $table->integer('groupID');
            $table->integer('denID')->nullable();
            $table->integer('packID')->nullable();
            $table->integer('troopID')->nullable();
            $table->integer('patrolID')->nullable();
            $table->integer('crewID')->nullable();
            $table->string('scouterAskedAward', 25)->nullable();
            $table->dateTime('scouterAskedAwardDate')->nullable();
            $table->integer('scouterAskedAwardUserID')->nullable();
            $table->text('scouterMotivation')->nullable();
            $table->string('nptmRecommended', 25)->nullable();
            $table->dateTime('nptmAskedAwardDate')->nullable();
            $table->integer('nptmAskedAwardUserID')->nullable();
            $table->text('nptmMotivation')->nullable();
            $table->string('rtcRecommended', 25)->nullable();
            $table->dateTime('rtcRecommendedDate')->nullable();
            $table->integer('rtcRecommendedUserID')->nullable();
            $table->text('rtcMotivation')->nullable();
            $table->integer('chairAwarded')->nullable();
            $table->dateTime('chairAwardedDate')->nullable();
            $table->integer('chairAwardedUserID')->nullable();
            $table->integer('active');

            $table->index(['groupID', 'year', 'active'], 'groupid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('star_awards');
    }
};
