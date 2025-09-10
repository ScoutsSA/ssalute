<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ams_police_clearance', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->text('result');
            $table->string('documentLocation', 1024)->nullable();
            $table->date('dateDone');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['userID', 'active'], 'userid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ams_police_clearance');
    }
};
