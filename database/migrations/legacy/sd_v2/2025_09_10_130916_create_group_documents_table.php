<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_documents', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('docType');
            $table->string('docArea')->nullable();
            $table->integer('assocToPerson')->nullable();
            $table->integer('assocToAccount')->default(0);
            $table->integer('assocToGroup');
            $table->string('description');
            $table->string('location', 1024);
            $table->date('expiryDate')->nullable();
            $table->integer('active')->default(1);
            $table->date('created');
            $table->integer('createdby')->default(0);
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['assocToGroup', 'assocToAccount', 'active'], 'assoctogroup');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_documents');
    }
};
