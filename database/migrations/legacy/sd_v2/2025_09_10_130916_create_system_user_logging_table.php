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
        Schema::create('system_user_logging', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID')->nullable();
            $table->integer('regionID')->nullable();
            $table->integer('districtID')->nullable();
            $table->integer('groupID')->nullable()->index('assoctogroup');
            $table->integer('userID')->nullable()->index('userid');
            $table->string('page', 1024)->index('page');
            $table->string('IP', 40);
            $table->string('userAgent', 1024)->nullable();
            $table->text('post')->nullable();
            $table->dateTime('created')->index('created');

            $table->index(['countryID', 'IP'], 'countryid');
            $table->index(['IP', 'userID'], 'ip');
            $table->index(['IP', 'page'], 'ip_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_user_logging');
    }
};
