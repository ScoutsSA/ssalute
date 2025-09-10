<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('directory_professional', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('companyName');
            $table->integer('countryID')->default(196);
            $table->string('locationName');
            $table->text('bio');
            $table->text('skills');
            $table->integer('likes')->default(0);
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('pintrest')->nullable();
            $table->string('googlePlus', 1024)->nullable();
            $table->string('website')->nullable();
            $table->string('contactPersonName');
            $table->string('contactEmail')->nullable();
            $table->string('contactTel')->nullable();
            $table->integer('active')->default(1);
            $table->integer('approved')->default(0);
            $table->integer('approvedBy')->nullable();
            $table->dateTime('approvedDate')->nullable();
            $table->integer('declined')->nullable()->default(0);
            $table->integer('declinedBy')->nullable();
            $table->dateTime('declinedDate')->nullable();
            $table->string('declinedReason', 1024)->nullable();
            $table->text('declinedNotes')->nullable();
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['countryID', 'active', 'approved', 'createdby'], 'countryid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('directory_professional');
    }
};
