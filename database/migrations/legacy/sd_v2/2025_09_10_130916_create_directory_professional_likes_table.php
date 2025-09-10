<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('directory_professional_likes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('directoryID');
            $table->integer('active')->default(1);
            $table->dateTime('created')->useCurrent();
            $table->integer('createdby');

            $table->index(['directoryID', 'active', 'createdby'], 'directoryid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('directory_professional_likes');
    }
};
