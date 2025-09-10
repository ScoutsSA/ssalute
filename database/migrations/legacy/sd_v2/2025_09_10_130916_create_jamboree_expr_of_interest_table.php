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
        Schema::create('jamboree_expr_of_interest', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID')->default(1);
            $table->integer('countryID')->default(196)->index('countryid');
            $table->integer('regionID');
            $table->integer('districtID');
            $table->integer('groupID');
            $table->integer('userID');
            $table->integer('parentID')->nullable();
            $table->integer('positionID')->index('positionid');
            $table->integer('passportCountryID')->nullable()->default(0);
            $table->integer('passportCheck')->nullable()->default(0);
            $table->text('notes');
            $table->dateTime('created');
            $table->integer('active')->default(1);
            $table->integer('offeredPosition')->nullable();
            $table->dateTime('offeredPositionDate')->nullable();
            $table->integer('offeredPositionBy')->nullable();
            $table->integer('declinedPosition')->nullable();
            $table->dateTime('declinedPositionDate')->nullable();
            $table->integer('declinedPositionBy')->nullable();
            $table->text('declinedReason')->nullable();

            $table->index(['jamboreeID', 'active'], 'jamboreeid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jamboree_expr_of_interest');
    }
};
