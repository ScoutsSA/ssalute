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
        Schema::create('jamboree_activity_center_bases', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('centerID');
            $table->string('name');
            $table->integer('active');
            $table->integer('concurrentPatrols');
            $table->decimal('hoursLong', 2, 1);
            $table->integer('slots');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jamboree_activity_center_bases');
    }
};
