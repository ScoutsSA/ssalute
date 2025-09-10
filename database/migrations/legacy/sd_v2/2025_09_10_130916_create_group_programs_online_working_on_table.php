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
        Schema::create('group_programs_online_working_on', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programID');
            $table->integer('userID');
            $table->dateTime('created')->index('created');
            $table->integer('createdby');

            $table->index(['programID', 'userID'], 'programid');
            $table->index(['userID', 'programID'], 'userid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_programs_online_working_on');
    }
};
