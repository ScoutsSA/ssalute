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
        Schema::create('info_sharing_reviews', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('infoID');
            $table->string('title');
            $table->text('review');
            $table->integer('stars')->nullable();
            $table->integer('active');
            $table->integer('approved')->default(0);
            $table->integer('declined')->default(0);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->integer('approvedby')->nullable();
            $table->dateTime('approvedDate')->nullable();
            $table->dateTime('declinedDate')->nullable();
            $table->integer('declinedby')->nullable();
            $table->string('declineReason', 1024)->nullable();
            $table->text('declinedNotes')->nullable();

            $table->index(['createdby', 'active', 'approved'], 'createdby');
            $table->index(['infoID', 'active', 'approved'], 'infoid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_sharing_reviews');
    }
};
