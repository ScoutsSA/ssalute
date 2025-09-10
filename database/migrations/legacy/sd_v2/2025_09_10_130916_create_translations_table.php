<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->string('fromText');
            $table->text('toText');
            $table->integer('active')->default(1);

            $table->index(['countryID', 'active'], 'countryid');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
