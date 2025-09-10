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
        Schema::create('group_programs_online_tasks', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programID');
            $table->integer('position')->index('position');
            $table->text('task');
            $table->text('needs')->nullable();
            $table->text('description');
            $table->string('PDFLocation', 1024)->nullable();
            $table->integer('advancementID')->nullable();
            $table->integer('badgeID')->nullable();
            $table->integer('points')->nullable()->default(0);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['programID', 'active'], 'programid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_programs_online_tasks');
    }
};
