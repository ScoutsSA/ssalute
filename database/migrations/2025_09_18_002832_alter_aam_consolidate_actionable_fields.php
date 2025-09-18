<?php

use App\Enums\Forms\Aam\AamStatuses;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::table('forms_aam_requests')
            ->where('status', AamStatuses::DECLINED->value)
            ->update([
                'approved_at' => DB::raw('`declined_at`'),
                'approved_by' => DB::raw('`declined_by`'),
            ]);

        Schema::table('forms_aam_requests', function (Blueprint $table) {
            $table->renameColumn('approved_at', 'actioned_at');
            $table->renameColumn('approved_by', 'actioned_by');

            $table->dropColumn('declined_at');
            $table->dropColumn('declined_by');

            $table->renameColumn('declined_notes_internal', 'actioned_notes_internal');
            $table->renameColumn('declined_reason_external', 'actioned_reason_external');
        });
    }

    public function down(): void
    {
        Schema::table('forms_aam_requests', function (Blueprint $table) {
            $table->renameColumn('actioned_at', 'approved_at');
            $table->renameColumn('actioned_by', 'approved_by');
            $table->timestamp('declined_at')->nullable()->after('approved_by');
            $table->foreignId('declined_by')->nullable()->after('declined_at');
            $table->renameColumn('actioned_notes_internal', 'declined_notes_internal');
            $table->renameColumn('actioned_reason_external', 'declined_reason_external');
        });

        \Illuminate\Support\Facades\DB::table('forms_aam_requests')
            ->where('status', AamStatuses::DECLINED->value)
            ->update([
                'declined_at' => DB::raw('`approved_at`'),
                'declined_by' => DB::raw('`approved_by`'),
            ]);

        \Illuminate\Support\Facades\DB::table('forms_aam_requests')
            ->where('status', AamStatuses::DECLINED->value)
            ->update([
                'approved_at' => null,
                'approved_by' => null,
            ]);
    }
};
