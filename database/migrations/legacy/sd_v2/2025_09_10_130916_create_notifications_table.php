<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->integer('groupID');
            $table->integer('districtID');
            $table->integer('regionID');
            $table->integer('countryID');
            $table->string('title');
            $table->string('description');
            $table->text('extended');
            $table->string('colour', 100)->comment('colours are teal, amethyst, ruby, tangerine, lemon, lime, ebony, smoke');
            $table->integer('active')->default(1);
            $table->date('doNotShowBefore');
            $table->date('doNotShowAfter');
            $table->integer('forType')->comment('1 = Group, 2 = District, 3 = Region, 4 = National');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->integer('shown')->default(0);
            $table->dateTime('dismissDate')->nullable();

            $table->index(['userID', 'active', 'shown', 'doNotShowBefore', 'doNotShowAfter'], 'userid_2');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
