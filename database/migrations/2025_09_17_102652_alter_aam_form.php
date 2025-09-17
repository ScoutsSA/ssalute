<?php

use App\Models\Forms\ApplicationAdultMembershipRequest;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('forms_aam_requests', function (Blueprint $table) {
            $table->string('view_slug')->after('action_slug');

            $table->dropColumn('has_group_been_notified');
            $table->dropColumn('has_district_been_notified');
            $table->dropColumn('has_regional_been_notified');
            $table->dropColumn('has_national_been_notified');

            $table->renameColumn('declined_reason', 'declined_reason_external');
        });

        foreach (ApplicationAdultMembershipRequest::all() as $aamRequest) {
            $aamRequest->view_slug = Str::uuid();
            $aamRequest->save();
        }
    }

    public function down(): void
    {
        Schema::table('forms_aam_requests', function (Blueprint $table) {
            $table->renameColumn('declined_reason_external', 'declined_reason');

            $table->boolean('has_group_been_notified')->default(false)->after('action_slug');
            $table->boolean('has_district_been_notified')->default(false)->after('has_group_been_notified');
            $table->boolean('has_regional_been_notified')->default(false)->after('has_district_been_notified');
            $table->boolean('has_national_been_notified')->default(false)->after('has_regional_been_notified');

            $table->dropColumn('view_slug');
        });
    }
};
