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
        Schema::create('group_cubs_sixes_names', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->default(196);
            $table->integer('assocToGroup');
            $table->integer('packID')->nullable();
            $table->string('name');
            $table->integer('active')->comment('1 = Active');
            $table->dateTime('created');
            $table->integer('createdby');

            $table->index(['assocToGroup', 'active'], 'assoctogroup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_cubs_sixes_names');
    }
};
