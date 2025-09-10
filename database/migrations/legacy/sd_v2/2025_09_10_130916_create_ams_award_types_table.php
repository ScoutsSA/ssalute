<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ams_award_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('headingID')->index('headingid');
            $table->integer('position');
            $table->string('name');
            $table->string('shortName');
            $table->text('description');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ams_award_types');
    }
};
