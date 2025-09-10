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
        Schema::create('reports_numbers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToRegion');
            $table->integer('assocToDistrict');
            $table->integer('assocToGroup');
            $table->date('month');
            $table->integer('meerkatsM')->default(0);
            $table->integer('meerkatsF')->default(0);
            $table->integer('cubsM')->nullable()->default(0);
            $table->integer('cubsF')->nullable()->default(0);
            $table->integer('scoutsM')->nullable()->default(0);
            $table->integer('scoutsF')->nullable()->default(0);
            $table->integer('roversM')->nullable()->default(0);
            $table->integer('roversF')->nullable()->default(0);
            $table->integer('adultsDenM')->default(0);
            $table->integer('adultsDenF')->default(0);
            $table->integer('adultsPackM')->nullable()->default(0);
            $table->integer('adultsPackF')->nullable()->default(0);
            $table->integer('adultsTroopM')->nullable()->default(0);
            $table->integer('adultsTroopF')->nullable()->default(0);
            $table->integer('adultsCrewM')->default(0);
            $table->integer('adultsCrewF')->default(0);
            $table->integer('adultsGroupM')->nullable()->default(0);
            $table->integer('adultsGroupF')->nullable()->default(0);
            $table->integer('committee')->nullable()->default(0);
            $table->integer('helpers')->nullable()->default(0);
            $table->dateTime('created');

            $table->index(['month', 'assocToRegion'], 'assoctodistrict');
            $table->index(['month', 'assocToDistrict'], 'assoctogroup');
            $table->index(['month', 'countryID'], 'assoctoregion');
            $table->index(['month', 'assocToGroup'], 'month');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports_numbers');
    }
};
