<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jamboree_scouters', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->index('userid');
            $table->string('scouterPosition');
            $table->string('scouterFirst');
            $table->string('scouterSurname');
            $table->string('scouterEmail', 25);
            $table->string('scouterCellNr');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jamboree_scouters');
    }
};
