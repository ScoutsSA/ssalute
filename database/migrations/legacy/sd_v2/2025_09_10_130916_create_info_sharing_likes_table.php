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
        Schema::create('info_sharing_likes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('infoID');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');

            $table->index(['createdby', 'active'], 'createdby');
            $table->index(['infoID', 'active'], 'infoid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_sharing_likes');
    }
};
