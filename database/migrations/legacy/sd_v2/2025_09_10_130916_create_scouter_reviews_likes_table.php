<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scouter_reviews_likes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('reviewID');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');

            $table->index(['createdby', 'active'], 'createdby');
            $table->index(['reviewID', 'active'], 'infoid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scouter_reviews_likes');
    }
};
