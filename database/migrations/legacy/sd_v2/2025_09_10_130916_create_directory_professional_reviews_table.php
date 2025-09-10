<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('directory_professional_reviews', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('directoryID');
            $table->text('review');
            $table->integer('stars');
            $table->integer('active')->default(1);
            $table->integer('approved')->default(0);
            $table->integer('approvedBy')->nullable();
            $table->dateTime('approvedDate')->nullable();
            $table->integer('declined')->default(0);
            $table->integer('declinedReasonID')->default(0);
            $table->integer('declinedby')->default(0);
            $table->dateTime('declinedDate')->nullable();
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['directoryID', 'active'], 'directoryid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('directory_professional_reviews');
    }
};
