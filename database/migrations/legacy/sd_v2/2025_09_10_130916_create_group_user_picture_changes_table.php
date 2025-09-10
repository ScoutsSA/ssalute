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
        Schema::create('group_user_picture_changes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->index('userid');
            $table->text('pictureLocation');
            $table->dateTime('created');
            $table->integer('createdby');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_user_picture_changes');
    }
};
