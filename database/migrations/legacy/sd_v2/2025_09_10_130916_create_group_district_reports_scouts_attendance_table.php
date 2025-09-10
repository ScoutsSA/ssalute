<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_district_reports_scouts_attendance', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('assocToGroup');
            $table->string('reportMonth', 10);
            $table->integer('nr');
            $table->date('date');
            $table->integer('strength');
            $table->integer('present');
            $table->integer('percent');
            $table->string('comments');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_district_reports_scouts_attendance');
    }
};
