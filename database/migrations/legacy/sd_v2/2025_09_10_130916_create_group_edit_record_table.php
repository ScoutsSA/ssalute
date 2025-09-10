<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_edit_record', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('groupID')->nullable()->index('idx_group_edit_record_groupid');
            $table->longText('fromData')->nullable();
            $table->longText('toData')->nullable();
            $table->dateTime('created')->nullable();
            $table->integer('createdByID')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_edit_record');
    }
};
