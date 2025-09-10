<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_programs_online_tasks_images', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('programID');
            $table->integer('taskID');
            $table->integer('userID');
            $table->text('description')->nullable();
            $table->string('location', 1024);
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['programID', 'taskID', 'userID', 'active'], 'programid');
            $table->index(['userID', 'active', 'programID', 'taskID'], 'userid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_programs_online_tasks_images');
    }
};
