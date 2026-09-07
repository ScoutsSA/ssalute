<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('ams_charge_types', 'expiryYears')) {
            Schema::table('ams_charge_types', function (Blueprint $table) {
                $table->unsignedInteger('expiryYears')->default(5)->after('forScouts');
            });
        }
    }

    public function down(): void
    {
        Schema::table('ams_charge_types', function (Blueprint $table) {
            $table->dropColumn('expiryYears');
        });
    }
};
