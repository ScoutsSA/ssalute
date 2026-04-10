<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('system_users_other_roles', 'reasonForLeaving')) {
            Schema::table('system_users_other_roles', function (Blueprint $table) {
                $table->text('reasonForLeaving')->nullable()->after('modifiedby');
            });
        }
    }

    public function down(): void
    {
        Schema::table('system_users_other_roles', function (Blueprint $table) {
            $table->dropColumn('reasonForLeaving');
        });
    }
};
