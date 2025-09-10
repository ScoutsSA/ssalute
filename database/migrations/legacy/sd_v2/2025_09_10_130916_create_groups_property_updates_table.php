<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('groups_property_updates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('groupID')->index('groupid');
            $table->integer('updatedby');
            $table->dateTime('updatedDate');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('groups_property_updates');
    }
};
