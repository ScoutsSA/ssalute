<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_faq_cats', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('faqGroup')->default(0)->comment('1 = Scouters, 2 = Parents, 3 = Scouts, 4 = AMS');
            $table->integer('position')->default(0);
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('forNational')->default(0);
            $table->integer('forRegion')->default(0);
            $table->integer('forDistrict')->default(0);
            $table->integer('forGroupAdults')->default(0);
            $table->integer('forGroupParents')->default(0);
            $table->integer('forGroupScouts')->default(0);
            $table->integer('forGroupRovers')->default(0);
            $table->integer('forAlumni')->default(0);
            $table->integer('active')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_faq_cats');
    }
};
