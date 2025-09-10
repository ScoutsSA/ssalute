<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('groups_multi', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('type', 15);
            $table->integer('groupID');
            $table->string('name');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['groupID', 'type', 'active'], 'groupid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('groups_multi');
    }
};
