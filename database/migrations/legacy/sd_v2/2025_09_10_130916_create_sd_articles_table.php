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
        Schema::create('sd_articles', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('catID')->index('catid');
            $table->integer('groupID')->nullable()->default(0);
            $table->string('title')->fulltext('title');
            $table->string('slug');
            $table->text('intro')->fulltext('intro');
            $table->text('article')->fulltext('article');
            $table->integer('active')->index('active');
            $table->dateTime('created');
            $table->string('createdby');
            $table->integer('views')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sd_articles');
    }
};
