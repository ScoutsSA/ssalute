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
        Schema::create('jamboree_generated_pdfs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->integer('subCampID')->default(0);
            $table->integer('troopID')->default(0);
            $table->integer('busID')->default(0);
            $table->integer('userID')->default(0);
            $table->string('type')->default('0');
            $table->string('PDFLocation');
            $table->dateTime('created');
            $table->integer('createdby');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jamboree_generated_pdfs');
    }
};
