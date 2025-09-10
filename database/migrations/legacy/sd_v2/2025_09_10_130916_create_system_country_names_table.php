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
        Schema::create('system_country_names', function (Blueprint $table) {
            $table->bigInteger('country_id', true);
            $table->string('country_code', 3);
            $table->string('country_name', 50);
            $table->string('continent_name')->nullable();
            $table->string('region_name')->nullable();
            $table->integer('usingSD')->default(0);
            $table->string('associationName')->nullable();
            $table->string('branch1Name')->nullable();
            $table->integer('branch1ID')->nullable();
            $table->decimal('branch1StartingAge', 3, 1)->default(5);
            $table->decimal('branch1EndingAge', 3, 1)->default(7);
            $table->string('branch2Name')->nullable();
            $table->integer('branch2ID')->nullable();
            $table->decimal('branch2StartingAge', 3, 1)->default(7);
            $table->decimal('branch2EndingAge', 3, 1)->default(11);
            $table->string('branch3Name')->nullable();
            $table->integer('branch3ID')->nullable();
            $table->decimal('branch3StartingAge', 3, 1)->default(11);
            $table->decimal('branch3EndingAge', 3, 1)->default(18);
            $table->string('branch4Name')->nullable();
            $table->integer('branch4ID')->nullable();
            $table->decimal('branch4StartingAge', 3, 1)->default(18);
            $table->decimal('branch4EndingAge', 3, 1)->default(25);
            $table->string('branch5Name')->nullable();
            $table->integer('branch5ID')->nullable();
            $table->decimal('branch5StartingAge', 3, 1)->default(25);
            $table->decimal('branch5EndingAge', 3, 1)->default(35);

            $table->primary(['country_id', 'country_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_country_names');
    }
};
